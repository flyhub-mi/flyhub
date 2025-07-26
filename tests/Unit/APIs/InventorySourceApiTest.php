<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use App\Models\Tenant\InventorySource;
use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

uses(Tests\TestCase::class);

test('create_inventory_source', function () {
    $inventorySource = factory(InventorySource::class)->make()->toArray();
    $this->response = $this->json( 'POST', '/api/inventory-sources', $inventorySource );
    $this->assertApiResponse($inventorySource);
    }

test('read_inventory_source', function () {
    $inventorySource = factory(InventorySource::class)->create();
    $this->response = $this->json( 'GET', '/api/inventory-sources/' . $inventorySource->id );
    $this->assertApiResponse($inventorySource->toArray());
    }

test('update_inventory_source', function () {
    $inventorySource = factory(InventorySource::class)->create();
    $editedInventorySource = factory(InventorySource::class)->make()->toArray();
    $this->response = $this->json( 'PUT', '/api/inventory-sources/' . $inventorySource->id, $editedInventorySource );
    $this->assertApiResponse($editedInventorySource);
    }

test('delete_inventory_source', function () {
    $inventorySource = factory(InventorySource::class)->create();
    $this->response = $this->json( 'DELETE', '/api/inventory-sources/' . $inventorySource->id );
    $this->assertApiSuccess();
    $this->response = $this->json( 'GET', '/api/inventory-sources/' . $inventorySource->id );
    $this->response->assertStatus(404);
    }
