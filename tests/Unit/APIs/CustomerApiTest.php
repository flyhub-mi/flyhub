<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use App\Models\Tenant\Customer;
use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

uses(Tests\TestCase::class);

test('create_customer', function () {
    $customer = factory(Customer::class)->make()->toArray();
    $this->response = $this->json( 'POST', '/api/customers', $customer );
    $this->assertApiResponse($customer);
    }

test('read_customer', function () {
    $customer = factory(Customer::class)->create();
    $this->response = $this->json( 'GET', '/api/customers/' . $customer->id );
    $this->assertApiResponse($customer->toArray());
    }

test('update_customer', function () {
    $customer = factory(Customer::class)->create();
    $editedCustomer = factory(Customer::class)->make()->toArray();
    $this->response = $this->json( 'PUT', '/api/customers/' . $customer->id, $editedCustomer );
    $this->assertApiResponse($editedCustomer);
    }

test('delete_customer', function () {
    $customer = factory(Customer::class)->create();
    $this->response = $this->json( 'DELETE', '/api/customers/' . $customer->id );
    $this->assertApiSuccess();
    $this->response = $this->json( 'GET', '/api/customers/' . $customer->id );
    $this->response->assertStatus(404);
    }
