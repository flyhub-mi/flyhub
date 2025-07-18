<?php

namespace App\Integration\Channels\WooCommerce\Resources;

use App\Integration\ChannelResource;
use App\Integration\Channels\WooCommerce\Api;
use App\Integration\Channels\WooCommerce\Mapping\CategoryMapper;
use App\Integration\Mapping\Utils;
use Automattic\WooCommerce\HttpClient\HttpClientException;
use Exception;
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
        $this->mapper = new CategoryMapper($channel, $this->configs);
    }

    /**
     * @return array
     */
    public function receive($pg = 1, $lastReceivedAt = null)
    {
        $remoteCategories = $this->api->getAll('products/categories', null, true);
        $remoteRootCategory = Utils::arrayToTree($remoteCategories, 'parent', 'id');

        if (is_array($remoteRootCategory)) {
            $remoteRootCategory = [
                'id' => 0,
                'name' => 'Raiz',
                'menu_order' => 0,
                "children" => $remoteRootCategory
            ];
        }

        $category = $this->mapper->toLocal($remoteRootCategory);

        $childrenData = get($remoteRootCategory, 'children', []);
        $category['children'] = $this->mapChildrenToLocal($childrenData);

        return [$category];
    }

    /**
     * @param array $localCategory
     * @return array
     */
    public function send($localCategory)
    {
        $localCategory = $this->getLocalCategory($localCategory['id']);
        $remoteCategories = $this->api->getAll('products/categories', null, true);

        $batchData = $this->mapBatchData($localCategory, $remoteCategories);
        $response = $this->api->batch('products/categories/batch', $batchData, $remoteCategories);

        $localCategories = Utils::treeToArray($localCategory);

        foreach ($localCategories as $local) {
            $remoteId = $this->findRemoteCategoryId($local, $remoteCategories);

            $this->saveChannelCategory($local['id'], $remoteId, $local['name']);
        }

        return $response;
    }

    /**
     * @param mixed $items
     * @return array
     */
    private function mapChildrenToLocal($items)
    {
        $categories = [];

        foreach ($items as $item) {
            $category = $this->mapper->toLocal($item);

            $children = get($item, 'children', []);
            $category['children'] = $this->mapChildrenToLocal($children);

            $categories[] = $category;
        }

        return $categories;
    }

    /**
     * @param mixed $localCategory
     * @param mixed $remoteCategories
     * @param mixed $parentId = null
     * @throws HttpClientException
     * @throws Exception
     */
    private function mapBatchData($localCategory, $remoteCategories, $batchData = ['create' => [], 'update' => []], $parentId = null)
    {
        $categoryData = $this->mapper->toRemote($localCategory);
        $categoryData['id'] = $this->findRemoteCategoryId($localCategory, $remoteCategories);
        $categoryData['parent'] =  $parentId;
        $localChildren = get($localCategory, 'children', []);

        if (!is_null($categoryData['id'])) {
            $batchData['update'][] = array_merge($categoryData);
        } else if (count($localChildren) > 0) {
            $categoryData = $this->api->create('products/categories', $categoryData);
            $remoteCategories[] = $categoryData;
        } else {
            $batchData['create'][] = $categoryData;
        }

        foreach ($localChildren as $localChild) {
            $batchData = $this->mapBatchData($localChild, $remoteCategories, $batchData, $categoryData['id']);
        }

        return $batchData;
    }
}
