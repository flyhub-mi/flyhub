<?php

namespace App\Http\Controllers\Tenant;

use App\Models\Tenant\Channel;
use Illuminate\Http\Request;
use App\Integration\Mapping\Utils;
use App\Http\Controllers\BaseController;

class TestController extends BaseController
{
    private $channel;
    private string $model;
    private ?array $configs;

    public function index(Request $request)
    {
        $this->middleware('permission:admin-*');

        set_time_limit(9999);

        // Setup
        $this->channel = Channel::where('code', '=', 'Medusa')->first();
        $this->configs = $this->channel->getConfigs();
        $this->model = 'Categories'; // 'Attributes' || 'AttributeSets' || 'Categories' || 'Products' || 'Orders'

        // Local Resource
        // $localResource = $this->localResource();
        // $result = $localResource->itemsToSend($this->channel);
        $result = ['id' => 69];
        // $result = $localResource->save($this->channel, $result); // Save?

        // $result = \App\Models\Tenant\Product::where('sku', 'SU141002737851943')->first(['id'])->toArray();

        $result = $this->channelSend($result);
        // $result = $this->channelSend($result['id']);
        // $result = _\each($result, fn ($r) => $this->channelSend($r['id']));

        // Test Api Method
        // $result = $this->channelApi('get', 'categories/list'); // channelApi($method, ...$methodArgs)

        // OnlyFirstResult
        // $result = \_\first($result);

        return dd($result);
    }

    /** @return array  */
    protected function channelReceive()
    {
        $classNamespace = Utils::buildNamespace(
            'App\Integration\Channels',
            $this->channel->code,
            'Resources',
            $this->model,
        );

        return (new $classNamespace($this->channel, $this->configs))->receive();
    }

    /**
     * @param Channel $channel
     * @param string $model
     * @param null|array $configs
     * @param mixed $id
     * @return array
     */
    protected function channelSend($id)
    {
        $classNamespace = Utils::buildNamespace(
            'App\Integration\Channels',
            $this->channel->code,
            'Resources',
            $this->model,
        );

        return (new $classNamespace($this->channel, $this->configs))->send(['id' => $id]);
    }

    /**
     * @param array $remoteData
     * @return \App\Integration\Resources\Base
     */
    protected function localResource()
    {
        $classNamespace = Utils::buildNamespace('App\Integration\Resources', $this->model);
        $local = new $classNamespace();

        return $local;
    }

    /**
     * @param string $method
     * @param mixed $methodArgs
     * @return mixed
     */
    protected function channelApi($method, ...$methodArgs)
    {
        $classNamespace = Utils::buildNamespace('App\Integration\Channels', $this->channel->code, 'Api');
        $api = new $classNamespace($this->configs);

        return $api->{$method}(...$methodArgs);
    }
}
