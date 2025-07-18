<?php

namespace App\Repositories\Tenant;

use App\Models\Tenant\Customer;
use App\Repositories\BaseRepository;

/**
 * Class CustomerRepository
 * @package App\Repositories
 */

class CustomerRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'channel_id',
        'remote_id',
        'type',
        'cpf_cnpj ',
        'ie',
        'rg',
        'name',
        'fantasy_name',
        'gender',
        'birthdate',
        'email',
        'status',
        'subscribed_to_news_letter',
        'phone',
        'notes',
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
        return Customer::class;
    }
}
