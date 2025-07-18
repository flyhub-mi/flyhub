<?php

namespace App\Integration\Channels\Medusa\Resources;

use function _\find;
use function _\get;
use function _\last;
use App\Integration\ChannelResource;
use App\Integration\Channels\Medusa\Api;
use App\Integration\Channels\Medusa\Mapping\ProductMapper;

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

        $this->api = new Api($this->configs);
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
        $params = [];

        if (!is_null($lastReceivedAt)) {
            $params = ['updated_at' => ['gt' => $lastReceivedAt]];
        }

        $remoteList = $this->api->list('products', $pg, $params);

        if (isset($remoteList['products'])) {
            $this->updateLastReceivedAt(last($remoteList['products'])['updated_at']);

            return array_map(fn($remoteItem) => $this->mapItem($remoteItem), $remoteList['products']);
        }

        return [];
    }

    private function mapItem($remoteItem)
    {
        $item = $this->mapper->toLocal($remoteItem);
        $variations = $this->mapItemVariations($item['variations'], $remoteItem['variants']);
        $categories = $this->mapItemCategories(get($remoteItem, 'categories', []));
        $images = $this->mapItemImages(get($remoteItem, 'images', []));

        if (is_null(get($item, 'price'))) {
            $price = find($item['prices'], ['currency_code' => 'brl']);
            $item['price'] = get($price, 'amount', 0) / 100;
        }

        return array_merge($item, $variations, $categories, $images);
    }

    private function mapItemVariations($mappedVariations, $remoteVariations)
    {
        foreach ($mappedVariations as $index => $item) {
            if (is_null(get($item, 'price'))) {
                $price = find($remoteVariations[$index]['prices'], ['currency_code' => 'brl']);
                $item['price'] = get($price, 'amount', 0) / 100;
                $mappedVariations[$index] = $item;
            }
        }

        return ['variations' => $mappedVariations];
    }


    private function mapItemCategories($categories)
    {
        return ['categories' => array_map(function ($item) {
            $channelCategory = $this->channel->channelCategories()->where('remote_category_id', $item['id'])->first();

            return [
                'id' => $channelCategory?->category_id,
                'name' => $channelCategory?->remote_category_name,
                'remote_id' => $item['id'],
            ];
        }, $categories)];
    }

    /**
     * @param mixed $images
     * @return array
     */
    private function mapItemImages($images)
    {
        return ['product_images' => array_map(fn($item) => [
            'path' => $item['url'],
            'channel_id' => $this->channel->id,
        ], $images)];
    }
}
