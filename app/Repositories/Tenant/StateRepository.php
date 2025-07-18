<?php

namespace App\Repositories\Tenant;

use App\Models\Tenant\State;
use App\Repositories\BaseRepository;

/**
 * Class CountryRepository
 * @package App\Repositorieså
 */
class StateRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = ['code', 'name'];

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
        return State::class;
    }
}
