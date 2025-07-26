<?php

use App\Models\Tenant\Order;
use App\Repositories\OrderRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use ApiTestTrait, DatabaseTransactions;

uses(Tests\TestCase::class);

test('create_order', function () {
    $order = factory(Order::class)->make()->toArray();
    $createdOrder = $this->orderRepo->create($order);
    $createdOrder = $createdOrder->toArray();
    $this->assertArrayHasKey('id', $createdOrder);
    $this->assertNotNull($createdOrder['id'], 'Created Order must have id specified');
    $this->assertNotNull(Order::find($createdOrder['id']), 'Order with given id must be in DB');
    $this->assertModelData($order, $createdOrder);
    }

test('read_order', function () {
    $order = factory(Order::class)->create();
    $dbOrder = $this->orderRepo->find($order->id);
    $dbOrder = $dbOrder->toArray();
    $this->assertModelData($order->toArray(), $dbOrder);
    }

test('update_order', function () {
    $order = factory(Order::class)->create();
    $fakeOrder = factory(Order::class)->make()->toArray();
    $updatedOrder = $this->orderRepo->update($fakeOrder, $order->id);
    $this->assertModelData($fakeOrder, $updatedOrder->toArray());
    $dbOrder = $this->orderRepo->find($order->id);
    $this->assertModelData($fakeOrder, $dbOrder->toArray());
    }

test('delete_order', function () {
    $order = factory(Order::class)->create();
    $resp = $this->orderRepo->delete($order->id);
    $this->assertTrue($resp);
    $this->assertNull(Order::find($order->id), 'Order should not exist in DB');
    }
