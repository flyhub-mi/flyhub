<?php

namespace App\Repositories;

use Auth;
use Exception;
use function _\get;
use LogicException;
use InvalidArgumentException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\InvalidCastException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\MassAssignmentException;

use Illuminate\Contracts\Container\BindingResolutionException;

abstract class BaseRepository
{
    /** @var Model */
    protected $model;

    /**
     * @return void
     * @throws BindingResolutionException
     * @throws Exception
     */
    public function __construct()
    {
        $this->model = $this->model();
    }

    /** @return array */
    abstract public function getFieldsSearchable();

    /** @return string */
    abstract public function model();

    /** @return ReposeBuilder  */
    public function newQuery()
    {
        $model = $this->model;
        $instance = new $model();

        return $instance->newQuery();
    }

    /**
     * Paginate records for scaffold.
     *
     * @param int $perPage
     * @param array $columns
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage, $columns = ['*'])
    {
        return $this->allQuery()->paginate($perPage, $columns);
    }

    /**
     * @param array $search
     * @param mixed|null $skip
     * @param mixed|null $limit
     * @return Builder
     * @throws InvalidArgumentException
     */
    public function allQuery($search = [], $skip = null, $limit = null)
    {
        $query = $this->newQuery();

        if (count($search)) {
            foreach ($search as $key => $value) {
                if (in_array($key, $this->getFieldsSearchable())) {
                    $query->where($key, $value);
                }
            }
        }

        if (!is_null($skip)) {
            $query->skip($skip);
        }

        if (!is_null($limit)) {
            $query->limit($limit);
        }

        return $query;
    }

    /**
     * @param array $search
     * @param mixed|null $skip
     * @param mixed|null $limit
     * @param array $columns
     * @return Collection<mixed, Builder>
     * @throws InvalidArgumentException
     */
    public function all($search = [], $skip = null, $limit = null, $columns = ['*'])
    {
        return $this->allQuery($search, $skip, $limit)->get($columns);
    }

    /**
     * @param mixed $input
     * @return Model
     * @throws InvalidArgumentException
     * @throws InvalidCastException
     */
    public function create($input)
    {
        $model = new $this->model($input);
        $model->save();

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
        return $this->model::find($id, $columns);
    }

    /**
     * @param \Closure|string|array|\Illuminate\Database\Query\Expression $column
     * @param mixed|null $operator
     * @param mixed|null $value
     * @param string $boolean
     * @return \Illuminate\Database\Eloquent\Model|object|static|null
     * @throws InvalidArgumentException
     */
    public function findOneBy($column, $operator = null, $value = null, $boolean = 'and')
    {
        return $this->model::where($column, $operator, $value, $boolean)->first();
    }

    /**
     * @param mixed $attributes
     * @param mixed $values
     * @return mixed
     */
    public function updateOrCreate($attributes, $values)
    {
        return $this->model::updateOrCreate($attributes, $values);
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
        $model->save();

        return $model;
    }

    /**
     * @param mixed $id
     * @return mixed
     * @throws InvalidArgumentException
     * @throws ModelNotFoundException
     * @throws LogicException
     */
    public function delete($id)
    {
        $model = $this->model::findOrFail($id);

        return $model->delete();
    }

    /**
     * @param array $input
     * @param string $key
     * @return array
     */
    public function removeKey($input, $key)
    {
        return array_filter(
            $input,
            function ($k) use ($key) {
                return $k !== $key;
            },
            ARRAY_FILTER_USE_KEY,
        );
    }

    /**
     * @param array $input
     * @param array $keys
     * @return array
     */
    public function removeKeys($input, $keys)
    {
        return array_filter(
            $input,
            function ($k) use ($keys) {
                return !in_array($k, $keys);
            },
            ARRAY_FILTER_USE_KEY,
        );
    }
}
