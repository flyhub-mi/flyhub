<?php

namespace Tests\Unit\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Tenant\Refund;

class RefundApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_refund()
    {
        $refund = factory(Refund::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/refunds',
            $refund
        );

        $this->assertApiResponse($refund);
    }

    /**
     * @test
     */
    public function test_read_refund()
    {
        $refund = factory(Refund::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/refunds/' . $refund->id
        );

        $this->assertApiResponse($refund->toArray());
    }

    /**
     * @test
     */
    public function test_update_refund()
    {
        $refund = factory(Refund::class)->create();
        $editedRefund = factory(Refund::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/refunds/' . $refund->id,
            $editedRefund
        );

        $this->assertApiResponse($editedRefund);
    }

    /**
     * @test
     */
    public function test_delete_refund()
    {
        $refund = factory(Refund::class)->create();

        $this->response = $this->json(
            'DELETE',
            '/api/refunds/' . $refund->id
        );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/refunds/' . $refund->id
        );

        $this->response->assertStatus(404);
    }
}
