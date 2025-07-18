<?php namespace Tests\Unit\Repositories;

use App\Models\Tenant\RefundItem;
use App\Repositories\RefundItemRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class RefundItemRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var RefundItemRepository
     */
    protected $refundItemRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->refundItemRepo = \App::make(RefundItemRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_refund_item()
    {
        $refundItem = factory(RefundItem::class)->make()->toArray();

        $createdRefundItem = $this->refundItemRepo->create($refundItem);

        $createdRefundItem = $createdRefundItem->toArray();
        $this->assertArrayHasKey('id', $createdRefundItem);
        $this->assertNotNull($createdRefundItem['id'], 'Created RefundItem must have id specified');
        $this->assertNotNull(RefundItem::find($createdRefundItem['id']), 'RefundItem with given id must be in DB');
        $this->assertModelData($refundItem, $createdRefundItem);
    }

    /**
     * @test read
     */
    public function test_read_refund_item()
    {
        $refundItem = factory(RefundItem::class)->create();

        $dbRefundItem = $this->refundItemRepo->find($refundItem->id);

        $dbRefundItem = $dbRefundItem->toArray();
        $this->assertModelData($refundItem->toArray(), $dbRefundItem);
    }

    /**
     * @test update
     */
    public function test_update_refund_item()
    {
        $refundItem = factory(RefundItem::class)->create();
        $fakeRefundItem = factory(RefundItem::class)->make()->toArray();

        $updatedRefundItem = $this->refundItemRepo->update($fakeRefundItem, $refundItem->id);

        $this->assertModelData($fakeRefundItem, $updatedRefundItem->toArray());
        $dbRefundItem = $this->refundItemRepo->find($refundItem->id);
        $this->assertModelData($fakeRefundItem, $dbRefundItem->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_refund_item()
    {
        $refundItem = factory(RefundItem::class)->create();

        $resp = $this->refundItemRepo->delete($refundItem->id);

        $this->assertTrue($resp);
        $this->assertNull(RefundItem::find($refundItem->id), 'RefundItem should not exist in DB');
    }
}
