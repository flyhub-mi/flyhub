<?php

namespace App\Repositories\Tenant;

use function _\get;
use App\Models\Tenant\Tax;
use App\Repositories\BaseRepository;

/**
 * Class TaxRateRepository
 * @package App\Repositories
 */
class TaxRateRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'identifier',
        'is_zip',
        'zip_code',
        'zip_from',
        'zip_to',
        'state',
        'state_from',
        'state_to',
        'country',
        'tax_rate',
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
        return Tax::class;
    }

    public function create($input)
    {
        $model = new $this->model($input);
        $model->save();

        $model->options()->createMany(
            array_map(function ($option) {
                return [
                    'label' => $option['label'],
                    'value' => $option['value'],
                ];
            }, $input['options']),
        );

        return $model;
    }

    public function update($input, $id)
    {
        $model = $this->model::findOrFail($id);
        $model->fill($input);

        foreach ($model->options as $modelKey => $modelOptionValue) {
            if (get($input, "options.{$modelKey}.id") == $modelOptionValue->id) {
                $modelOptionValue->update([
                    'label' => $input['options'][$modelKey]['label'],
                    'value' => $input['options'][$modelKey]['value'],
                ]);
            }

            if (!isset($input['options'][$modelKey])) {
                $modelOptionValue->delete();
            }
        }

        $newAttrToSave = array_filter($input['options'], fn($item) => !isset($item['id']));
        if (count($newAttrToSave) > 0) {
            $model->options()->createMany(
                array_map(
                    fn($option) => [
                        'label' => $option['label'],
                        'value' => $option['value'],
                    ],
                    $newAttrToSave,
                ),
            );
        }

        $model->save();
        return $model;
    }

    public function find($id, $columns = ['*'])
    {
        return $this->model::with('options')->find($id, $columns);
    }
}
