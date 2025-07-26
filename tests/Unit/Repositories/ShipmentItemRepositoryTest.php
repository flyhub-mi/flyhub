<?php

use App\Models\Tenant\ShipmentItem;
use App\Repositories\ShipmentItemRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use ApiTestTrait, DatabaseTransactions;

uses(Tests\TestCase::class);

test('create_shipment_item', function () {
    $shipmentItem = factory(ShipmentItem::class)->make()->toArray();
    $createdShipmentItem = $this->shipmentItemRepo->create($shipmentItem);
    $createdShipmentItem = $createdShipmentItem->toArray();
    $this->assertArrayHasKey('id', $createdShipmentItem);
    $this->assertNotNull($createdShipmentItem['id'], 'Created ShipmentItem must have id specified');
    $this->assertNotNull(ShipmentItem::find($createdShipmentItem['id']), 'ShipmentItem with given id must be in DB');
    $this->assertModelData($shipmentItem, $createdShipmentItem);
    }

test('read_shipment_item', function () {
    $shipmentItem = factory(ShipmentItem::class)->create();
    $dbShipmentItem = $this->shipmentItemRepo->find($shipmentItem->id);
    $dbShipmentItem = $dbShipmentItem->toArray();
    $this->assertModelData($shipmentItem->toArray(), $dbShipmentItem);
    }

test('update_shipment_item', function () {
    $shipmentItem = factory(ShipmentItem::class)->create();
    $fakeShipmentItem = factory(ShipmentItem::class)->make()->toArray();
    $updatedShipmentItem = $this->shipmentItemRepo->update($fakeShipmentItem, $shipmentItem->id);
    $this->assertModelData($fakeShipmentItem, $updatedShipmentItem->toArray());
    $dbShipmentItem = $this->shipmentItemRepo->find($shipmentItem->id);
    $this->assertModelData($fakeShipmentItem, $dbShipmentItem->toArray());
    }

test('delete_shipment_item', function () {
    $shipmentItem = factory(ShipmentItem::class)->create();
    $resp = $this->shipmentItemRepo->delete($shipmentItem->id);
    $this->assertTrue($resp);
    $this->assertNull(ShipmentItem::find($shipmentItem->id), 'ShipmentItem should not exist in DB');
    }
