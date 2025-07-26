<?php

use App\Models\Tenant\InventorySource;
use App\Repositories\InventorySourceRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use ApiTestTrait, DatabaseTransactions;

uses(Tests\TestCase::class);

test('create_inventory_source', function () {
    $inventorySource = factory(InventorySource::class)->make()->toArray();
    $createdInventorySource = $this->inventorySourceRepo->create($inventorySource);
    $createdInventorySource = $createdInventorySource->toArray();
    $this->assertArrayHasKey('id', $createdInventorySource);
    $this->assertNotNull($createdInventorySource['id'], 'Created InventorySource must have id specified');
    $this->assertNotNull(InventorySource::find($createdInventorySource['id']), 'InventorySource with given id must be in DB');
    $this->assertModelData($inventorySource, $createdInventorySource);
    }

test('read_inventory_source', function () {
    $inventorySource = factory(InventorySource::class)->create();
    $dbInventorySource = $this->inventorySourceRepo->find($inventorySource->id);
    $dbInventorySource = $dbInventorySource->toArray();
    $this->assertModelData($inventorySource->toArray(), $dbInventorySource);
    }

test('update_inventory_source', function () {
    $inventorySource = factory(InventorySource::class)->create();
    $fakeInventorySource = factory(InventorySource::class)->make()->toArray();
    $updatedInventorySource = $this->inventorySourceRepo->update($fakeInventorySource, $inventorySource->id);
    $this->assertModelData($fakeInventorySource, $updatedInventorySource->toArray());
    $dbInventorySource = $this->inventorySourceRepo->find($inventorySource->id);
    $this->assertModelData($fakeInventorySource, $dbInventorySource->toArray());
    }

test('delete_inventory_source', function () {
    $inventorySource = factory(InventorySource::class)->create();
    $resp = $this->inventorySourceRepo->delete($inventorySource->id);
    $this->assertTrue($resp);
    $this->assertNull(InventorySource::find($inventorySource->id), 'InventorySource should not exist in DB');
    }
