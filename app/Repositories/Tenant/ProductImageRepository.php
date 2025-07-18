<?php

namespace App\Repositories\Tenant;

use App\Models\Tenant\Channel;
use App\Models\Tenant\ProductImage;
use App\Repositories\BaseRepository;

class ProductImageRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = ['type', 'product_id', 'channel_id'];

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
    function model()
    {
        return ProductImage::class;
    }

    /**
     * @param $input
     * @return mixed
     */
    public function create($input)
    {
        $model = new $this->model($input);
        $model->channel_id = Channel::first()->id;
        $model->save();

        return $model;
    }
}
