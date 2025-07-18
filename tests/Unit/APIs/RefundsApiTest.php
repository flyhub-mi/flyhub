<?php

namespace Tests\Unit\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Tenant\Refunds;

class RefundsApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_refunds()
    {
        $refunds = factory(Refunds::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/refunds',
            $refunds
        );

        $this->assertApiResponse($refunds);
    }

    /**
     * @test
     */
    public function test_read_refunds()
    {
        $refunds = factory(Refunds::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/refunds/' . $refunds->id
        );

        $this->assertApiResponse($refunds->toArray());
    }

    /**
     * @test
     */
    public function test_update_refunds()
    {
        $refunds = factory(Refunds::class)->create();
        $editedRefunds = factory(Refunds::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/refunds/' . $refunds->id,
            $editedRefunds
        );

        $this->assertApiResponse($editedRefunds);
    }

    /**
     * @test
     */
    public function test_delete_refunds()
    {
        $refunds = factory(Refunds::class)->create();

        $this->response = $this->json(
            'DELETE',
            '/api/refunds/' . $refunds->id
        );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/refunds/' . $refunds->id
        );

        $this->response->assertStatus(404);
    }
}
