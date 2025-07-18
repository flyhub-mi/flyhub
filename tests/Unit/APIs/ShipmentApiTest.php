<?php

namespace Tests\Unit\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Tenant\Shipment;

class ShipmentApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_shipment()
    {
        $shipment = factory(Shipment::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/shipments',
            $shipment
        );

        $this->assertApiResponse($shipment);
    }

    /**
     * @test
     */
    public function test_read_shipment()
    {
        $shipment = factory(Shipment::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/shipments/' . $shipment->id
        );

        $this->assertApiResponse($shipment->toArray());
    }

    /**
     * @test
     */
    public function test_update_shipment()
    {
        $shipment = factory(Shipment::class)->create();
        $editedShipment = factory(Shipment::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/shipments/' . $shipment->id,
            $editedShipment
        );

        $this->assertApiResponse($editedShipment);
    }

    /**
     * @test
     */
    public function test_delete_shipment()
    {
        $shipment = factory(Shipment::class)->create();

        $this->response = $this->json(
            'DELETE',
            '/api/shipments/' . $shipment->id
        );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/shipments/' . $shipment->id
        );

        $this->response->assertStatus(404);
    }
}
