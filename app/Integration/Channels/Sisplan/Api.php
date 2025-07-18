<?php

namespace App\Integration\Channels\Sisplan;

use App\Integration\ChannelApi;
use Illuminate\Support\Facades\Http;

use function _\get;
use function _\head;

class Api extends ChannelApi
{
    protected $baseUri;
    protected $username;
    protected $password;
    protected $params;

    /**
     * Api constructor.
     * @param string $baseUri
     * @param string $username
     * @param string $password
     */
    function __construct($configs)
    {
        $url = get($configs, 'url', '');

        $this->baseUri = $this->prepareUrl($url);
        $this->username = get($configs, 'username', '');
        $this->password = get($configs, 'password', '');
        $this->params = [
            'deposito' => get($configs, 'deposito'),
            'tabpreco' => get($configs, 'tabpreco')
        ];
    }

    /**
     * @return \Illuminate\Http\Client\PendingRequest
     */
    private function client()
    {
        return Http::withHeaders([
            'Accept' => 'application/json',
            'X-Auth-Token' => $this->authenticate()['token'],
        ]);
    }

    /**
     * @return array|mixed
     */
    private function authenticate()
    {
        return Http::withHeaders([
            'Accept' => 'application/json',
            'X-Auth-Username' => $this->username,
            'X-Auth-Password' => $this->password,
        ])->post("{$this->baseUri}/api/authenticate")->json();
    }

    /**
     * @param string $endpoint
     * @param array $params
     * @return mixed
     */
    public function get($endpoint, $params = [])
    {
        return $this->client()
            ->timeout(300) // 5 minutes, this api don't have pagination
            ->get("{$this->baseUri}/{$endpoint}", array_merge($this->params, $params))
            ->json();
    }

    /**
     * @param string $endpoint
     * @param array $data
     * @return mixed
     */
    public function post($endpoint, $data)
    {
        return $this->client()->post("{$this->baseUri}/{$endpoint}", $data)->json();
    }

    /**
     * @param string $endpoint
     * @param array $data
     * @return mixed
     */
    public function put($endpoint, $data)
    {
        return $this->client()->put("{$this->baseUri}/{$endpoint}", $data)->json();
    }

    /**
     * @param string $endpoint
     * @return mixed
     */
    public function delete($endpoint)
    {
        return $this->client()->delete("{$this->baseUri}/{$endpoint}")->json();
    }

    /**
     * @param string $customer
     * @return arrays
     */
    public function getCustomer($cnpj)
    {
        return head($this->get('rest/entidade', ['cnpj' => $cnpj]));
    }
}
