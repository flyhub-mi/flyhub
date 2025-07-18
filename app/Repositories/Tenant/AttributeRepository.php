<?php

namespace App\Repositories\Tenant;

use function _\get;
use Illuminate\Support\Str;
use InvalidArgumentException;
use App\Models\Tenant\Attribute;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\InvalidCastException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Database\Eloquent\MassAssignmentException;

/** @package App\Repositories */
class AttributeRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'code',
        'name',
        'type',
        'validation',
        'position',
        'is_required',
        'is_unique',
        'value_per_channel',
        'is_filterable',
        'is_configurable',
        'is_user_defined',
        'is_visible_on_front',
        'use_in_flat',
        'swatch_type',
    ];

    /** @return array  */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /** @return string  */
    public function model()
    {
        return Attribute::class;
    }

    /**
     * @param array $input
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create($input)
    {
        $model = new $this->model($input);
        $model->code = Str::slug($model->name);
        $model->is_user_defined = true;
        $model->save();

        $model->options()->createMany(
            array_map(function ($option) {
                return [
                    'name' => $option['name'],
                    'sort_order' => $option['sort_order'],
                ];
            }, $input['options']),
        );

        return $model;
    }

    /**
     * @param mixed $id
     * @param array $columns
     * @return Model|Collection<mixed, Builder>|Builder|null
     * @throws InvalidArgumentException
     */
    public function find($id, $columns = ['*'])
    {
        return $this->model::with('options')->find($id, $columns);
    }

    /**
     * @param mixed $input
     * @param mixed $id
     * @return Model|Collection<mixed, Builder>|Builder
     * @throws InvalidArgumentException
     * @throws ModelNotFoundException
     * @throws MassAssignmentException
     * @throws InvalidCastException
     */
    public function update($input, $id)
    {
        $model = $this->model::findOrFail($id);
        $model->fill($input);

        if (count($model->options) > 0) {
            foreach ($model->options as $modelKey => $modelOptionValue) {
                $hasUpdateAttr = get($input, "options.{$modelKey}.id") == $modelOptionValue->id;
                $hasToDeleteAttr = !isset($input['options'][$modelKey]);

                if ($hasUpdateAttr) {
                    $modelOptionValue->update([
                        'name' => $input['options'][$modelKey]['name'],
                        'sort_order' => $input['options'][$modelKey]['sort_order'],
                    ]);
                } elseif ($hasToDeleteAttr) {
                    $modelOptionValue->delete();
                }
            }
        }

        $newAttrToSave = array_filter($input['options'], fn($item) => !isset($item['id']));
        if (count($newAttrToSave) > 0) {
            $model->options()->createMany(
                array_map(
                    fn($option) => [
                        'name' => $option['name'],
                        'sort_order' => $option['sort_order'],
                    ],
                    $newAttrToSave,
                ),
            );
        }

        $model->code = Str::slug($model->name);
        $model->save();

        return $model;
    }
}
