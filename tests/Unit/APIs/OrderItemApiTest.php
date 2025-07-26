<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use App\Models\Tenant\OrderItem;
use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

uses(Tests\TestCase::class);

test('create_order_item', function () {
    $orderItem = factory(OrderItem::class)->make()->toArray();
    $this->response = $this->json( 'POST', '/api/order-items', $orderItem );
    $this->assertApiResponse($orderItem);
    }

test('read_order_item', function () {
    $orderItem = factory(OrderItem::class)->create();
    $this->response = $this->json( 'GET', '/api/order-items/' . $orderItem->id );
    $this->assertApiResponse($orderItem->toArray());
    }

test('update_order_item', function () {
    $orderItem = factory(OrderItem::class)->create();
    $editedOrderItem = factory(OrderItem::class)->make()->toArray();
    $this->response = $this->json( 'PUT', '/api/order-items/' . $orderItem->id, $editedOrderItem );
    $this->assertApiResponse($editedOrderItem);
    }

test('delete_order_item', function () {
    $orderItem = factory(OrderItem::class)->create();
    $this->response = $this->json( 'DELETE', '/api/order-items/' . $orderItem->id );
    $this->assertApiSuccess();
    $this->response = $this->json( 'GET', '/api/order-items/' . $orderItem->id );
    $this->response->assertStatus(404);
    }
