<?php

namespace App\Integration\Channels\MercadoLivre\Resources;

use Dsc\MercadoLivre\Resources\Payment\Payment;
use Dsc\MercadoLivre\Resources\Order\OrderItem;
use Dsc\MercadoLivre\Resources\Order\Order;
use Dsc\MercadoLivre\Resources\Buyer\Buyer;
use Doctrine\Common\Collections\ArrayCollection;
use App\Models\Tenant\Channel;
use App\Integration\Channels\MercadoLivre\Api;
use App\Integration\ChannelResource;

class Orders extends ChannelResource
{
    protected $api;

    /**
     * @param Channel $channel
     */
    public function __construct($channel)
    {
        parent::__construct($channel, 'orders');

        $this->api = new Api($channel);
    }

    /**
     * @param int $pg
     * @param null $lastReceivedAt
     * @return array
     */
    public function receive($pg = 1, $lastReceivedAt = null)
    {
        $remoteList = $this->api->getOrders();

        return $remoteList->map(fn (Order $remoteItem) => [
            'customer' => $this->mapCustomer($remoteItem->getBuyer()),
            'order' => $this->mapOrder($remoteItem),
            'items' => $this->mapOrderItems($remoteItem->getOrderItems()),
            'shippingAddress' => $this->mapOrderAddress($remoteItem, 'shipping'),
            'billingAddress' => $this->mapOrderAddress($remoteItem, 'billing'),
            'payments' => $this->mapPayments($remoteItem->getPayments()),
            'shipments' => [$this->mapShipment($remoteItem->getShipping()->getId())],
        ]);
    }

    /**
     * @param $remoteItem
     * @return array
     */
    public function mapCustomer(Buyer $customer)
    {
        return [
            'name' => $customer->getFirstName() . ' ' . $customer->getLastName(),
            'email' => $customer->getEmail(),
            'phone' => $customer->getPhone()->getNumber(),
            'remote_id' => $customer->getId(),
        ];
    }

    /**
     * @param Order $remoteItem
     * @return array
     */
    public function mapOrder(Order $remoteItem)
    {
        $buyer = $remoteItem->getBuyer();

        return [
            'channel_name' => $this->channel->name,
            'remote_id' => $remoteItem->getId(),
            'status' => $remoteItem->getStatus(),
            'customer_email' => $buyer->getEmail(),
            'customer_name' => $buyer->getFirstName() . ' ' . $buyer->getLastName(),
            'customer_last_name' => $buyer->getFirstName(),
            'grand_total' => $remoteItem->getTotalAmount(),
            'shipping_amount' => $remoteItem->getShipping()->getCost(),
        ];
    }

    /**
     * @param ArrayCollection $orderItems
     * @return array
     */
    public function mapOrderItems(ArrayCollection $orderItems)
    {
        return $orderItems->map(fn (OrderItem $orderItem) => [
            'name' => $orderItem->getItem()->getTitle(),
            'qty_ordered' => $orderItem->getQuantity(),
            'tax_amount' => $orderItem->getSaleFee(),
            'sku' => $orderItem->getItem()->getSellerCustomField(),
            'price' => $orderItem->getUnitPrice(),
        ]);
    }

    /**
     * @param Order $remoteItem
     * @return array
     */
    public function mapOrderAddress(Order $remoteItem, $addressType)
    {
        $buyer = $remoteItem->getBuyer();
        $receiverAddress = $remoteItem->getShipping()->getReceiverAddress();

        return [
            'address_type' => $addressType,
            'name' => "{$buyer->getFirstName()} {$buyer->getLastName()}",
            'gender' => '',
            'cpf_cnpj' => $buyer->getBillingInfo()->getDocNumber(),
            'email' => $buyer->getEmail(),
            'phone' => $buyer->getPhone()->getNumber(),
            'street' => $receiverAddress->getAddressLine(),
            'number' => '',
            'complement' => '',
            'neighborhood' => '',
            'country' => $receiverAddress->getCountry()->getName(),
            'postcode' => $receiverAddress->getZipCode(),
            'state' => $receiverAddress->getState()->getName(),
            'city' => $receiverAddress->getCity()->getName(),
        ];
    }

    /**
     * @param ArrayCollection $orderPayments
     * @return array
     */
    public function mapPayments(ArrayCollection $orderPayments)
    {
        return $orderPayments->map(fn (Payment $payment) => [
            'method' => $payment->getPaymentType(),
            'transaction_id' => $payment->getTransactionOrderId(),
            'issued_date' => $payment->getDateApproved(),
            'total_paid' => $payment->getTotalPaidAmount(),
        ]);
    }

    /**
     * @param string $shippingId
     * @return array
     */
    public function mapShipment($shippingId = '')
    {
        if (empty($shippingId)) return [];

        $shipment = $this->api->getShipment($shippingId);

        return [
            'method' => $shipment->getTrackingMethod(),
            'carrier' => $shipment->getCarrierInfo(),
            'track_number' => $shipment->getTrackingNumber(),
            'total_price' => $shipment->getBaseCost(),
        ];
    }
}
