<?php

namespace App\Repositories\Tenant;

use App\Repositories\BaseRepository;
use App\Models\Tenant\ChannelProduct;

/**
 * Class ChannelProductRepository
 * @package App\Repositories
 */
class ChannelProductRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [];

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
        return ChannelProduct::class;
    }

    public function find($id, $columns = ['*'])
    {
        return $this->model::with('attributes')->find($id, $columns);
    }
}
