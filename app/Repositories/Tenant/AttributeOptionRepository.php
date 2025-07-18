<?php

namespace App\Repositories\Tenant;

use App\Repositories\BaseRepository;
use App\Models\Tenant\AttributeOption;

/**
 * Class AttributeOptionRepository
 * @package App\Repositories
 */

class AttributeOptionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = ['name', 'sort_order', 'attribute_id', 'swatch_value'];

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
        return AttributeOption::class;
    }
}
