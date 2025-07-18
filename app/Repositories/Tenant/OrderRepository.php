<?php

namespace App\Repositories\Tenant;

use Exception;
use App\FlyHub;
use function _\get;
use App\Enums\AddressType;
use App\Models\Tenant\Order;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class OrderRepository
 * @package App\Repositories
 */
class OrderRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'status',
        'channel_name',
        'is_guest',
        'customer_email',
        'customer_name',
        'shipping_method',
        'shipping_title',
        'shipping_description',
        'coupon_code',
        'is_gift',
        'total_item_count',
        'total_qty_ordered',
        'grand_total',
        'base_grand_total',
        'grand_total_invoiced',
        'base_grand_total_invoiced',
        'grand_total_refunded',
        'base_grand_total_refunded',
        'sub_total',
        'base_sub_total',
        'sub_total_invoiced',
        'base_sub_total_invoiced',
        'sub_total_refunded',
        'base_sub_total_refunded',
        'discount_percent',
        'discount_amount',
        'base_discount_amount',
        'discount_invoiced',
        'base_discount_invoiced',
        'discount_refunded',
        'base_discount_refunded',
        'tax_amount',
        'base_tax_amount',
        'tax_amount_invoiced',
        'base_tax_amount_invoiced',
        'tax_amount_refunded',
        'base_tax_amount_refunded',
        'shipping_amount',
        'base_shipping_amount',
        'shipping_invoiced',
        'base_shipping_invoiced',
        'shipping_refunded',
        'base_shipping_refunded',
        'customer_id',
        'customer_type',
        'channel_id',
        'channel_type',
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     */
    public function model()
    {
        return Order::class;
    }

    /**
     * @param mixed $id
     * @param array $columns
     * @return Model|Collection<mixed, Builder>|Builder|null
     * @throws InvalidArgumentException
     */
    public function find($id, $columns = ['*'])
    {
        return $this->model
            ::with(['customer', 'shippingAddress', 'billingAddress', 'items', 'payments', 'invoices'])
            ->find($id, $columns);
    }

    /**
     * @param array $input
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create($input)
    {
        return $this->updateOrCreate([], $input);
    }

    /**
     * @param array $input
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update($input, $id)
    {
        return $this->updateOrCreate(['id' => $id], $input);
    }

    /**
     * @param array $attributes
     * @param array $values
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function updateOrCreate($attributes, $values = [])
    {
        $input = [];

        try {
            DB::beginTransaction();

            $input = $this->saveCustomer($values);

            if (is_int(get($attributes, 'id'))) {
                $product = $this->model::findOrFail($attributes['id']);
                $product->update($values);
            } else {
                $order = $this->model::updateOrCreate($attributes, $input);
            }

            foreach (get($input, 'items', []) as $item) {
                $order->items()->updateOrCreate(['sku' => $item['sku']], $item);
            }

            if (isset($input['shippingAddress'])) {
                $this->saveAddress($order, $input['customer_id'], 'shipping', $input['shippingAddress']);
            }

            if (isset($input['billingAddress'])) {
                $this->saveAddress($order, $input['customer_id'], 'billing', $input['billingAddress']);
            }

            if (isset($input['payments'])) {
                foreach ($input['payments'] as $payment) {
                    $this->savePayment($order, $payment);
                }
            }

            if (isset($input['shipments'])) {
                $shipmentIds = [];

                foreach ($input['shipments'] as $shipment) {
                    $shipmentIds[] = $this->saveShipment($order, $shipment);
                }

                $order
                    ->shipments()
                    ->whereNotIn('id', $shipmentIds)
                    ->delete();
            }

            try {
                if ($order->wasRecentlyCreated == 'true') {
                    //$order->tenant->notify($order);
                }
            } catch (\Exception $e) {
                FlyHub::notifyExceptionWithMetaData($e, [$input, $order]);
            }

            DB::commit();

            return $order;
        } catch (\Exception $e) {
            DB::rollBack();

            FlyHub::notifyExceptionWithMetaData($e, [$input], true);
        } catch (\Throwable $e) {
            FlyHub::notifyExceptionWithMetaData($e, [$input], true);
        }
    }

    /**
     * @param array $input
     * @return array
     * @throws InvalidArgumentException
     * @throws InvalidCastException
     * @throws MassAssignmentException
     * @throws Exception
     */
    private function saveCustomer($input)
    {
        $customer = null;
        $repository = new CustomerRepository();

        $customerId = get($input, 'customer.id') || get($input, 'customer_id');

        if (is_numeric($customerId)) {
            $customer = $repository->find($customerId);
        }

        if (is_null($customer)) {
            $customer = $repository->findOneBy('cpf_cnpj', '=', $input['customer']['cpf_cnpj']);
        }

        if (is_null($customer)) {
            $attributes = [
                'cpf_cnpj' => get($input, 'customer.cpf_cnpj'),
            ];
            $customer = $repository->updateOrCreate($attributes, $input['customer']);
        } else {
            $customer->update($input['customer']);
        }

        return array_merge($input, [
            'customer_id' => $customer->id,
            'customer_name' => $customer->name,
        ]);
    }

    /**
     * @param Order $order
     * @param string|int $customerId
     * @param string $addressType
     * @param array $orderAddressData
     */
    private function saveAddress(Order &$order, $customerId, $addressType, $addressData)
    {
        $addressData['customer_id'] = $customerId;
        $addressData['address_type'] = $addressType;
        $addressData['country'] = get($addressData, 'country') ?: 'BR';

        $order->addresses()->updateOrCreate(['address_type' => $addressType], $addressData);
    }

    /**
     * @param Order $order
     * @param array $input
     * @return void
     * @throws InvalidArgumentException
     * @throws InvalidCastException
     * @throws MassAssignmentException
     */
    private function savePayment(Order &$order, $input)
    {
        $payment = null;

        if (!empty($input['id'])) {
            $payment = $order->payments()->find($input['id']);
        }

        if (is_null($payment)) {
            $order->payments()->updateOrCreate(['transaction_id' => $input['transaction_id']], $input);
        } else {
            $payment->update($input);
        }
    }

    /**
     * @param Order $order
     * @param mixed $input
     * @return int
     * @throws InvalidArgumentException
     * @throws InvalidCastException
     * @throws MassAssignmentException
     */
    private function saveShipment(Order &$order, $input)
    {
        $shipment = null;

        if (!empty($input['id'])) {
            $shipment = $order->shipments()->find($input['id']);
        }

        if (is_null($shipment)) {
            $shipment = $order->shipments()->updateOrCreate(
                [
                    'method' => get($input, 'method'),
                    'carrier' => get($input, 'carrier'),
                ],
                $input,
            );
        } else {
            $shipment->update($input);
        }

        return $shipment->id;
    }
}
