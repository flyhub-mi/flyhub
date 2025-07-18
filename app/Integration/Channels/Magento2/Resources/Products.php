<?php

namespace App\Integration\Channels\Magento2\Resources;

use function _\get;
use function _\find;
use function _\last;
use App\Integration\ChannelResource;
use App\Integration\Channels\Magento2\Api;
use App\Integration\Channels\Magento2\Mapping\ProductMapper;

class Products extends ChannelResource
{
    protected $api;
    protected $mapper;

    /**
     * @param \App\Models\Tenant\Channel $channel
     * @param array|null $configs
     */
    public function __construct($channel)
    {
        parent::__construct($channel, 'products');

        $this->api = new Api($this->configs['url'], $this->configs['access_token']);
        $this->mapper = new ProductMapper($this->channel, $this->configs);
    }

    /**
     * @return array
     */
    public function paginationInfo()
    {
        return $this->api->paginationInfo();
    }


    /**
     * @param int $pg
     * @param null $lastReceivedAt
     * @return array
     * @throws \Exception
     */
    public function receive($pg = 1, $lastReceivedAt = null)
    {
        $searchCriteria = [];
        $searchCriteria += ['sortOrders[0][filters][0][field]' => 'updated_at'];
        $searchCriteria += ['sortOrders[0][filters][0][direction]' => 'ASC'];

        if ($pg === 1 && !is_null($lastReceivedAt)) {
            $searchCriteria += ['filter_groups[0][filters][0][field]' => 'updated_at'];
            $searchCriteria += ['filter_groups[0][filters][0][condition_type]' => 'gteq'];
            $searchCriteria += ['filter_groups[0][filters][0][value]' => $lastReceivedAt];
        }

        $remoteList = $this->api->list('products', $pg, $searchCriteria);

        if (isset($remoteList['items'])) {
            $this->updateLastReceivedAt(last($remoteList['items'])['updated_at']);

            return array_map(fn ($remoteItem) => $this->mapItem($remoteItem), $remoteList['items']);
        }

        return [];
    }

    private function mapItem($remoteItem)
    {
        $attributes = $this->mapItemAttributes($remoteItem);
        $customAttributes = $this->mapItemCustomAttributes($remoteItem['custom_attributes']);
        $categories = $this->mapItemCategories($remoteItem['custom_attributes']);
        $images = $this->mapItemImages($remoteItem['media_gallery_entries']);
        $variations = $this->mapItemVariations($remoteItem);

        return array_merge($attributes, $customAttributes, $categories, $variations, $images);
    }

    private function mapItemAttributes($remoteItem)
    {
        $customAttributes = $remoteItem['custom_attributes'];

        $attributes = $this->mapper->toLocal($remoteItem);
        $attributes['tenant_id'] = $this->channel->tenant_id;
        $attributes['description'] =  get(find($customAttributes, ['attribute_code' => 'description']), 'value', '');
        $attributes['thumbnail'] = get(find($customAttributes, ['attribute_code' => 'small_image']), 'value', '');
        $attributes['stock_quantity'] = get($this->api->get('stockItems/' . $remoteItem['sku']), 'qty');

        if (!empty($attributes['thumbnail'])) {
            $attributes['thumbnail'] = $this->configs['url'] . '/media/catalog/product' . $attributes['thumbnail'];
        }

        $attributeCodesMapping = ['description' => 'description'];
        foreach ($attributeCodesMapping as $remoteKey => $remotValue) {
            $remoteAtribute = find($customAttributes, ['attribute_code' => $remoteKey]);
            $attributes[$remotValue] =  get($remoteAtribute, 'value', '');
        }

        # TODO remove fixed variable attribute
        $attributes['size'] = get(find($customAttributes, ['attribute_code' => 'tamanho_tinta']), 'value', '');
        $attributes['color'] = get(find($customAttributes, ['attribute_code' => 'cor']), 'value', '');
        if (is_numeric($attributes['size'])) {
            $attributes['size'] = $this->api->getProductAttributeValue('tamanho_tinta', $attributes['size']);
        }
        if (is_numeric($attributes['color'])) {
            $attributes['color'] = $this->api->getProductAttributeValue('cor', $attributes['color']);
        }

        return $attributes;
    }

    private function mapItemCustomAttributes($customAttributes)
    {
        $keysToIgnore = ['description', 'meta_keyword', 'meta_keywords', 'thumbnail'];
        $filteredCustomAttributes = array_filter($customAttributes, fn ($cA) => !in_array($cA['attribute_code'], $keysToIgnore));

        return ['channel_product_attributes' => array_map(function ($item) {
            $value = serialize($item['value']);

            return [
                'code' => $item['attribute_code'],
                'value' => $value,
            ];
        }, $filteredCustomAttributes)];
    }

    private function mapItemCategories($customAttributes)
    {
        $categories = get(find($customAttributes, ['attribute_code' => 'category_ids']), 'value', []);

        return ['categories' => array_map(function ($categoryId) {
            $channelCategory = $this->channel->channelCategories()->where('remote_category_id', $categoryId)->first();

            return [
                'id' => $channelCategory?->category_id,
                'name' => $channelCategory?->remote_category_name,
                'remote_id' => $categoryId,
            ];
        }, $categories)];
    }

    /**
     * @param mixed $images
     * @return array
     */
    private function mapItemImages($images)
    {
        $baseUrl = $this->configs['url'] . '/media/catalog/product';

        return ['product_images' => array_map(fn ($item) => [
            'path' => $baseUrl . $item['file'],
            'channel_id' => $this->channel->id,
        ], $images)];
    }

    /**
     * @param mixed $remoteItem
     * @return array
     */
    private function mapItemVariations($remoteItem)
    {
        $mappedVariations = [];

        if (isset($remoteItem['type']) && $remoteItem['type'] === 'configurable') {
            $mappedVariations = array_map(fn ($option) => $this->mapItem($option), $remoteItem['options']);
        }

        return ['variations' => $mappedVariations];
    }
}
