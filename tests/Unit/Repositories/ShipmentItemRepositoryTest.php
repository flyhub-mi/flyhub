<?php namespace Tests\Unit\Repositories;

use App\Models\Tenant\ShipmentItem;
use App\Repositories\ShipmentItemRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ShipmentItemRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var ShipmentItemRepository
     */
    protected $shipmentItemRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->shipmentItemRepo = \App::make(ShipmentItemRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_shipment_item()
    {
        $shipmentItem = factory(ShipmentItem::class)->make()->toArray();

        $createdShipmentItem = $this->shipmentItemRepo->create($shipmentItem);

        $createdShipmentItem = $createdShipmentItem->toArray();
        $this->assertArrayHasKey('id', $createdShipmentItem);
        $this->assertNotNull($createdShipmentItem['id'], 'Created ShipmentItem must have id specified');
        $this->assertNotNull(ShipmentItem::find($createdShipmentItem['id']), 'ShipmentItem with given id must be in DB');
        $this->assertModelData($shipmentItem, $createdShipmentItem);
    }

    /**
     * @test read
     */
    public function test_read_shipment_item()
    {
        $shipmentItem = factory(ShipmentItem::class)->create();

        $dbShipmentItem = $this->shipmentItemRepo->find($shipmentItem->id);

        $dbShipmentItem = $dbShipmentItem->toArray();
        $this->assertModelData($shipmentItem->toArray(), $dbShipmentItem);
    }

    /**
     * @test update
     */
    public function test_update_shipment_item()
    {
        $shipmentItem = factory(ShipmentItem::class)->create();
        $fakeShipmentItem = factory(ShipmentItem::class)->make()->toArray();

        $updatedShipmentItem = $this->shipmentItemRepo->update($fakeShipmentItem, $shipmentItem->id);

        $this->assertModelData($fakeShipmentItem, $updatedShipmentItem->toArray());
        $dbShipmentItem = $this->shipmentItemRepo->find($shipmentItem->id);
        $this->assertModelData($fakeShipmentItem, $dbShipmentItem->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_shipment_item()
    {
        $shipmentItem = factory(ShipmentItem::class)->create();

        $resp = $this->shipmentItemRepo->delete($shipmentItem->id);

        $this->assertTrue($resp);
        $this->assertNull(ShipmentItem::find($shipmentItem->id), 'ShipmentItem should not exist in DB');
    }
}
