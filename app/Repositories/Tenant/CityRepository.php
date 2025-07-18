<?php

namespace App\Repositories\Tenant;

use App\Models\Tenant\City;
use App\Repositories\BaseRepository;

/**
 * Class CityRepository
 * @package App\Repositories
 */

class CityRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = ['country_code', 'code', 'name', 'country_id'];

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
        return City::class;
    }
}
