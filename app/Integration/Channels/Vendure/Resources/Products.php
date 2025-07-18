<?php

namespace App\Integration\Channels\Vendure\Resources;

use App\Integration\ChannelResource;
use App\Integration\Channels\Vendure\Api;
use App\Integration\Channels\Vendure\Mapping\ProductMapper;
use Carbon\Carbon;

use function _\get;

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

    public function receive($pg = 1, $lastReceivedAt = null)
    {
        if (!is_null($lastReceivedAt)) {
            $lastReceivedAt = Carbon::parse($lastReceivedAt)->utc();
        }
        $remoteIems = $this->api->getProducts($pg, $lastReceivedAt);
        $products = [];

        foreach ($remoteIems as $remoteItem) {
            $product = $this->mapper->toLocal($remoteItem);
            if (empty($product['sku'])) {
                $product['sku'] = $remoteItem['slug'];
            }
            $product['variations'] = $this->mapVariations($remoteItem['variants']);
            $products[] = $product;
        }

        return $products;
    }

    public function send($localProduct)
    {
        $response = [];

        $localProduct = $this->getLocalProduct($localProduct['id']);
        $remoteProduct = $this->getRemoteProductWithVariations($localProduct);
        $remoteAttributes = $this->attributes->send($localProduct);
        $mappedData = $this->mapper->toRemote($localProduct, $remoteAttributes);
        $mappedData['categories'] = $this->mapCategories($localProduct);

        $response = $this->api->createProduct($mappedData);

        if (!is_null(get($response, 'id'))) {
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
     * @param mixed $items
     * @return array
     */
    private function mapVariations($items)
    {
        $variations = [];

        foreach ($items as $item) {
            $variation = $this->mapper->toLocal($item);

            $variations[] = $variation;
        }

        return $variations;
    }
}
