<?php

namespace App\Repositories\Tenant;

use App\Models\Tenant\ShipmentItem;
use App\Repositories\BaseRepository;

/**
 * Class ShipmentItemRepository
 * @package App\Repositories
 */
class ShipmentItemRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description',
        'sku',
        'qty',
        'weight',
        'price',
        'base_price',
        'total',
        'base_total',
        'product_id',
        'product_type',
        'order_item_id',
        'shipment_id',
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
        return ShipmentItem::class;
    }
}
