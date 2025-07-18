<?php

namespace App\Observers;

use App\Models\Tenant\Customer;

class CustomerObserver
{
    /**
     * @param Customer $customer
     * @return void
     */
    public function creating(Customer $customer)
    {
        if (empty($customer->birthdate)) {
            $customer->birthdate = null;
        }
    }

    /**
     * @param Customer $customer
     * @return void
     */
    public function updating(Customer $customer)
    {
        if (empty($customer->birthdate)) {
            $customer->birthdate = null;
        }
    }
}
