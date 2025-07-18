<?php

namespace App\Integration\Channels\Vendure\Resources;

use App\Integration\ChannelResource;
use App\Integration\Channels\Vendure\Api;
use App\Integration\Channels\Vendure\Mapping\CategoryMapper;

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
        $remoteRootCategories = $this->api->getCollection($pg);
        $categories = [];

        foreach ($remoteRootCategories as $remoteRootCategory) {
            $category = $this->mapper->toLocal($remoteRootCategory);
            $childrenData = get($remoteRootCategory, 'children', []);
            $category['children'] = $this->mapChildren($childrenData);
            $categories[] = $category;
        }

        return $categories;
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

            $childrenData = get($item, 'children_data', []);
            $category['children'] = $this->mapChildren($childrenData);

            $categories[] = $category;
        }

        return $categories;
    }
}
