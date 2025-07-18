<?php

namespace Tests\Unit\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Tenant\ShipmentItem;

class ShipmentItemApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_shipment_item()
    {
        $shipmentItem = factory(ShipmentItem::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/shipment-items',
            $shipmentItem
        );

        $this->assertApiResponse($shipmentItem);
    }

    /**
     * @test
     */
    public function test_read_shipment_item()
    {
        $shipmentItem = factory(ShipmentItem::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/shipment-items/' . $shipmentItem->id
        );

        $this->assertApiResponse($shipmentItem->toArray());
    }

    /**
     * @test
     */
    public function test_update_shipment_item()
    {
        $shipmentItem = factory(ShipmentItem::class)->create();
        $editedShipmentItem = factory(ShipmentItem::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/shipment-items/' . $shipmentItem->id,
            $editedShipmentItem
        );

        $this->assertApiResponse($editedShipmentItem);
    }

    /**
     * @test
     */
    public function test_delete_shipment_item()
    {
        $shipmentItem = factory(ShipmentItem::class)->create();

        $this->response = $this->json(
            'DELETE',
            '/api/shipment-items/' . $shipmentItem->id
        );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/shipment-items/' . $shipmentItem->id
        );

        $this->response->assertStatus(404);
    }
}
