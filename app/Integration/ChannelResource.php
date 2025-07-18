<?php

namespace App\Integration;

use function _\find;
use function _\first;
use function _\get;
use Exception;
use InvalidArgumentException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\InvalidCastException;
use App\Models\Tenant\Category;
use App\Models\Tenant\Product;
use FlyHub;

/**
 * @package App\Integration\ChannelResource
 * @method array receive(?int $pg, ?mixed $lastReceivedAt)
 * @method array send($localResource)
 * @method array paginationInfo()
 * @method array moreInfo($data)
 */
abstract class ChannelResource
{
    protected \App\Models\Tenant\Channel $channel;
    protected string $resource;
    protected array $mapping;
    protected array $configs;

    public function __construct($channel, $resource = '', $mapping = [])
    {
        $this->channel = $channel;
        $this->resource = $resource;
        $this->mapping = $mapping;
        $this->configs = $this->channel->getConfigs();
    }

    /**
     * @param int $id
     * @return array
     * @throws InvalidArgumentException
     */
    protected function getLocalProduct($id)
    {
        return $this->channel->tenant
            ->products()
            ->where('id', $id)
            ->with('variations')
            ->with('variations.images')
            ->with('inventories')
            ->with('images')
            ->with('categories')
            ->first()
            ->toArray();
    }

    /**
     * @param int $id
     * @param null|bool $withChannelProductAttributes
     * @return array
     * @throws InvalidArgumentException
     */
    protected function getLocalOrder($id, $withChannelProductAttributes = false)
    {
        $order = $this->channel->tenant
            ->orders()
            ->with('payments')
            ->with('shippingAddress')
            ->with('billingAddress')
            ->with('items')
            ->with('payments')
            ->with('customer')
            ->with('shipments')
            ->find($id);

        $items = $order->items->toArray();
        $shippingAddress = ($order->shippingAddress ?: $order->billingAddress)->toArray();
        $billingAddress = ($order->billingAddress ?: $order->shippingAddress)->toArray();

        if ($withChannelProductAttributes) {
            $items = array_map(function ($item) {
                $product = $this->getLocalProductBySkuWithParent($item['sku']);

                if (!is_null($product)) {
                    $product = $product->toArray();
                    $product['channelProduct'] = $this->getChannelProductWithAttributtes($product['id']);

                    if (isset($product['parent']['id'])) {
                        $product['parent']['channelProduct'] = $this->getChannelProductWithAttributtes(
                            $product['parent']['id'],
                        );
                    }

                    return array_merge($item, ['product' => $product]);
                }
            }, $items);
        }

        return array_merge($order->toArray(), [
            'items' => $items,
            'shippingAddress' => $shippingAddress,
            'billingAddress' => $billingAddress,
        ]);
    }

    /**
     * @param int $id
     * @return array
     * @throws InvalidArgumentException
     */
    protected function getLocalCategory($id)
    {
        return first(Category::descendantsAndSelf($id)->toTree()->toArray());
    }

    /**
     * @param string $sku
     * @return Product|null
     * @throws InvalidArgumentException
     */
    protected function getLocalProductBySkuWithParent($sku)
    {
        $productFields = ['id', 'sku', 'name', 'color', 'size', 'parent_id'];

        return Product::where('sku', $sku)
            ->with('parent', fn ($query) => $query->select($productFields))
            ->select($productFields)
            ->first();
    }

    /**
     * @param int $localId
     * @param string|int $remoteId
     * @param string $remoteId
     */
    protected function saveChannelCategory($localId, $remoteId, $name)
    {
        $this->channel->channelCategories()->updateOrCreate(
            ['category_id' => $localId],
            ['remote_category_id' => $remoteId, 'remote_category_name' => $name]
        );
    }

    /**
     * @param \App\Models\Tenant\Channel $channel
     * @param int|string $localId
     * @param null|string|int $remoteId
     */
    protected function saveChannelCustomer($localId, $remoteId = null)
    {
        $this->channel
            ->channelCustomers()
            ->updateOrCreate(['customer_id' => $localId], ['remote_customer_id' => $remoteId]);
    }

    /**
     * @param int|string $localId
     * @param null|string|int $remoteId
     */
    protected function saveChannelOrder($localId, $remoteId = null)
    {
        $this->channel->channelOrders()->updateOrCreate(['order_id' => $localId], ['remote_order_id' => $remoteId]);
    }

    /**
     * @param mixed $localId
     * @param mixed|null $remoteId
     * @param mixed|null $remoteCategoryId
     * @param mixed|null $remoteLink
     * @return void
     * @throws InvalidArgumentException
     * @throws InvalidCastException
     */
    protected function saveChannelProduct($localId, $remoteId = null, $remoteCategoryId = null, $remoteLink = null)
    {
        $this->channel->channelProducts()->updateOrCreate(
            ['product_id' => $localId],
            [
                'remote_product_id' => $remoteId,
                'remote_category_id' => $remoteCategoryId,
                'remote_link' => $remoteLink,
            ],
        );
    }

    /**
     * @param array $product
     * @return int
     * @throws \Exception
     */
    protected function findChannelProductRemoteCategoryId($product)
    {
        $channelCategory = $this->channel
            ->categories()
            ->where('category_id', $product['main_category_id'])
            ->first();
        if (!is_null($channelCategory) && is_string($channelCategory->remote_category_id)) {
            return $channelCategory->remote_category_id;
        }

        $channelProduct = $this->channel
            ->channelProducts()
            ->where('product_id', $product['id'])
            ->first();
        if (!is_null($channelProduct) && is_string($channelProduct->remote_category_id)) {
            return $channelProduct->remote_category_id;
        }

        throw new \Exception('Necessário mapear a categoria do produto no canal. SKU: ' . $product['sku']);
    }

    /**
     * @param mixed $localId
     * @param string $categoryName
     * @param mixed $remoteCategories
     * @return array|null
     */
    protected function findRemoteCategoryId($localCategory, $remoteCategories)
    {
        $localId = get($localCategory, 'id');
        $remoteId = $this->getChannelCategoryRemoteId($localId);

        $remoteCategory = find($remoteCategories, ['id' => $remoteId]);

        if (is_null($remoteCategory)) {
            $name = trim($localCategory['name']);
            $remoteCategory = find($remoteCategories, ['name' => $name]);
        }

        return get($remoteCategory, 'id');
    }

    /**
     * @param mixed $orderId
     * @return object|null
     * @throws InvalidArgumentException
     */
    protected function getChannelOrder($orderId)
    {
        return $this->channel
            ->channelOrders()
            ->where('order_id', $orderId)
            ->first();
    }

    /**
     * @param int|string $productId
     * @param bool|null $withAttributes
     * @return \App\Models\Tenant\ChannelProduct
     */
    protected function getChannelProduct($productId, $withAttributes = false)
    {
        $query = $this->channel->channelProducts()->where('product_id', $productId);

        return ($withAttributes ? $query->with('attributes') : $query)->first();
    }

    /**
     * @param int|string $productId
     * @return string|null
     */
    protected function getChannelProductRemoteId($productId)
    {
        $channelProduct = $this->getChannelProduct($productId);

        return $channelProduct?->remote_product_id;
    }

    /**
     * @param int|string $categoryId
     * @return string|null
     */
    protected function getChannelCategoryRemoteId($categoryId)
    {
        $channelCategory = $this->channel->channelCategories()->where('category_id', $categoryId)->first();

        return $channelCategory?->remote_category_id;
    }

    /**
     * @param int|string $productId
     * @return array
     */
    protected function getProductAttributes($productId)
    {
        $channelProduct = $this->channel
            ->channelProducts()
            ->with('attributes')
            ->where('product_id', $productId)
            ->first();

        if (is_null($channelProduct)) {
            return [];
        }

        return $channelProduct
            ->attributes()
            ->get()
            ->toArray();
    }

    protected function getChannelProductWithAttributtes($productId)
    {
        $channelProduct = $this->getChannelProduct($productId, true)->first();

        if (!is_null($channelProduct)) {
            $channelProduct = $channelProduct->toArray();
            $channelProduct['attributes'] = array_map(
                fn ($attribute) => [$attribute['key'] => $attribute['value']],
                $channelProduct['attributes'],
            );
        }

        return $channelProduct;
    }

    /**
     * @param string|int $orderId
     * @return void
     * @throws InvalidArgumentException
     * @throws Exception
     */
    protected function throwsErrorIfOrderAlreadyWasSent($orderId)
    {
        $channelOrder = $this->getChannelOrder($orderId);
        $remoteId = get($channelOrder, 'remote_order_id');

        if (!is_null($remoteId)) {
            throw new \Exception("Pedido já enviado #{$remoteId}.");
        }
    }

    /**
     * @param mixed $date
     */
    protected function updateLastReceivedAt($date)
    {
        $this->channel->setLastReceivedAt($this->resource, $date);
    }

    /**
     * @param array|string $content
     * @return string
     */
    protected function saveLog($content, $logID, $type, $logResultID = '')
    {
        $folder = "logs/{$logID}";
        $fileName = empty($logResultID) ? '' : "{$logResultID}-$type";
        $fileExt = 'txt';

        if (is_array($content)) {
            try {
                $content = json_encode($content);
                $fileExt = 'json';
            } catch (\Exception $e) {
                FlyHub::notifyException($e);
                $content = serialize($content);
                $fileExt = 'data';
            }
        }

        $path = "{$folder}/{$fileName}.{$fileExt}";
        Storage::disk('s3')->put($path, $content);
        return $path;
    }
}
