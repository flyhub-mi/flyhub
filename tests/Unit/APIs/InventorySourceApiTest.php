<?php

namespace Tests\Unit\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Tenant\InventorySource;

class InventorySourceApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_inventory_source()
    {
        $inventorySource = factory(InventorySource::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/inventory-sources',
            $inventorySource
        );

        $this->assertApiResponse($inventorySource);
    }

    /**
     * @test
     */
    public function test_read_inventory_source()
    {
        $inventorySource = factory(InventorySource::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/inventory-sources/' . $inventorySource->id
        );

        $this->assertApiResponse($inventorySource->toArray());
    }

    /**
     * @test
     */
    public function test_update_inventory_source()
    {
        $inventorySource = factory(InventorySource::class)->create();
        $editedInventorySource = factory(InventorySource::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/inventory-sources/' . $inventorySource->id,
            $editedInventorySource
        );

        $this->assertApiResponse($editedInventorySource);
    }

    /**
     * @test
     */
    public function test_delete_inventory_source()
    {
        $inventorySource = factory(InventorySource::class)->create();

        $this->response = $this->json(
            'DELETE',
            '/api/inventory-sources/' . $inventorySource->id
        );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/inventory-sources/' . $inventorySource->id
        );

        $this->response->assertStatus(404);
    }
}
