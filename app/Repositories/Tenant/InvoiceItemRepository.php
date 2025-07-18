<?php

namespace App\Repositories\Tenant;

use App\Models\Tenant\InvoiceItem;
use App\Repositories\BaseRepository;

/**
 * Class InvoiceItemRepository
 * @package App\Repositories
 */

class InvoiceItemRepository extends BaseRepository
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
        'total',
        'tax_amount',
        'product_id',
        'product_type',
        'order_item_id',
        'invoice_id',
        'parent_id',
        'additional',
        'discount_percent',
        'discount_amount',
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
        return InvoiceItem::class;
    }
}
