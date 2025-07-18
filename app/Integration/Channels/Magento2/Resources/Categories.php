<?php

namespace App\Integration\Channels\Magento2\Resources;

use App\Integration\ChannelResource;
use App\Integration\Channels\Magento2\Api;
use App\Integration\Channels\Magento2\Mapping\CategoryMapper;

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

        $this->api = new Api($this->configs['url'], $this->configs['access_token']);
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
        $remoteRootCategory = $this->api->get('categories');

        $category = $this->mapper->toLocal($remoteRootCategory);
        $childrenData = get($remoteRootCategory, 'children_data', []);
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

            $childrenData = get($item, 'children_data', []);
            $category['children'] = $this->mapChildren($childrenData);

            $categories[] = $category;
        }

        return $categories;
    }
}
