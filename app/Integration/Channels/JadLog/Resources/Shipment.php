<?php

namespace App\Integration\Channels\JadLog\Resources;

use App\Integration\ChannelResource;
use App\Integration\Channels\JadLog\Api;
use App\Integration\Channels\JadLog\Mapping\ShipmentMapper;

class Shipment extends ChannelResource
{
    /** @var Api $api */
    protected $api;

    /** @var ShipmentMapper $mapper */
    protected $mapper;

    /**
     * @param \App\Models\Tenant\Channel $channel
     * @param array $configs
     */
    public function __construct($channel)
    {
        parent::__construct($channel, 'shipment');

        $this->api = new Api($this->configs);
        $this->mapper = new ShipmentMapper($channel, $this->configs);
    }

    /**
     * @return array
     */
    public function paginationInfo()
    {
        return $this->api->paginationInfo();
    }

    /**
     * @param int $pg
     * @param mixed $lastReceivedAt
     * @return array
     */
    public function receive($pg = 1, $lastReceivedAt = null)
    {
        //$remoteList = [];

        return $this->api->shipmentQuote();


        //$mappedItems = array_map(fn ($item) => $this->mapper->toLocal($item), $remoteList);

        //return $mappedItems;
    }

    /**
     * @param array $localProduct
     * @return array
     */
    public function send($localProduct)
    {
        $response = [];

        return $response;
    }
}
