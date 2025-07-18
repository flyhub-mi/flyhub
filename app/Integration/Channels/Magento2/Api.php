<?php

namespace App\Integration\Channels\Magento2;

use App\Integration\ChannelApi;
use Illuminate\Support\Facades\Http;
use FlyHub;

class Api extends ChannelApi
{
    protected $baseUrl;
    protected $client;
    protected $paginationInfo;

    /**
     * Api constructor.
     * @param string $baseUrl
     * @param string $accessToken
     */
    function __construct($baseUrl,  $accessToken)
    {
        $this->baseUrl = "{$baseUrl}/rest/V1";
        $this->client = Http::withToken($accessToken)->timeout(120);
    }

    /**
     * @return array
     */
    public function paginationInfo()
    {
        return $this->paginationInfo;
    }

    /**
     * @param string $endpoint
     * @param array $queryParams
     * @return array
     * @throws \RequestException
     */
    public function get($endpoint, $queryParams = [])
    {
        return $this->client->get("{$this->baseUrl}/{$endpoint}", $queryParams)->json();
    }

    /**
     * @param string $endpoint
     * @param int $pageSize
     * @param int $currentPage
     * @param array $searchCriteria https://devdocs.magento.com/guides/v2.4/rest/performing-searches.html
     */
    public function list($endpoint, $currentPage = 1, $searchCriteria = [])
    {
        $pageSize = FlyHub::LIMIT_PER_PAGE;
        $params = array_merge(
            ['searchCriteria[pageSize]' => $pageSize],
            ['searchCriteria[currentPage]' => $currentPage],
            $searchCriteria
        );

        $result = $this->get($endpoint, $params);

        if (isset($result['total_count']) && $result['total_count'] > $pageSize) {
            $total_items = intval($result['total_count']);
            $total_pages = ceil($total_items / $pageSize);

            $this->paginationInfo = [
                'total_pages' => $total_pages,
                'total_items' => $total_items
            ];
        }

        return $result;
    }

    /**
     * @param string $endpoint
     * @param int|string $id
     * @return array
     * @throws \Exception
     */
    public function show($endpoint, $id, $queryParams = [])
    {
        return $this->get("{$endpoint}/{$id}", $queryParams);
    }

    /**
     * @param string $endpoint
     * @param array $data
     * @param string|int|null $id
     * @return array
     * @throws \Exception
     */
    public function save($endpoint, $data, $id = null)
    {
        $response = is_null($id)
            ? $this->client->post("{$this->baseUrl}/{$endpoint}", $data) // create
            : $this->client->put("{$this->baseUrl}/{$endpoint}/{$id}", $data);

        return $response->json(); // update
    }

    /**
     * @param string $endpoint
     * @param array $data
     * @param string|int|null $id
     * @return array
     * @throws \Exception
     */
    public function put($endpoint, $data)
    {
        return $this->client->put("{$this->baseUrl}/{$endpoint}", $data)->json();
    }

    /**
     * @param string $code
     * @param int|string $value
     * @return mixed
     * @throws \Exception
     */
    public function getProductAttributeValue($code, $value)
    {
        $attribute = $this->get("products/attributes/{$code}");

        if (isset($attribute) && is_array($attribute['options'])) {
            $result['label'] = $attribute['default_frontend_label'];

            foreach ($attribute['options'] as $option) {
                if ($option['value'] === $value) {
                    return $option['label'];
                }
            }
        }

        return '';
    }

    public function getAttributeSets($pg = 1, $attributeSets = [])
    {
        $attributeSetsList =  $this->list('products/attribute-sets/sets/list', $pg);

        if ($attributeSetsList['total_count'] > count($attributeSets)) {
            $attributeSets = $this->getAttributeSets($pg + 1, $attributeSets);
        }

        return $attributeSets;
    }
}
