<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use App\Models\Tenant\ShipmentItem;
use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

uses(Tests\TestCase::class);

test('create_shipment_item', function () {
    $shipmentItem = factory(ShipmentItem::class)->make()->toArray();
    $this->response = $this->json( 'POST', '/api/shipment-items', $shipmentItem );
    $this->assertApiResponse($shipmentItem);
    }

test('read_shipment_item', function () {
    $shipmentItem = factory(ShipmentItem::class)->create();
    $this->response = $this->json( 'GET', '/api/shipment-items/' . $shipmentItem->id );
    $this->assertApiResponse($shipmentItem->toArray());
    }

test('update_shipment_item', function () {
    $shipmentItem = factory(ShipmentItem::class)->create();
    $editedShipmentItem = factory(ShipmentItem::class)->make()->toArray();
    $this->response = $this->json( 'PUT', '/api/shipment-items/' . $shipmentItem->id, $editedShipmentItem );
    $this->assertApiResponse($editedShipmentItem);
    }

test('delete_shipment_item', function () {
    $shipmentItem = factory(ShipmentItem::class)->create();
    $this->response = $this->json( 'DELETE', '/api/shipment-items/' . $shipmentItem->id );
    $this->assertApiSuccess();
    $this->response = $this->json( 'GET', '/api/shipment-items/' . $shipmentItem->id );
    $this->response->assertStatus(404);
    }
