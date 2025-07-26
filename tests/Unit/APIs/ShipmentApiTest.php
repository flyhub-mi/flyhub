<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use App\Models\Tenant\Shipment;
use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

uses(Tests\TestCase::class);

test('create_shipment', function () {
    $shipment = factory(Shipment::class)->make()->toArray();
    $this->response = $this->json( 'POST', '/api/shipments', $shipment );
    $this->assertApiResponse($shipment);
    }

test('read_shipment', function () {
    $shipment = factory(Shipment::class)->create();
    $this->response = $this->json( 'GET', '/api/shipments/' . $shipment->id );
    $this->assertApiResponse($shipment->toArray());
    }

test('update_shipment', function () {
    $shipment = factory(Shipment::class)->create();
    $editedShipment = factory(Shipment::class)->make()->toArray();
    $this->response = $this->json( 'PUT', '/api/shipments/' . $shipment->id, $editedShipment );
    $this->assertApiResponse($editedShipment);
    }

test('delete_shipment', function () {
    $shipment = factory(Shipment::class)->create();
    $this->response = $this->json( 'DELETE', '/api/shipments/' . $shipment->id );
    $this->assertApiSuccess();
    $this->response = $this->json( 'GET', '/api/shipments/' . $shipment->id );
    $this->response->assertStatus(404);
    }
