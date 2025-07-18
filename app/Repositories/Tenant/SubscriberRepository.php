<?php

namespace App\Repositories\Tenant;

use App\Models\Tenant\Subscriber;
use App\Repositories\BaseRepository;

/**
 * Class SubscriberRepository
 * @package App\Repositories
 */
class SubscriberRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = ['email', 'is_subscribed', 'token', 'channel_id'];

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
        return Subscriber::class;
    }
}
