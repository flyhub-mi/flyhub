<?php namespace Tests\Unit\Repositories;

use App\Models\Tenant\Refund;
use App\Repositories\RefundRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class RefundRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var RefundRepository
     */
    protected $refundRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->refundRepo = \App::make(RefundRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_refund()
    {
        $refund = factory(Refund::class)->make()->toArray();

        $createdRefund = $this->refundRepo->create($refund);

        $createdRefund = $createdRefund->toArray();
        $this->assertArrayHasKey('id', $createdRefund);
        $this->assertNotNull($createdRefund['id'], 'Created Refund must have id specified');
        $this->assertNotNull(Refund::find($createdRefund['id']), 'Refund with given id must be in DB');
        $this->assertModelData($refund, $createdRefund);
    }

    /**
     * @test read
     */
    public function test_read_refund()
    {
        $refund = factory(Refund::class)->create();

        $dbRefund = $this->refundRepo->find($refund->id);

        $dbRefund = $dbRefund->toArray();
        $this->assertModelData($refund->toArray(), $dbRefund);
    }

    /**
     * @test update
     */
    public function test_update_refund()
    {
        $refund = factory(Refund::class)->create();
        $fakeRefund = factory(Refund::class)->make()->toArray();

        $updatedRefund = $this->refundRepo->update($fakeRefund, $refund->id);

        $this->assertModelData($fakeRefund, $updatedRefund->toArray());
        $dbRefund = $this->refundRepo->find($refund->id);
        $this->assertModelData($fakeRefund, $dbRefund->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_refund()
    {
        $refund = factory(Refund::class)->create();

        $resp = $this->refundRepo->delete($refund->id);

        $this->assertTrue($resp);
        $this->assertNull(Refund::find($refund->id), 'Refund should not exist in DB');
    }
}
