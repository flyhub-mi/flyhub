<?php

namespace App\Repositories\Tenant;

use App\Repositories\BaseRepository;
use App\Models\Tenant\InventorySource;

/**
 * Class InventorySourceRepository
 * @package App\Repositories
 */

class InventorySourceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'code',
        'name',
        'description',
        'contact_name',
        'contact_email',
        'contact_number',
        'contact_fax',
        'country',
        'state',
        'city',
        'street',
        'postcode',
        'priority',
        'latitude',
        'longitude',
        'status',
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
        return InventorySource::class;
    }
}
