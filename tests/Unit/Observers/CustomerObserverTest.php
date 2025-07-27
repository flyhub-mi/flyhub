<?php

use App\Models\Tenant\Customer;
use App\Observers\CustomerObserver;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(Tests\TestCase::class, DatabaseTransactions::class);

test('creating_sets_birthdate_to_null_when_empty', function () {
    $customerData = Customer::factory()->make()->toArray();
    $customerData['birthdate'] = '';

    $customer = new Customer($customerData);
    $observer = new CustomerObserver();

    $observer->creating($customer);

    $this->assertNull($customer->birthdate);
});

test('creating_preserves_birthdate_when_not_empty', function () {
    $customerData = Customer::factory()->make()->toArray();
    $customerData['birthdate'] = '1990-01-01';

    $customer = new Customer($customerData);
    $observer = new CustomerObserver();

    $observer->creating($customer);

    $this->assertEquals('1990-01-01', $customer->birthdate);
});

test('creating_sets_birthdate_to_null_when_null', function () {
    $customerData = Customer::factory()->make()->toArray();
    $customerData['birthdate'] = null;

    $customer = new Customer($customerData);
    $observer = new CustomerObserver();

    $observer->creating($customer);

    $this->assertNull($customer->birthdate);
});

test('updating_sets_birthdate_to_null_when_empty', function () {
    $customer = Customer::factory()->create([
        'birthdate' => '1990-01-01'
    ]);

    $customer->birthdate = '';
    $observer = new CustomerObserver();

    $observer->updating($customer);

    $this->assertNull($customer->birthdate);
});

test('updating_preserves_birthdate_when_not_empty', function () {
    $customer = Customer::factory()->create([
        'birthdate' => '1990-01-01'
    ]);

    $customer->birthdate = '1995-05-15';
    $observer = new CustomerObserver();

    $observer->updating($customer);

    $this->assertEquals('1995-05-15', $customer->birthdate);
});

test('updating_sets_birthdate_to_null_when_null', function () {
    $customer = Customer::factory()->create([
        'birthdate' => '1990-01-01'
    ]);

    $customer->birthdate = null;
    $observer = new CustomerObserver();

    $observer->updating($customer);

    $this->assertNull($customer->birthdate);
});
