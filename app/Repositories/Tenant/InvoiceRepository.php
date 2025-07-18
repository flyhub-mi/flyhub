<?php

namespace App\Repositories\Tenant;

use App\Models\Tenant\Order;
use App\Models\Tenant\Invoice;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class InvoiceRepository
 * @package App\Repositories
 */
class InvoiceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'state',
        'email_sent',
        'total_qty',
        'sub_total',
        'grand_total',
        'shipping_amount',
        'tax_amount',
        'discount_amount',
        'order_id',
        'transaction_id',
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
        return Invoice::class;
    }

    /**
     * Create model record
     *
     * @param array $input
     *
     * @return Model
     */
    public function create($input)
    {
        $order = Order::find($input['order_id']);
        $model = new $this->model();

        $model->state = $order->status;
        $model->email_sent = false;
        $model->total_qty = $order->total_qty_ordered;
        $model->sub_total = $order->sub_total;
        $model->grand_total = $order->grand_total;
        $model->shipping_amount = $order->shipping_amount;
        $model->tax_amount = $order->tax_amount;
        $model->discount_amount = $order->discount_amount;
        $model->order_id = $order->id;

        $model->save();

        return $model;
    }
}
