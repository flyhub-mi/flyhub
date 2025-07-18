<?php

namespace App\Repositories\Tenant;

use App\Models\Tenant\OrderItem;
use App\Repositories\BaseRepository;

/**
 * Class OrderItemRepository
 * @package App\Repositories
 */

class OrderItemRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'sku',
        'type',
        'name',
        'coupon_code',
        'weight',
        'total_weight',
        'qty_ordered',
        'qty_shipped',
        'qty_invoiced',
        'qty_canceled',
        'qty_refunded',
        'price',
        'base_price',
        'total',
        'base_total',
        'total_invoiced',
        'base_total_invoiced',
        'amount_refunded',
        'base_amount_refunded',
        'discount_percent',
        'discount_amount',
        'base_discount_amount',
        'discount_invoiced',
        'base_discount_invoiced',
        'discount_refunded',
        'base_discount_refunded',
        'tax_percent',
        'tax_amount',
        'base_tax_amount',
        'tax_amount_invoiced',
        'base_tax_amount_invoiced',
        'tax_amount_refunded',
        'base_tax_amount_refunded',
        'product_id',
        'product_type',
        'order_id',
        'parent_id',
        'additional',
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
        return OrderItem::class;
    }
}
