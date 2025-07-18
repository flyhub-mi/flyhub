<?php namespace Tests\Unit\Repositories;

use App\Models\Tenant\Shipment;
use App\Repositories\ShipmentRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ShipmentRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var ShipmentRepository
     */
    protected $shipmentRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->shipmentRepo = \App::make(ShipmentRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_shipment()
    {
        $shipment = factory(Shipment::class)->make()->toArray();

        $createdShipment = $this->shipmentRepo->create($shipment);

        $createdShipment = $createdShipment->toArray();
        $this->assertArrayHasKey('id', $createdShipment);
        $this->assertNotNull($createdShipment['id'], 'Created Shipment must have id specified');
        $this->assertNotNull(Shipment::find($createdShipment['id']), 'Shipment with given id must be in DB');
        $this->assertModelData($shipment, $createdShipment);
    }

    /**
     * @test read
     */
    public function test_read_shipment()
    {
        $shipment = factory(Shipment::class)->create();

        $dbShipment = $this->shipmentRepo->find($shipment->id);

        $dbShipment = $dbShipment->toArray();
        $this->assertModelData($shipment->toArray(), $dbShipment);
    }

    /**
     * @test update
     */
    public function test_update_shipment()
    {
        $shipment = factory(Shipment::class)->create();
        $fakeShipment = factory(Shipment::class)->make()->toArray();

        $updatedShipment = $this->shipmentRepo->update($fakeShipment, $shipment->id);

        $this->assertModelData($fakeShipment, $updatedShipment->toArray());
        $dbShipment = $this->shipmentRepo->find($shipment->id);
        $this->assertModelData($fakeShipment, $dbShipment->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_shipment()
    {
        $shipment = factory(Shipment::class)->create();

        $resp = $this->shipmentRepo->delete($shipment->id);

        $this->assertTrue($resp);
        $this->assertNull(Shipment::find($shipment->id), 'Shipment should not exist in DB');
    }
}
