<?php

namespace App\Integration\Resources;

use function _\get;

use Illuminate\Database\Eloquent\Model;
use FlyHub;
use App\Repositories\Tenant\OrderRepository;
use App\Models\Tenant\Channel;

class Orders extends Base
{
    /**
     * @param \App\Models\Tenant\Channel $channel
     * @param array $mappedItems
     * @return array
     * @throws \Throwable
     */
    public function save($channel, $mappedOrders)
    {
        $results = [];
        $repository = new OrderRepository();

        foreach ($mappedOrders as $mappedOrder) {
            try {
                $values = $this->fillDefaultData($channel, $mappedOrder);
                $attributes = ['remote_id' => get($values, 'remote_id')];
                $order = $repository->updateOrCreate($attributes, $values);

                if (isset($mappedOrder['remote_id'])) {
                    $this->saveChannelOrder($channel, $mappedOrder['remote_id'], $order->id);
                }

                if (isset($mappedOrder['customer']['remote_id'])) {
                    $this->saveChannelCustomer($channel, $mappedOrder['customer']['remote_id'], $order->customerId);
                }

                $results[] = $this->getData($order);
            } catch (\Exception $e) {
                FlyHub::notifyExceptionWithMetaData($e, $values);

                $results[] = $e->getMessage();
            } catch (\Throwable $e) {
                FlyHub::notifyExceptionWithMetaData($e, $values);

                $results[] = $e->getMessage();
            }
        }

        return $results;
    }

    public function canSend($channel, $model)
    {
        $isProcessingOrder = in_array($model->status, ['processing', 'em-separacao', 'Em andamento', 'Em aberto']);

        return $isProcessingOrder && $channel->can('send', 'orders');
    }

    /**
     * @param Model $resource
     * @return array
     */
    public function getData($model)
    {
        return ['id' => $model->id, 'remote_id' => $model->remote_id];
    }

    /**
     * @param mixed $channel
     * @param mixed $values
     * @return mixed
     */
    private function fillDefaultData($channel, $values)
    {
        $order = array_merge($values, [
            'channel_id' => $channel->id,
            'channel_name' => $channel->code,
            'customer_email' => get($values, 'customer.email', ''),
            'customer_name' => get($values, 'customer.name', ''),
        ]);
        $relations = [
            'customer' => array_merge(get($values, 'customer', []), [
                'channel_id' => $channel->id,
            ]),
            'items' => get($values, 'items', []),
            'shippingAddress' => get($values, 'shippingAddress', []),
            'billingAddress' => get($values, 'billingAddress', []),
            'payments' => get($values, 'payments', []),
            'shipments' => get($values, 'shipments', []),
        ];

        return array_merge($order, $relations);
    }

    /**
     * @param Channel $channel
     * @return mixed
     */
    public function itemsToSend($channel)
    {
        return $channel->tenant
            ->orders()
            ->whereIn('status', ['processing', 'em-separacao', 'Em andamento', 'Em aberto'])
            ->select('id')
            ->get()
            ->filter(function ($order) use ($channel) {
                if (!str_contains(strtolower($order->channel_name), strtolower($channel->code))) {
                    $channelOrder = $order
                        ->channelsOrder()
                        ->where('channel_id', $channel->id)
                        ->first();
                    return is_null($channelOrder) || empty($channelOrder->remote_order_id);
                }

                return false;
            })
            ->toArray();
    }

    /**
     * @param \App\Models\Tenant\Channel $channel
     * @param int|string $localId
     * @param null|string|int $remoteId
     */
    private function saveChannelCustomer($channel, $localId, $remoteId = null)
    {
        $channel
            ->channelCustomers()
            ->updateOrCreate(['customer_id' => $localId], ['remote_customer_id' => $remoteId]);
    }

    /**
     * @param int|string $localId
     * @param null|string|int $remoteId
     */
    private function saveChannelOrder($channel, $localId, $remoteId = null)
    {
        $channel->channelOrders()->updateOrCreate(['order_id' => $localId], ['remote_order_id' => $remoteId]);
    }
}
