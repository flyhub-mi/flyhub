<?php

namespace App\Integration\Channels\Magento;

use function _\head;
use App\Integration\ChannelApi;
use SoapClient;
use App\Integration\Mapping\Utils;

class Api extends ChannelApi
{
    protected $client;
    protected $apiUser;
    protected $apiKey;
    protected $sessionId;

    /**
     * Api constructor.
     * @param array $configs
     * @throws \SoapFault
     */
    function __construct($configs)
    {
        $this->client = new SoapClient($configs['url']);
        $this->apiUser = $configs['api_user'];
        $this->apiKey = $configs['api_key'];
    }

    /**
     * @return mixed
     */
    private function getSessionId()
    {
        if (is_null($this->sessionId)) {
            $this->sessionId = $this->client->login($this->apiUser, $this->apiKey);
        }

        return $this->sessionId;
    }

    /**
     * @param array $filters
     * @return mixed
     */
    public function getProductList($filters = [])
    {
        $response = $this->client->catalogProductList($this->getSessionId(), $filters);

        return $this->parse($response);
    }

    /**
     * @param $productId
     * @param null|object $attributes
     * @return mixed
     */
    public function getProductInfo($productId, $attributes = null)
    {
        $response = $this->client->catalogProductInfo($this->getSessionId(), $productId, null, $attributes);

        return $this->parse($response);
    }

    /**
     * @param $productId
     * @param null|\stdClass $filters
     * @return mixed
     */
    public function getAttributeOptions($attributeCode, $filters = null)
    {
        $response = $this->client->catalogProductAttributeOptions($this->getSessionId(), $attributeCode);

        return $this->parse($response);
    }

    /**
     * @param $IdOrSku
     * @return mixed
     */
    public function getProductStockQty($IdOrSku)
    {
        return $this->client->catalogInventoryStockItemList($this->getSessionId(), [$IdOrSku])[0]->qty;
    }

    /**
     * @param array $customer
     * @param array $products
     * @param array $addresses
     * @param array $orderAdditionalInfo
     * @return mixed
     */
    public function createOrder($data, $orderAdditionalInfo)
    {
        $sessionId = $this->getSessionId();
        $cartId = $this->client->shoppingCartCreate($sessionId);
        $magentoCustomer = $this->getOrCreateCustomer($sessionId, $data['customer']);

        $this->client->shoppingCartCustomerSet($sessionId, $cartId, $magentoCustomer);
        $this->client->shoppingCartCustomerAddresses($sessionId, $cartId, [
            $data['shippingAddress'],
            $data['billingAddress'],
        ]);
        $this->client->shoppingCartProductAdd($sessionId, $cartId, $data['items']);
        $this->client->shoppingCartShippingMethod($sessionId, $cartId, 'flatrate_flatrate');
        $this->client->shoppingCartPaymentMethod($sessionId, $cartId, ['method' => 'checkmo']);

        $orderId = $this->client->shoppingCartOrder($sessionId, $cartId, null, null);
        $comment = Utils::arrayToXml($orderAdditionalInfo);

        $this->client->salesOrderAddComment($sessionId, $orderId, 'processing', $comment);

        return $orderId;
    }

    /**
     * @param string $sessionId
     * @param mixed $customer
     * @return array
     */
    public function getOrCreateCustomer($sessionId, $customer)
    {
        $magentoCustomer = $this->getCustomer($sessionId, 'taxvat', $customer['taxvat']);

        if (is_null($magentoCustomer)) {
            $magentoCustomer = $this->getCustomer($sessionId, 'email', $customer['email']);
        }

        if (is_null($magentoCustomer)) {
            $customerId = $this->client->customerCustomerCreate($this->getSessionId(), $customer);
            $magentoCustomer = array_merge($customer, ['customer_id' => $customerId]);
        }

        $magentoCustomer['mode'] = 'customer';

        return $magentoCustomer;
    }

    /**
     * @param string $sessionId
     * @param string $filterKey
     * @param $filterValue
     * @return array|null
     */
    public function getCustomer($sessionId, $filterKey, $filterValue)
    {
        $customersList = $this->client->customerCustomerList($sessionId, [
            'filter' => [['key' => $filterKey, 'value' => $filterValue]],
        ]);

        return $this->parse(head($customersList));
    }

    /**
     * @param mixed $id
     * @return mixed
     */
    public function getOrder($id)
    {
        return $this->client->salesOrderInfo($this->getSessionId(), $id);
    }

    /**
     * @param object|array $response
     * @return array
     */
    private function parse($response)
    {
        return Utils::objectToArray($response);
    }
}
