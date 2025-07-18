<?php

namespace App\Integration\Channels\Medusa\Resources;

use App\Integration\ChannelResource;
use App\Integration\Channels\Medusa\Api;
use App\Integration\Channels\Medusa\Mapping\OrderMapper;

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
        $this->mapper = new OrderMapper($this->channel, $this->configs);
    }

    /**
     * @param array $localOrder
     * @return mixed
     * @throws \Exception
     */
    public function send($localOrder)
    {
        $this->throwsErrorIfOrderAlreadyWasSent($localOrder['id']);

        $localOrder = $this->getLocalOrder($localOrder['id']);
        $mappedOrder = $this->mapper->toRemote($localOrder);
        $customer = $mappedOrder['customer'];
        unset($mappedOrder['customer']);

        $remoteCustomer = $this->createOrUpdateCustomer($customer);
        $mappedOrder['customer_id'] = $remoteCustomer['id'];

        $remoteItem = $this->api->save('orders/create', ['entity' => $mappedOrder]);

        $this->saveChannelOrder($localOrder['id'], $remoteItem['entity_id']);

        return $remoteItem;
    }

    private function createOrUpdateCustomer($customer)
    {
        $params = ['q' => ['email' => $customer['email']]];
        $remoteCustomer = $this->api->list('customers', 1, $params);

        if (isset($remoteCustomer['customers'][0])) {
            return $remoteCustomer['customers'][0];
        }

        return $this->api->save('customers', $customer);
    }
}
