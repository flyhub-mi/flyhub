<?php

namespace App\Repositories\Tenant;

use App\Repositories\BaseRepository;
use App\Models\Tenant\ProductAttribute;

/**
 * Class ProductAttributeRepository
 * @package App\Repositories
 */

class ProductAttributeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = ['value', 'product_id', 'attribute_id'];

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
        return ProductAttribute::class;
    }
}
