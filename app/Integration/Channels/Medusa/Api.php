<?php

namespace App\Integration\Channels\Medusa;

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
     * @param string $apiToken
     */
    function __construct($configs)
    {
        $this->baseUrl = $configs['url'] . "/admin";
        $accessToken = $this->getAuth($configs);
        $this->client = Http::withToken($accessToken)->timeout(120);
    }

    private function getAuth($configs)
    {
        $response = Http::post("{$this->baseUrl}/auth/token", [
            'email' => $configs['email'],
            'password' => $configs['password'],
        ])->json();

        return $response['access_token'];
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
     * @param int $pageSize
     * @param int $currentPage
     * @param array $params https://docs.medusajs.com/v1/api/admin#products_getproducts
     */
    public function list($endpoint, $currentPage = 1, $params = [])
    {
        $pageSize = FlyHub::LIMIT_PER_PAGE;
        $params = [
            'limit' => $pageSize,
            'offset' => $currentPage - 1>0 ? (($currentPage - 1) * $pageSize) : 0,
            ...$params
        ];
        $result = $this->get($endpoint, $params);

        if (isset($result['count']) && $result['count'] > $pageSize) {
            $total_items = intval($result['count']);
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
            : $this->client->post("{$this->baseUrl}/{$endpoint}/{$id}", $data);

        return $response->json(); // update
    }
}
