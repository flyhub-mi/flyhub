<?php

namespace App\Repositories;

use App\Models\Tenant;

/**
 * Class TenantRepository
 * @package App\Repositories
 */
class TenantRepository extends BaseRepository
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
        return Tenant::class;
    }

    /**
     * @param array $input
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create($input)
    {
        $values = $this->removeKey($input, 'address');
        $model = new $this->model($values);
        $model->save();

        // $address = $model->address()->create($input['address']);

        // $inventorySource = $model->inventorySources()->create([
        //     'name' => 'Padrão',
        //     'contact_name' => $model->name,
        //     'contact_email' => $model->email,
        //     'contact_number' => $model->phone,
        //     'status' => 1,
        //     'country' => 'BR',
        //     'state' => $address->state,
        //     'street' => $address->street,
        //     'city' => $address->city,
        //     'postcode' => $address->postcode,
        // ]);

        // $model->categories()->create(['name' => 'Raiz', 'description' => 'Raiz', 'position' => 1, 'status' => true]);

        // $channel = $model->channels()->create(['code' => 'local', 'name' => 'Local']);

        // $channel->inventorySources()->attach($inventorySource->id);

        // $model->attributeSets()->create(['name' => 'Padrão']);

        // $model->attributes()->create(
        //     [
        //         'code' => 'size',
        //         'name' => 'Tamanho',
        //         'type' => 'select',
        //         'position' => true,
        //         'is_required' => false,
        //         'is_unique' => false,
        //         'value_per_channel' => false,
        //         'is_filterable' => true,
        //         'is_configurable' => false,
        //         'is_user_defined' => false,
        //     ],
        //     [
        //         'code' => 'color',
        //         'name' => 'Cor',
        //         'type' => 'select',
        //         'position' => '2',
        //         'is_required' => false,
        //         'is_unique' => false,
        //         'value_per_channel' => false,
        //         'is_filterable' => true,
        //         'is_configurable' => false,
        //         'is_user_defined' => false,
        //     ],
        // );

        // $model->users()->create([
        //     'name' => $model->name,
        //     'email' => $model->email,
        //     'password' => uniqid(rand(), true),
        // ]);

        return $model;
    }

    /**
     * @param array $input
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update($input, $id)
    {
        $model = $this->model::findOrFail($id);

        $values = $this->removeKey($input, 'address');
        $model->fill($values);
        $model->save();

        // $model
        //     ->address()
        //     ->firstOrNew([], $input['address'])
        //     ->save();

        return $model;
    }
}
