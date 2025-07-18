<?php

namespace App\Repositories\Tenant;

use App\Models\Tenant\OrderPayment;
use App\Repositories\BaseRepository;

/**
 * Class OrderPaymentRepository
 * @package App\Repositories
 */

class OrderPaymentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = ['method', 'method_title', 'order_id'];

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
        return OrderPayment::class;
    }
}
