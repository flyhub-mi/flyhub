<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use App\Models\Tenant;
use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

uses(Tests\TestCase::class);

test('create_tenant', function () {
    $tenant = factory(Tenant::class)->make()->toArray();
    $this->response = $this->json( 'POST', '/api/tenants', $tenant );
    $this->assertApiResponse($tenant);
    }

test('read_tenant', function () {
    $tenant = factory(Tenant::class)->create();
    $this->response = $this->json( 'GET', '/api/tenants/' . $tenant->id );
    $this->assertApiResponse($tenant->toArray());
    }

test('update_tenant', function () {
    $tenant = factory(Tenant::class)->create();
    $editedTenant = factory(Tenant::class)->make()->toArray();
    $this->response = $this->json( 'PUT', '/api/tenants/' . $tenant->id, $editedTenant );
    $this->assertApiResponse($editedTenant);
    }

test('delete_tenant', function () {
    $tenant = factory(Tenant::class)->create();
    $this->response = $this->json( 'DELETE', '/api/tenants/' . $tenant->id );
    $this->assertApiSuccess();
    $this->response = $this->json( 'GET', '/api/tenants/' . $tenant->id );
    $this->response->assertStatus(404);
    }
