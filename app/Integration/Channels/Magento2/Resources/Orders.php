<?php

namespace App\Integration\Channels\Magento2\Resources;

use App\Integration\ChannelResource;
use App\Integration\Channels\Magento2\Api;
use App\Integration\Channels\Magento2\Mapping\OrderMapper;
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

        $this->api = new Api($this->configs['url'], $this->configs['access_token']);
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

        $mappedOrder['customer_email'] = $customer['email'];
        $mappedOrder['customer_firstname'] = $customer['firstname'];
        $mappedOrder['customer_lastname'] = $customer['lastname'];

        $shipping = get($mappedOrder, 'extension_attributes.shipping_assignments.shipping');

        $shippingAddress = array_merge($shipping['address'], [
            'email' => $customer['email'],
            'firstname' => $customer['firstname'],
            'lastname' => $customer['lastname'],
            'street' => [$shipping['address']['street']]
        ]);
        $billingAddress = array_merge($mappedOrder['billing_address'], [
            'email' => $customer['email'],
            'firstname' => $customer['firstname'],
            'lastname' => $customer['lastname'],
            'street' => [$mappedOrder['billing_address']['street']]
        ]);

        $mappedOrder['extension_attributes']['shipping_assignments'] = [
            ['shipping' => array_merge($shipping, ['address' => $shippingAddress])]
        ];
        $mappedOrder['billing_address'] = $billingAddress;
        $mappedOrder['payment'] = $mappedOrder['payment']['payment'];

        unset($mappedOrder['increment_id']);

        $remoteCustomer = $this->createOrUpdateCustomer($customer);
        $mappedOrder['customer_id'] = $remoteCustomer['id'];

        $remoteItem = $this->api->put('orders/create', ['entity' => $mappedOrder]);

        $this->saveChannelOrder($localOrder['id'], $remoteItem['entity_id']);

        return $remoteItem;
    }

    private function createOrUpdateCustomer($customer)
    {
        $params = [
            'searchCriteria[filterGroups][0][filters][0][conditionType]' => 'eq',
            'searchCriteria[filterGroups][0][filters][0][field]' => 'email',
            'searchCriteria[filterGroups][0][filters][0][value]' => $customer['email']
        ];
        $remoteCustomer = $this->api->list('customers/search', 1, $params);

        if (isset($remoteCustomer['items'][0])) {
            return $remoteCustomer['items'][0];
        }

        return $this->api->save('customers', ['customer' => $customer]);
    }
}
