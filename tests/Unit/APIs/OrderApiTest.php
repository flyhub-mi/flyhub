<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use App\Models\Tenant\Order;
use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

uses(Tests\TestCase::class);

test('create_order', function () {
    $order = factory(Order::class)->make()->toArray();
    $this->response = $this->json( 'POST', '/api/orders', $order );
    $this->assertApiResponse($order);
    }

test('read_order', function () {
    $order = factory(Order::class)->create();
    $this->response = $this->json( 'GET', '/api/orders/' . $order->id );
    $this->assertApiResponse($order->toArray());
    }

test('update_order', function () {
    $order = factory(Order::class)->create();
    $editedOrder = factory(Order::class)->make()->toArray();
    $this->response = $this->json( 'PUT', '/api/orders/' . $order->id, $editedOrder );
    $this->assertApiResponse($editedOrder);
    }

test('delete_order', function () {
    $order = factory(Order::class)->create();
    $this->response = $this->json( 'DELETE', '/api/orders/' . $order->id );
    $this->assertApiSuccess();
    $this->response = $this->json( 'GET', '/api/orders/' . $order->id );
    $this->response->assertStatus(404);
    }
