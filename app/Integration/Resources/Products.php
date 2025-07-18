<?php

namespace App\Integration\Resources;

use function _\find;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Tenant\ProductRepository;
use App\Models\Tenant\Channel;
use App\FlyHub;
use App\Models\Tenant\Product;

class Products extends Base
{
    /**
     * @param array $mappedItems
     * @param \App\Models\Tenant\Channel $channel
     * @return array
     * @throws \Throwable
     */
    public function save($channel, $mappedItems = [])
    {
        $results = [];
        $repository = new ProductRepository();

        foreach ($mappedItems as $values) {
            try {
                $values = $this->setChannelOnValues($values, $channel);
                $attributes = ['sku' => $values['sku']];
                $product = $repository->updateOrCreate($attributes, $values);

                if (isset($values['channel_product_attributes'])) {
                    $this->saveChannelProductAttributes($channel, $product, $values);
                }

                if (isset($values['variations']) && count($values['variations']) > 0) {
                    $product->variations->each(function ($variation) use ($channel, $values) {
                        if (isset($variation['channel_product_attributes'])) {
                            $this->saveChannelProductAttributes($channel, $variation, find($values['variations'], ['sku' => $variation->sku]));
                        }
                    });
                }

                if (isset($values['remote_id'])) {
                    $this->saveChannelProduct($channel, $product->id, $values['remote_id']);
                }

                if (isset($values['categories']) && count($values['categories']) > 0) {
                    foreach ($values['categories'] as $category) {
                        if (isset($category['remote_id'])) {
                            $this->saveChannelCategory($channel, $product, $category);
                        }
                    }
                }

                $results[] = $this->getData($product);
            } catch (\Exception $e) {
                FlyHub::notifyExceptionWithMetaData($e, $values);
                $results[] = $e->getMessage();
            } catch (\Throwable $e) {
                FlyHub::notifyExceptionWithMetaData($e, $values);
                $results[] = $e->getMessage();
            }
        }

        return $results;
    }

    private function setChannelOnValues($values, $channel)
    {
        if (isset($values['images'])) {
            $values['images'] = $this->setChannelOnImages($values['images'], $channel);
        }

        if (isset($values['variations'])) {
            $values['variations'] = array_map(function ($variation) use ($channel) {
                if (isset($values['images'])) {
                    $variation['images'] = $this->setChannelOnImages($variation['images'], $channel);
                }

                return $variation;
            }, $values['variations']);
        }

        return $values;
    }

    private function setChannelOnImages($images, $channel)
    {
        return array_map(function ($image) use ($channel) {
            $image['channel_id'] = $channel->id;

            return $image;
        }, $images);
    }

    /**
     * @param \App\Models\Tenant\Channel $channel
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return bool
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function canSend($channel, $model)
    {
        if (!$channel->can('send', 'products')) {
            return false;
        }

        return $channel->getConfig('products_sync') == 'all' || $this->canSyncChannelProduct($channel, $model);
    }

    /**
     * @param \App\Models\Tenant\Channel $channel
     * @return bool
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    private function canSyncChannelProduct($channel, $model)
    {
        return $channel
            ->channelProducts()
            ->where('product_id', $model->parent_id ?: $model->id)
            ->exists();
    }

    /**
     * @param Model $resource
     * @return array
     */
    public function getData($model)
    {
        return ['id' => $model->parent_id ?: $model->id, 'remote_id' => $model->remote_id, 'sku' => $model->sku];
    }

    /**
     * @param \App\Models\Tenant\Channel $channel
     * @param \App\Models\Product $product
     * @param array $values
     * @return mixed
     */
    private function saveChannelProductAttributes($channel, $product, $values)
    {
        $channelProduct = $channel->channelProducts()->updateOrCreate(
            ['channel_id' => $channel->id, 'product_id' => $product->id],
            ['remote_product_id' => $product->remote_id]
        );

        foreach ($values['channel_product_attributes'] as $cProdAttrValues) {
            $channelProduct->attributes()->updateOrCreate(
                ['code' => $cProdAttrValues['code']],
                ['value' => $cProdAttrValues['value']],
            );
        }
    }

    /**
     * @param Model|Channel $channel
     * @return array
     */
    public function itemsToSend($channel)
    {
        $query = [];

        if ($channel->getConfig('products_sync') == 'all') {
            $query = Product::where('parent_id', null);
        } else {
            $query = $channel->channel_products()
                ->select('product.id as id')
                ->select('product.updated_at as updated_at')
                ->where('product.parent_id', null);
        }

        $lastSendAt = $channel->getLastSendAt('products');
        if (!is_null($lastSendAt)) {
            $query = $query->where('updated_at', '>', $lastSendAt);
        }

        $query = $query->orderBy('updated_at')->limit(1000);

        return $query->get(['id', 'updated_at'])->toArray();
    }


    /**
     * @param \App\Models\Tenant\Channel $channel
     * @param mixed $localId
     * @param mixed|null $remoteId
     * @return void
     */
    protected function saveChannelProduct($channel, $localId, $remoteId)
    {
        $channel->channelProducts()->updateOrCreate(
            ['product_id' => $localId],
            [
                'remote_product_id' => $remoteId,
            ],
        );
    }

    /**
     * @param \App\Models\Tenant\Channel $channel
     * @param \App\Models\Tenant\Product $product
     * @param void
     */
    protected function saveChannelCategory($channel, $product, $values)
    {
        $category = $product->categories()->whereRaw("LOWER(name) LIKE LOWER(?)", $values['name'])->first();

        if (!is_null($category)) {
            $channel->channelCategories()->updateOrCreate(
                ['category_id' => $category->id],
                ['remote_category_id' => $values['remote_id'], 'remote_category_name' => $category->name]
            );
        }
    }
}
