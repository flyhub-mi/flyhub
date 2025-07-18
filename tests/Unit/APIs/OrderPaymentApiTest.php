<?php

namespace Tests\Unit\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Tenant\OrderPayment;

class OrderPaymentApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_order_payment()
    {
        $orderPayment = factory(OrderPayment::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/order-payments',
            $orderPayment
        );

        $this->assertApiResponse($orderPayment);
    }

    /**
     * @test
     */
    public function test_read_order_payment()
    {
        $orderPayment = factory(OrderPayment::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/order-payments/' . $orderPayment->id
        );

        $this->assertApiResponse($orderPayment->toArray());
    }

    /**
     * @test
     */
    public function test_update_order_payment()
    {
        $orderPayment = factory(OrderPayment::class)->create();
        $editedOrderPayment = factory(OrderPayment::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/order-payments/' . $orderPayment->id,
            $editedOrderPayment
        );

        $this->assertApiResponse($editedOrderPayment);
    }

    /**
     * @test
     */
    public function test_delete_order_payment()
    {
        $orderPayment = factory(OrderPayment::class)->create();

        $this->response = $this->json(
            'DELETE',
            '/api/order-payments/' . $orderPayment->id
        );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/order-payments/' . $orderPayment->id
        );

        $this->response->assertStatus(404);
    }
}
