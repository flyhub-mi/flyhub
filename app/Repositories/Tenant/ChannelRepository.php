<?php

namespace App\Repositories\Tenant;

use App\Models\Tenant\Channel;
use App\Repositories\BaseRepository;

/**
 * Class ChannelRepository
 * @package App\Repositories
 */
class ChannelRepository extends BaseRepository
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
        return Channel::class;
    }

    public function find($id, $columns = ['*'])
    {
        return $this->model
            ::with('channelCategories')
            ->with('configs')
            ->find($id, $columns);
    }

    public function create($input)
    {
        $values = $this->removeKey($input, 'configs');
        $model = new $this->model($values);
        $model->save();
        $this->saveConfigs($model, $input);

        return $model;
    }

    public function update($input, $id)
    {
        $model = $this->model::findOrFail($id);

        $values = $this->removeKey($input, 'configs');
        $model->fill($values);
        $model->save();

        $this->saveConfigs($model, $input);

        return $model;
    }

    private function saveConfigs($model, $input)
    {
        if (isset($input['configs'])) {
            foreach ($input['configs'] as $code => $value) {
                $model->configs()->updateOrCreate(['code' => $code], ['value' => $value ?: '']);
            }
        }
    }
}
