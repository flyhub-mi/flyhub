<?php

namespace App\Integration\Channels\WooCommerce\Resources;

use App\Integration\ChannelResource;
use App\Integration\Channels\WooCommerce\Api;
use App\Integration\Channels\WooCommerce\Mapping\OrderMapper;
use Carbon\Carbon;

class Orders extends ChannelResource
{
    protected $api;
    protected $mapper;

    /**
     * @param \App\Models\Tenant\Channel $channel
     */
    public function __construct($channel)
    {
        parent::__construct($channel, 'orders');

        $this->api = new Api($this->configs);
        $this->mapper = new OrderMapper($channel, $this->configs);
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
     * @param null $lastReceivedAt
     * @return array
     */
    public function receive($pg = 1, $lastReceivedAt = null)
    {
        $params = ['page' => $pg];
        if (!is_null($lastReceivedAt)) {
            $params['modified_after'] = Carbon::parse($lastReceivedAt)->format('Y-m-d H:i:s');;
        }
        $remoteList = $this->api->getOrdersWithCustomer($params);

        return array_map(fn ($item) => $this->mapper->toLocal($item), $remoteList);
    }

    /**
     * @param array $localOrder
     * @return array
     */
    public function send($localOrder)
    {
        $this->throwsErrorIfOrderAlreadyWasSent($localOrder['order']['id']);

        $mappedOrder = $this->mapper->toRemote($localOrder);
        $remoteItem = $this->api->create('orders', $mappedOrder);

        $this->saveChannelOrder($localOrder['order']['id'], $remoteItem['id']);

        return $remoteItem;
    }
}
