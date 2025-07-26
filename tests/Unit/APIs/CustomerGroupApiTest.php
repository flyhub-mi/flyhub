<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use App\Models\Tenant\CustomerGroup;
use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

uses(Tests\TestCase::class);

test('create_customer_group', function () {
    $customerGroup = factory(CustomerGroup::class)->make()->toArray();
    $this->response = $this->json( 'POST', '/api/customer-groups', $customerGroup );
    $this->assertApiResponse($customerGroup);
    }

test('read_customer_group', function () {
    $customerGroup = factory(CustomerGroup::class)->create();
    $this->response = $this->json( 'GET', '/api/customer-groups/' . $customerGroup->id );
    $this->assertApiResponse($customerGroup->toArray());
    }

test('update_customer_group', function () {
    $customerGroup = factory(CustomerGroup::class)->create();
    $editedCustomerGroup = factory(CustomerGroup::class)->make()->toArray();
    $this->response = $this->json( 'PUT', '/api/customer-groups/' . $customerGroup->id, $editedCustomerGroup );
    $this->assertApiResponse($editedCustomerGroup);
    }

test('delete_customer_group', function () {
    $customerGroup = factory(CustomerGroup::class)->create();
    $this->response = $this->json( 'DELETE', '/api/customer-groups/' . $customerGroup->id );
    $this->assertApiSuccess();
    $this->response = $this->json( 'GET', '/api/customer-groups/' . $customerGroup->id );
    $this->response->assertStatus(404);
    }
