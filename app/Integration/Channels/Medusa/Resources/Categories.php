<?php

namespace App\Integration\Channels\Medusa\Resources;

use App\Integration\ChannelResource;
use App\Integration\Channels\Medusa\Api;
use App\Integration\Channels\Medusa\Mapping\CategoryMapper;

use function _\get;

class Categories extends ChannelResource
{
    protected $api;
    protected $mapper;

    /**
     * @param \App\Models\Tenant\Channel $channel
     */
    public function __construct($channel)
    {
        parent::__construct($channel, 'categories');

        $this->api = new Api($this->configs);
        $this->mapper = new CategoryMapper($this->channel, $this->configs);
    }

    /**
     * @param int $pg
     * @param null $lastReceivedAt
     * @return array
     * @throws \Exception
     */
    public function receive($pg = 1, $lastReceivedAt = null)
    {
        $remoteRootCategory = $this->api->get('product-categories');

        $category = $this->mapper->toLocal($remoteRootCategory);
        $childrenData = get($remoteRootCategory, 'category_children', []);
        $category['children'] = $this->mapChildren($childrenData);

        return [$category];
    }

    /**
     * @param mixed $items
     * @return array
     */
    private function mapChildren($items)
    {
        $categories = [];

        foreach ($items as $item) {
            $category = $this->mapper->toLocal($item);

            $childrenData = get($item, 'category_children', []);
            $category['children'] = $this->mapChildren($childrenData);

            $categories[] = $category;
        }

        return $categories;
    }

    /**
     * @param array $localCategory
     * @return array
     */
    public function send($localCategory)
    {
        $localCategory = $this->getLocalCategory($localCategory['id']);

        $queryParams = ['q' => $localCategory['name']];
        $remoteCategories = $this->api->list('product-categories', null, $queryParams);
        $remoteCategories = get($remoteCategories, 'product_categories', []);
        $mappedData = $this->mapper->toRemote($localCategory);
        $remoteId = $this->findRemoteCategoryId($localCategory, $remoteCategories);
        unset($mappedData['id']);

        $response = $this->api->save('product-categories', $mappedData, $remoteId);
        $remoteCategory = $response['product_category'];

        $this->saveChannelCategory($localCategory['id'], $remoteCategory['id'], $localCategory['name']);

        return $remoteCategory;
    }
}
