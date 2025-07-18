<?php

namespace App\Repositories\Tenant;

use App\Models\Tenant\RefundItem;
use App\Repositories\BaseRepository;

/**
 * Class RefundItemRepository
 * @package App\Repositories
 */

class RefundItemRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description',
        'sku',
        'qty',
        'price',
        'base_price',
        'total',
        'base_total',
        'tax_amount',
        'base_tax_amount',
        'discount_percent',
        'discount_amount',
        'base_discount_amount',
        'product_id',
        'product_type',
        'order_item_id',
        'refund_id',
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
        return RefundItem::class;
    }
}
