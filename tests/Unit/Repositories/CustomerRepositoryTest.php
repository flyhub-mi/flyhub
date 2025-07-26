<?php

use App\Models\Tenant\Customer;
use App\Repositories\CustomerRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use ApiTestTrait, DatabaseTransactions;

uses(Tests\TestCase::class);

test('create_customer', function () {
    $customer = factory(Customer::class)->make()->toArray();
    $createdCustomer = $this->customerRepo->create($customer);
    $createdCustomer = $createdCustomer->toArray();
    $this->assertArrayHasKey('id', $createdCustomer);
    $this->assertNotNull($createdCustomer['id'], 'Created Customer must have id specified');
    $this->assertNotNull(Customer::find($createdCustomer['id']), 'Customer with given id must be in DB');
    $this->assertModelData($customer, $createdCustomer);
    }

test('read_customer', function () {
    $customer = factory(Customer::class)->create();
    $dbCustomer = $this->customerRepo->find($customer->id);
    $dbCustomer = $dbCustomer->toArray();
    $this->assertModelData($customer->toArray(), $dbCustomer);
    }

test('update_customer', function () {
    $customer = factory(Customer::class)->create();
    $fakeCustomer = factory(Customer::class)->make()->toArray();
    $updatedCustomer = $this->customerRepo->update($fakeCustomer, $customer->id);
    $this->assertModelData($fakeCustomer, $updatedCustomer->toArray());
    $dbCustomer = $this->customerRepo->find($customer->id);
    $this->assertModelData($fakeCustomer, $dbCustomer->toArray());
    }

test('delete_customer', function () {
    $customer = factory(Customer::class)->create();
    $resp = $this->customerRepo->delete($customer->id);
    $this->assertTrue($resp);
    $this->assertNull(Customer::find($customer->id), 'Customer should not exist in DB');
    }
