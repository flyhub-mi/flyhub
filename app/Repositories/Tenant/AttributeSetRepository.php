<?php

namespace App\Repositories\Tenant;

use App\Models\Tenant\AttributeSet;
use App\Repositories\BaseRepository;

/**
 * Class AttributeSetRepository
 * @package App\Repositories
 */
class AttributeSetRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = ['name'];

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
        return AttributeSet::class;
    }

    /**
     * @param array $input
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create($input)
    {
        $values = $this->removeKey($input, 'attributes');
        $model = new $this->model($values);
        $model->save();

        $this->syncAttributes($model, $input);

        return $model;
    }

    /**
     * @param int $id
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function find($id, $columns = ['*'])
    {
        return $this->model::with(['attributes', 'attributes.options'])->find($id, $columns);
    }

    /**
     * @param array $input
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function update($input, $id)
    {
        $model = $this->model::findOrFail($id);

        $values = $this->removeKey($input, 'attributes');
        $model->fill($values);
        $model->save();

        $this->syncAttributes($model, $input);

        return $model;
    }

    /**
     * @param $model
     * @param array $input
     */
    private function syncAttributes($model, $input)
    {
        if (isset($input['attributes'])) {
            $model->attributes()->sync(
                array_map(function ($attribute) {
                    return $attribute['id'];
                }, $input['attributes']),
            );
        }
    }
}
