<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use App\Models\Tenant\OrderPayment;
use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

uses(Tests\TestCase::class);

test('create_order_payment', function () {
    $orderPayment = factory(OrderPayment::class)->make()->toArray();
    $this->response = $this->json( 'POST', '/api/order-payments', $orderPayment );
    $this->assertApiResponse($orderPayment);
    }

test('read_order_payment', function () {
    $orderPayment = factory(OrderPayment::class)->create();
    $this->response = $this->json( 'GET', '/api/order-payments/' . $orderPayment->id );
    $this->assertApiResponse($orderPayment->toArray());
    }

test('update_order_payment', function () {
    $orderPayment = factory(OrderPayment::class)->create();
    $editedOrderPayment = factory(OrderPayment::class)->make()->toArray();
    $this->response = $this->json( 'PUT', '/api/order-payments/' . $orderPayment->id, $editedOrderPayment );
    $this->assertApiResponse($editedOrderPayment);
    }

test('delete_order_payment', function () {
    $orderPayment = factory(OrderPayment::class)->create();
    $this->response = $this->json( 'DELETE', '/api/order-payments/' . $orderPayment->id );
    $this->assertApiSuccess();
    $this->response = $this->json( 'GET', '/api/order-payments/' . $orderPayment->id );
    $this->response->assertStatus(404);
    }
