<?php

namespace App\Repositories\Tenant;

use App\Models\Tenant\Refund;
use App\Repositories\BaseRepository;

/**
 * Class RefundRepository
 * @package App\Repositories
 */

class RefundRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'state',
        'email_sent',
        'total_qty',
        'adjustment_refund',
        'base_adjustment_refund',
        'adjustment_fee',
        'base_adjustment_fee',
        'sub_total',
        'base_sub_total',
        'grand_total',
        'base_grand_total',
        'shipping_amount',
        'base_shipping_amount',
        'tax_amount',
        'base_tax_amount',
        'discount_percent',
        'discount_amount',
        'base_discount_amount',
        'order_id',
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
        return Refund::class;
    }
}
