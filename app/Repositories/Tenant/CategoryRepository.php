<?php

namespace App\Repositories\Tenant;

use App\Models\Tenant\Category;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;
use InvalidArgumentException;
use function _\get;

/**
 * Class CategoryRepository
 * @package App\Repositories
 */
class CategoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'slug',
        'position',
        '_lft',
        '_rgt',
        'parent_id',
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
        return Category::class;
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
        $query = $this->allQuery($search, $skip, $limit);

        return $query->with('channels')->get($columns);
    }

    /**
     * @param mixed $id
     * @param array $columns
     * @return Model|Collection<mixed, Builder>|Builder|null
     * @throws InvalidArgumentException
     */
    public function find($id, $columns = ['*'])
    {
        return $this->model::with(['children'])->find($id, $columns);
    }

    /**
     * @param array $input
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update($input, $id)
    {
        return $this->updateOrCreate(['id' => $id], $input);
    }

    /**
     * @param array $attributes
     * @param array $values
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function updateOrCreate($attributes, $values = [])
    {
        if (is_int(get($attributes, 'id'))) {
            $category = $this->model::findOrFail($attributes['id']);
            $category->update($values);
        } else {
            $category = $this->model::updateOrCreate($attributes, $values);
        }

        $category = $this->saveChildren($category, $values);

        return $category;
    }

    /**
     * @param mixed $category
     * @param mixed $values
     * @return mixed
     */
    private function saveChildren(&$category, $values)
    {
        foreach (get($values, 'children', []) as $childValues) {
            $childValues['parent_id'] = $category->id;

            $attributes = [
                'name' => $childValues['name'],
                'parent_id' => $childValues['parent_id'],
            ];

            $childCategory = $category->children()->updateOrCreate($attributes, $childValues);

            $this->saveChildren($childCategory, $childValues);
        }

        return $category;
    }
}
