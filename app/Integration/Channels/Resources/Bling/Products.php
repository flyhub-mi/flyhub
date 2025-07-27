<?php

namespace App\Integration\Channels\Resources\Bling;

use App\Integration\ChannelResource;
use App\Integration\Channels\Bling\Api;
use App\Integration\Channels\Bling\Mapping\ProductMapper;
use App\Models\Tenant\Channel;
use Exception;
use Illuminate\Database\Eloquent\MassAssignmentException;

class Products extends ChannelResource
{
    protected $api;
    protected $mapper;

    /**
     * @param Channel $channel
     */
    public function __construct($channel)
    {
        parent::__construct($channel, 'products');

        $this->api = new Api($this->configs);
        $this->mapper = new ProductMapper($this->channel, $this->configs);
    }

    /**
     * @param null|int $pg
     * @return object|array
     * @throws Exception
     * @throws MassAssignmentException
     */
    public function receive($pg = 1, $lastReceivedAt = null)
    {
        $response = $this->api->get('produtos/json/', ['filters' => sprintf(
            'dataAlteracao[%s TO %s]',
            date('d/m/Y', strtotime($this->channel->last_received_at)),
            date('d/m/Y', strtotime(now()))
        )]);
        $remoteProducts = $response['retorno']['produtos'];

        $this->updateLastReceivedAt(last($remoteProducts)['produto']['data']);
        return array_map(fn ($remoteOrder) =>  $this->mapper->toLocal($remoteOrder['produto']), $remoteProducts);
    }
}
