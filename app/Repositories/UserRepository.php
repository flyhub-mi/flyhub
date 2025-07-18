<?php

namespace App\Repositories;

use App\Models\Tenant\User;
use Illuminate\Contracts\Container\BindingResolutionException;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

/**
 * Class UserRepository
 * @package App\Repositories
 */
class UserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = ['name', 'email'];

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
        return User::class;
    }

    /**
     * @param array $input
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create($input)
    {
        $model = new $this->model($this->filterInputValues($input));
        $model->save();

        return $model;
    }

    /**
     * @param array $input
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function update($input, $id)
    {
        $model = $this->model::findOrFail($id);
        $model->fill($this->filterInputValues($input));
        $model->save();

        return $model;
    }

    /**
     * @param mixed $input
     * @return array
     * @throws BindingResolutionException
     * @throws InvalidArgumentException
     * @throws BadRequestException
     */
    private function filterInputValues($input)
    {
        $values = $this->removeKeys($input, ['password_confirmation', 'roles']);

        if (!empty($values['password'])) {
            $values['password'] = bcrypt($values['password']);
        } else {
            $values = $this->removeKeys($input, ['password']);
        }

        return $values;
    }
}
