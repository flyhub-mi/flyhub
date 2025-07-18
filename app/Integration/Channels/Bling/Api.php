<?php

namespace App\Integration\Channels\Bling;

use App\Integration\ChannelApi;
use Illuminate\Support\Facades\Http;

class Api extends ChannelApi
{
    protected $baseUri = 'https://bling.com.br/Api/v2';
    protected $client;

    /**
     * Api constructor.
     * @param $apikey
     */
    function __construct($configs)
    {
        $this->client = Http::withOptions(['query' => ['apikey' => $configs['apiKey']]]);
    }

    /**
     * @param $endpoint
     * @param array $params
     * @return mixed
     */
    public function get($endpoint, $params = [])
    {
        return $this->client->get("{$this->baseUri}/{$endpoint}", $params)->json();
    }

    /**
     * @param $endpoint
     * @param $body
     * @return mixed
     */
    public function post($endpoint, $body)
    {
        return $this->client->post("{$this->baseUri}/{$endpoint}", $body)->json();
    }

    /**
     * @param $endpoint
     * @param $body
     * @return mixed
     */
    public function put($endpoint, $body)
    {
        return $this->client->put("{$this->baseUri}/{$endpoint}", $body)->json();
    }

    /**
     * @param $endpoint
     * @param $body
     * @return mixed
     */
    public function patch($endpoint, $body)
    {
        return $this->client->patch("{$this->baseUri}/{$endpoint}", $body)->json();
    }

    /**
     * @param $endpoint
     * @return mixed
     */
    public function delete($endpoint)
    {
        return $this->client->delete("{$this->baseUri}/{$endpoint}")->json();
    }
}
