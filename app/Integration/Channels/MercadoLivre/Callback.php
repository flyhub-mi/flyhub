<?php

namespace App\Integration\Channels\MercadoLivre;

use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Request;
use Dsc\MercadoLivre\Resources\Payment\Payment;
use Dsc\MercadoLivre\Resources\Order\OrderService;
use Dsc\MercadoLivre\Resources\Order\OrderItem;
use App\Models\Tenant\ChannelConfig;
use App\Integration\ChannelCallback;
use App\FlyHub;

class Callback extends ChannelCallback
{
    protected $channel;

    /**
     * @param string $channelCode
     * @param Request $request
     * @return void
     * @throws BadRequestException
     */
    public function __construct($channelCode, Request $request)
    {
        $channelConfig = ChannelConfig::where('seller_id', $request->input('user_id'));

        if (is_null($channelConfig)) {
            FlyHub::notifyWithMetaData('Erro ao processar o retorno', $request->input(), true);
        }

        parent::__construct($channelCode, $request);
    }

    /**
     * @param Request $request
     * @return void
     */
    public function process($request)
    {
        $resourceArray = explode('/', $request->get('resource'));
        $resourceId = end($resourceArray);

        if ($request->input('topic') == 'orders') {
            // TODO
            //$orderService = new OrderService($api);
            //$this->processOrder($orderService, $resourceId, $channel);
        }
    }

    /**
     * @param OrderService $orderService
     * @param string $orderId
     * @param \App\Models\Tenant\Channel $channel
     */
    private function processOrder($orderService, $orderId, $channel)
    {
        $channelOrder = $orderService->findOrder($orderId);

        if (!is_null($channelOrder)) {
            $buyer = $channelOrder->getBuyer();
            $shipping = $channelOrder->getShipping();
            $shippingAddress = $shipping->getReceiverAddress();
            $orderItems = $channelOrder->getOrderItems();
            $orderPayments = $channelOrder->getPayments();

            $localOrder = $channel->orders()->updateOrCreate(
                [
                    'channel_order_id' => $channelOrder->getId(),
                ],
                [
                    'channel_name' => $channel->code,
                    'customer_email' => $buyer->getEmail(),
                    'customer_name' => $buyer->getFirstName() . ' ' . $buyer->getLastName(),

                    'shipping_method' => $shipping->getShipmentType(),
                    'shipping_amount' => $shipping->getCost(),
                    'total_item_count' => $orderItems->count(),
                    'total_qty_ordered' => 1,
                    'grand_total' => $channelOrder->getTotalAmount(),
                    'status' => $channelOrder->getStatus(),
                ],
            );

            $customer = $localOrder->customer()->updateOrCreate(
                [
                    'email' => $buyer->getEmail(),
                    'channel_id' => $channel->id,
                ],
                [
                    'name' => $buyer->getFirstName() . ' ' . $buyer->getLastName(),
                    'email' => $buyer->getEmail(),
                    'phone' => $buyer->getPhone(),
                    'notes' => $buyer->getNickname(),
                ],
            );

            $localOrder->address()->updateOrCreate(
                [
                    'customer_id' => $customer->id,
                ],
                [
                    'name' => $buyer->getFirstName() . ' ' . $buyer->getLastName(),
                    'email' => $buyer->getEmail(),
                    'phone' => $buyer->getPhone(),
                    'street' => $shippingAddress->getAddressLine(),
                    'country' => $shippingAddress->getCountry()->getName(),
                    'state' => $shippingAddress->getState()->getName(),
                    'city' => $shippingAddress->getCity()->getName(),
                    'postcode' => $shippingAddress->getZipCode(),
                ],
            );

            $orderItems->map(function (OrderItem $orderItem) use ($localOrder, $channel) {
                $localProduct = $channel
                    ->channelProducts()
                    ->where('channel_product_id', $orderItem->getItem()->getId())
                    ->first();

                $localOrder->items()->updateOrCreate(
                    [
                        'product_id' => $localProduct->id,
                    ],
                    [
                        'sku' => $localProduct->sku,
                        'name' => $orderItem->getItem()->getTitle(),
                        'weight' => $localProduct->weight,
                        'total_weight' => $localProduct->weight * $orderItem->getQuantity(),
                        'qty_ordered' => $orderItem->getQuantity(),
                        'price' => $orderItem->getUnitPrice(),
                        'base_price' => $localProduct->price,
                        'total' => $orderItem->getUnitPrice() * $orderItem->getQuantity(),
                        'base_total' => $localProduct->price * $orderItem->getQuantity(),
                        'product_id' => $orderItem->getUnitPrice(),
                        'additional' => $orderItem->getSaleFee(),
                    ],
                );
            });

            $orderPayments->map(function (Payment $orderPayment) use ($localOrder) {
                $localOrder->payments()->updateOrCreate(
                    [
                        'transaction_id' => $orderPayment->getId(),
                    ],
                    [
                        'method' => $orderPayment->getPaymentType(),
                        'total_paid' => $orderPayment->getTransactionAmount(),
                        'status' => $orderPayment->getStatus(),
                    ],
                );
            });
        }
    }
}
