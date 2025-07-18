<?php

namespace App\Integration\Channels\WooCommerce\Resources;

use function _\get;
use function _\find;
use function _\last;
use function _\uniq;
use InvalidArgumentException;
use Automattic\WooCommerce\HttpClient\HttpClientException;
use App\Integration\Mapping\Utils;
use App\Integration\Channels\WooCommerce\Mapping\ProductMapper;
use App\Integration\ChannelResource;
use App\Integration\Channels\WooCommerce\Api;
use Carbon\Carbon;

class Products extends ChannelResource
{
    protected $api;
    protected $attributes;
    protected $mapper;
    protected $productKeysToUpdate = [
        'manage_stock',
        'regular_price',
        'stock_quantity',
        'attributes',
        'status',
        'type',
        'images',
        'categories',
    ];
    protected $paginationInfo;

    /**
     * @param \App\Models\Tenant\Channel $channel
     * @param array $configs
     */
    public function __construct($channel)
    {
        parent::__construct($channel, 'products');

        $this->api = new Api($this->configs);
        $this->attributes = new Attributes($channel, $this->configs);
        $this->mapper = new ProductMapper($channel, $this->configs);
    }

    /**
     * @return array
     */
    public function paginationInfo()
    {
        return $this->paginationInfo;
    }

    /**
     * @return array
     */
    private function setPaginationInfo()
    {
        return $this->paginationInfo = $this->api->paginationInfo();
    }

    /**
     * @param int $pg
     * @param mixed $lastReceivedAt
     * @return array
     */
    public function receive($pg = 1, $lastReceivedAt = null)
    {
        $params = ['page' => $pg];
        if (!is_null($lastReceivedAt)) {
            $params['modified_after'] = Carbon::parse($lastReceivedAt)->format('Y-m-d H:i:s');
        }

        $remoteProducts = $this->api->get('products', $params);
        $this->setPaginationInfo();

        $remoteProductsWithVariations = array_map(function ($remoteItem) {
            if (count($remoteItem['variations']) > 0) {
                $remoteItem['variations'] = $this->api->getProductVariations($remoteItem['id']);
            }

            return $remoteItem;
        }, $remoteProducts);

        $this->updateLastReceivedAt(last($remoteProductsWithVariations)['date_modified']);

        return array_map(fn($item) => $this->mapper->toLocal($item), $remoteProductsWithVariations);
    }

    /**
     * @param array $localProduct
     * @return array
     */
    public function send($localProduct)
    {
        $response = [];

        $localProduct = $this->getLocalProduct($localProduct['id']);
        $remoteProduct = $this->getRemoteProductWithVariations($localProduct);
        $remoteAttributes = $this->attributes->send($localProduct);
        $mappedData = $this->mapper->toRemote($localProduct, $remoteAttributes);
        $mappedData['categories'] = $this->mapCategories($localProduct);

        $response = $this->saveProductWithVariations($mappedData, $remoteProduct, $remoteAttributes);

        if (!is_null(get($response, 'result.id'))) {
            $remoteCategoryIds = array_map(fn($cat) => $cat['id'], $remoteProduct['categories']);

            $this->saveChannelProduct(
                $localProduct['id'],
                $remoteProduct['id'],
                implode(',', $remoteCategoryIds),
                $remoteProduct['permalink'],
            );
        }

        return $response;
    }

    /**
     * @return null|array
     * @throws InvalidArgumentException
     * @throws HttpClientException
     */
    private function getRemoteProductWithVariations($localProduct)
    {
        $remoteProductId = $this->getChannelProductRemoteId($localProduct['id']);
        $params = ['sku' => $localProduct['sku']];

        return $this->api->getProductWithVariations($remoteProductId, $params);
    }

    /**
     * @param mixed $data
     * @param mixed $remoteProduct
     * @return array
     */
    private function saveProductWithVariations($mappedData, $remoteProduct, $remoteAttributes)
    {
        $response = ['sku' => $mappedData['sku']];

        if (is_null($remoteProduct)) {
            $response['result'] = $this->api->create('products', $mappedData);
        } elseif ($this->needsUpdate($mappedData, $remoteProduct)) {
            $updateData = Utils::filterArrayKeys($mappedData, $this->productKeysToUpdate);
            $response['result'] = $this->api->update('products', $remoteProduct['id'], $updateData);
        }

        $isVariable = count(get($mappedData, 'variations') ?: []);
        $remoteId = get($response, 'result.id');

        if (is_int($remoteId) && $isVariable) {
            $remoteVariations = get($remoteProduct, 'variations', []);

            $response['variations'] = $this->saveProductVariations(
                $remoteId,
                $mappedData['variations'],
                $remoteVariations,
                $remoteAttributes,
            );
        }

        return $response;
    }

    /**
     * @param mixed $data
     * @param mixed $remoteProduct
     * @return array
     */
    private function mapCategories($localProduct)
    {
        $categories = array_map(
            fn($category) => $this->getChannelCategoryRemoteId($category['id']),
            $localProduct['categories'],
        );

        $categories = uniq($categories);

        return array_map(fn($remoteId) => ['id' => $remoteId], $categories);
    }

    /**
     * @param mixed|null $fatherId
     * @param array $data
     * @param array $remoteVariation
     * @return array
     */
    private function saveProductVariations($fatherId, $variations, $remoteVariations, $attributes)
    {
        $batch = ['create' => [], 'update' => []];

        foreach ($variations as $variation) {
            $remoteVariation = find($remoteVariations, ['sku' => $variation['sku']]);

            if (is_null($remoteVariation)) {
                $batch['create'][] = $variation;
            } elseif ($this->needsUpdate($variation, $remoteVariation)) {
                $batch['update'][] = array_merge(Utils::filterArrayKeys($variation, $this->productKeysToUpdate), [
                    'id' => $remoteVariation['id'],
                ]);
            }
        }

        return [
            'data' => $batch,
            'result' => $this->api->batch("products/{$fatherId}/variations", $batch, $remoteVariations),
        ];
    }

    /**
     * @param array $data
     * @param array $remote
     * @return bool
     */
    private function needsUpdate($data, $remote)
    {
        $manageStockChanged = boolval($data['manage_stock']) !== boolval($remote['manage_stock']);
        $stockChanged = intval($remote['stock_quantity']) !== intval($remote['stock_quantity']);
        $regularPriceChanged = floatval($remote['regular_price']) !== floatval($remote['regular_price']);
        $statusChangedToDisabled = $data['status'] !== $remote['status'];

        if ($manageStockChanged || $stockChanged || $regularPriceChanged || $statusChangedToDisabled) {
            return true;
        }

        foreach ($data['attributes'] as $localAttr) {
            $remoteAttr = find($remote['attributes'], ['name' => $localAttr['name']]);
            if (is_null($remoteAttr)) {
                continue;
            }

            if (isset($remoteAttr['options']) && count($localAttr['options']) !== count($remoteAttr['options'])) {
                return true;
            }

            if (isset($remoteAttr['option']) && strval($localAttr['option']) !== strval($remoteAttr['options'])) {
                return true;
            }
        }

        foreach ($data['images'] as $localImg) {
            $remoteImg = find($remote['images'], ['name' => $localImg['name']]);

            if (is_null($remoteImg)) {
                return true;
            }
        }

        return false;
    }
}
