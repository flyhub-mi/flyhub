<?php

namespace App\Repositories\Tenant;

use App\Models\Tenant\Shipment;
use App\Repositories\BaseRepository;

/**
 * Class ShipmentRepository
 * @package App\Repositories
 */
class ShipmentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'status',
        'carrier',
        'track_number',
        'email_sent',
        'customer_id',
        'customer_type',
        'order_id',
        'inventory_source_id',
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
        return Shipment::class;
    }
}
