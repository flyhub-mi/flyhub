<?php

namespace App\Integration\Channels\WooCommerce;

use function _\some;
use function _\get;
use function _\unionBy;

use Automattic\WooCommerce\HttpClient\HttpClientException;
use Automattic\WooCommerce\Client;
use App\Integration\Mapping\Utils;
use App\FlyHub;
use App\Integration\ChannelApi;

class Api extends ChannelApi
{
    protected $client;

    /**
     * @param array $configs
     * @return void
     */
    function __construct($configs)
    {
        $this->client = new Client($configs['url'], $configs['consumer_key'], $configs['consumer_secret'], [
            'version' => 'wc/v3',
            'query_string_auth' => true,
            'timeout' => 60
        ]);
    }

    /**
     * @return array
     */
    public function paginationInfo()
    {
        $headers = array_change_key_case($this->client->http->getResponse()->getHeaders(), CASE_LOWER);

        return ['total_pages' => intval($headers['x-wp-totalpages']), 'total_items' => intval($headers['x-wp-total'])];
    }

    /**
     * @param string $endpoint
     * @param array $params
     * @param bool $getAllPages
     * @return array
     */
    public function get($endpoint, $params = [])
    {
        if (empty($params['context'])) {
            $params['context'] = 'edit';
        }

        $response = $this->client->get($endpoint, $params);

        return $this->decodeResponse($response);
    }

    /**
     * @param array $params
     * @return array
     */
    public function getOrdersWithCustomer($params = [])
    {
        $orders = $this->get('orders', $params);

        return array_map(function ($order) {
            $order['customer'] = $order['billing'];

            $metaData = [];
            foreach ($order['meta_data'] as $meta) {
                $metaData[$meta['key']] = $meta['value'];
            }
            $order['meta_data'] = $metaData;

            return $order;
        }, $orders);
    }

    /**
     * @param string $endpoint
     * @param array $params
     * @return array
     */
    public function getAll($endpoint, $params = [])
    {
        $data = $this->get($endpoint, $params);

        while (count($data) < $this->paginationInfo()['total_items']) {
            $params['offset'] = strval(count($data));
            $currentPageData = $this->get($endpoint, $params);

            $data = array_merge($data, $currentPageData);
        }

        return $data;
    }

    /**
     * @param string $endpoint
     * @param string|int $id
     * @param null|array $orByQueryParams
     * @return null|array
     * @throws HttpClientException
     */
    public function getOne($endpoint, $id = null, $params = null)
    {
        $response = null;

        if (!is_null($id) && is_int($id)) {
            $response = $this->decodeResponse($this->get("{$endpoint}/{$id}"));
        }

        if (is_null($response) && is_array($params)) {
            $responses = $this->get('products', $params);
            $response = is_array($responses) && count($responses) > 0 ? $responses[0] : null;
        }

        return is_null($response) ? null : $response;
    }

    /**
     * @param mixed|null $id
     * @return array
     * @throws HttpClientException
     */
    public function getProductWithVariations($id = null, $params = null)
    {
        $response = $this->getOne('products', $id, $params);

        if (isset($response['id'])) {
            $response['variations'] =  $this->getProductVariations($response['id']);
        }

        return $response;
    }

    /** @return array  */
    public function getAttributesWithTerms()
    {
        return array_map(
            fn ($item) => array_merge(
                $item,
                ['terms' => $this->get("products/attributes/{$item['id']}/terms")],
            ),
            $this->get('products/attributes'),
        );
    }

    /**
     * @param mixed $id
     * @return array
     * @throws HttpClientException
     */
    public function getProductVariations($id)
    {
        return $this->get("products/{$id}/variations");
    }

    /**
     * @param string $endpoint
     * @param array $data
     * @return array
     */
    public function create($endpoint, $data)
    {
        return $this->decodeResponse($this->client->post($endpoint, $data));
    }

    /**
     * @param string $endpoint
     * @param string $key
     * @param array $data
     * @return array
     */
    public function getOrCreate($endpoint,  $key, $data)
    {
        $val = $data[$key];
        $responses = $this->get($endpoint, [$key => $val]);

        if (is_array($responses) && count($responses) > 0) {
            foreach ($responses as $response) {
                if ($response[$key] === $val) {
                    return $response;
                }
            }
        }

        return $this->create($endpoint, $data);
    }

    /**
     * @param string $endpoint
     * @param string|int $id
     * @param array $data
     * @return array
     */
    public function update($endpoint, $id, $data)
    {
        return $this->decodeResponse($this->client->put("{$endpoint}/{$id}", $data));
    }

    /**
     * @param string $endpoint
     * @param array $items = [ 'create' => [{},{}], 'update' => [{},{}], 'delete' => [1,2], ]
     * @return array
     */
    public function batch($endpoint, $batchData, $mergeResult = [])
    {
        $response = [];

        if ($this->hasItemsOnBatchMethod($batchData, 'create', 'update', 'delete')) {
            $response = $this->decodeResponse($this->client->post($endpoint, $batchData));
        }

        if ($this->hasItemsOnBatchMethod($batchData, 'delete')) {
            $deletedIds = array_map(fn ($deleted) => $deleted['id'], $response['delete']);
            $mergeResult = array_filter($mergeResult, fn ($item) => !in_array($item['id'], $deletedIds));
        }

        if ($this->hasItemsOnBatchMethod($batchData, 'update')) {
            unionBy($mergeResult, $response['update'], 'id');
        }

        if ($this->hasItemsOnBatchMethod($batchData, 'create')) {
            unionBy($mergeResult, $response['create'], 'id');
        }

        return $mergeResult;
    }

    /**
     * @param array $batchData
     * @param mixed $methods
     * @return mixed
     */
    private function hasItemsOnBatchMethod($batchData, ...$methods)
    {
        return some($methods, function ($method) use ($batchData) {
            $methodData = get($batchData, $method);

            return is_array($methodData) && count($methodData) > 0;
        });
    }

    /**
     * @param string $endpoint
     * @param string|int $id
     * @return mixed
     */
    public function delete($endpoint, $id)
    {
        return $this->decodeResponse($this->client->delete("{$endpoint}/{$id}"));
    }

    /**
     * @param string $endpoint
     * @param string $key
     * @param array $data
     * @return array
     */
    public function updateOrCreate($endpoint,  $key, $val, $updateData, $createData)
    {
        $response = $this->get($endpoint, [$key => $val]);

        if (is_array($response) && count($response) > 0) {
            foreach ($response as $item) {
                if ($item[$key] === $val) {
                    return $this->update($endpoint, $item['id'], $updateData);
                }
            }
        }

        return $this->create($endpoint, $createData);
    }

    /** @return array  */
    private function decodeResponse()
    {
        $response = $this->client->http->getResponse();

        if ($response->getCode() !== 200) {
            $code = strval($response->getCode());
            $metadata = Utils::objectToArray($response);
            FlyHub::notifyWithMetaData($code, $metadata);

            return [];
        }

        return json_decode($response->getBody(), true);
    }
}
