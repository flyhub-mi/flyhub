<?php

namespace App\Repositories\Tenant;

use App\Models\Tenant\TaxGroup;
use App\Repositories\BaseRepository;

/**
 * Class TaxGroupRepository
 * @package App\Repositories
 */
class TaxGroupRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = ['channel_id', 'code', 'name', 'description'];

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
        return TaxGroup::class;
    }

    /**
     * @param array $input
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function update($input, $id)
    {
        $model = $this->model::findOrFail($id);

        $values = $this->removeKey($input, 'taxes');
        $model->fill($values);
        $model->save();

        $this->syncTaxes($model, $input);

        return $model;
    }

    /**
     * @param int $id
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function find($id, $columns = ['*'])
    {
        return $this->model::with(['taxes', 'taxes.options'])->find($id, $columns);
    }

    /**
     * @param array $input
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create($input)
    {
        $values = $this->removeKey($input, 'taxes');
        $model = new $this->model($values);
        $model->save();

        $this->syncTaxes($model, $input);

        return $model;
    }

    /**
     * @param $model
     * @param array $input
     */
    private function syncTaxes($model, $input)
    {
        if (isset($input['taxes'])) {
            $taxIds = array_map(fn($item) => $item['id'], $input['taxes']);

            $model->taxes()->sync($taxIds);
        }
    }
}
