<?php

namespace Tests\Unit\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Tenant\RefundItem;

class RefundItemApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_refund_item()
    {
        $refundItem = factory(RefundItem::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/refund-items',
            $refundItem
        );

        $this->assertApiResponse($refundItem);
    }

    /**
     * @test
     */
    public function test_read_refund_item()
    {
        $refundItem = factory(RefundItem::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/refund-items/' . $refundItem->id
        );

        $this->assertApiResponse($refundItem->toArray());
    }

    /**
     * @test
     */
    public function test_update_refund_item()
    {
        $refundItem = factory(RefundItem::class)->create();
        $editedRefundItem = factory(RefundItem::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/refund-items/' . $refundItem->id,
            $editedRefundItem
        );

        $this->assertApiResponse($editedRefundItem);
    }

    /**
     * @test
     */
    public function test_delete_refund_item()
    {
        $refundItem = factory(RefundItem::class)->create();

        $this->response = $this->json(
            'DELETE',
            '/api/refund-items/' . $refundItem->id
        );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/refund-items/' . $refundItem->id
        );

        $this->response->assertStatus(404);
    }
}
