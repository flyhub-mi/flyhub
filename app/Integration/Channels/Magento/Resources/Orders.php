<?php

namespace App\Integration\Channels\Magento\Resources;

use App\Integration\ChannelResource;
use App\Integration\Channels\Magento\Api;
use App\Integration\Channels\Magento\Mapping\OrderMapper;

use function _\get;

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

        $orderAdditionalInfo = [
            'originOrderId' => $localOrder['remote_id'],
            'customer' => $localOrder['customer'],
            'payments' => $localOrder['payments'],
            'shipments' => $localOrder['shipments'],
            'discount_amount' => $localOrder['discount_amount'],
            'shipping_amount' => $localOrder['shipping_amount'],
            'total' => $localOrder['grand_total'],
        ];

        if (get($this->configs, 'compatible_adsomos')) {
            $mappedOrder = $this->formatAddressesToAdsomos($mappedOrder, $localOrder);
        }

        $remoteItem = $this->api->createOrder($mappedOrder, $orderAdditionalInfo);

        $this->saveChannelOrder($localOrder['id'], $remoteItem);

        return $remoteItem;
    }

    private function formatAddressesToAdsomos($mappedOrder, $localOrder)
    {
        $streetFormat = "%s\n%s\n%s\n%s\n";

        $mappedOrder['shippingAddress']['street'] = sprintf(
            $streetFormat,
            $localOrder['shippingAddress']['street'],
            $localOrder['shippingAddress']['number'],
            $localOrder['shippingAddress']['complement'],
            $localOrder['shippingAddress']['neighborhood'],
        );

        $mappedOrder['billingAddress']['street'] = sprintf(
            $streetFormat,
            $localOrder['billingAddress']['street'],
            $localOrder['billingAddress']['number'],
            $localOrder['billingAddress']['complement'],
            $localOrder['billingAddress']['neighborhood'],
        );

        return $mappedOrder;
    }
}
