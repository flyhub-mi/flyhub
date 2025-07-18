<?php

namespace App\Repositories\Tenant;

use App\Models\Tenant\Notification;
use App\Repositories\BaseRepository;

/**
 * Class OrderRepository
 * @package App\Repositories
 */
class NotificationRepository extends BaseRepository
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
        return Notification::class;
    }

    public function find($id, $columns = ['*'])
    {
        return $this->model::find($id, $columns);
    }
}
