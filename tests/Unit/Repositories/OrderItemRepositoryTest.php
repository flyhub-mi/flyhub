<?php

use App\Models\Tenant\OrderItem;
use App\Repositories\OrderItemRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use ApiTestTrait, DatabaseTransactions;

uses(Tests\TestCase::class);

test('create_order_item', function () {
    $orderItem = factory(OrderItem::class)->make()->toArray();
    $createdOrderItem = $this->orderItemRepo->create($orderItem);
    $createdOrderItem = $createdOrderItem->toArray();
    $this->assertArrayHasKey('id', $createdOrderItem);
    $this->assertNotNull($createdOrderItem['id'], 'Created OrderItem must have id specified');
    $this->assertNotNull(OrderItem::find($createdOrderItem['id']), 'OrderItem with given id must be in DB');
    $this->assertModelData($orderItem, $createdOrderItem);
    }

test('read_order_item', function () {
    $orderItem = factory(OrderItem::class)->create();
    $dbOrderItem = $this->orderItemRepo->find($orderItem->id);
    $dbOrderItem = $dbOrderItem->toArray();
    $this->assertModelData($orderItem->toArray(), $dbOrderItem);
    }

test('update_order_item', function () {
    $orderItem = factory(OrderItem::class)->create();
    $fakeOrderItem = factory(OrderItem::class)->make()->toArray();
    $updatedOrderItem = $this->orderItemRepo->update($fakeOrderItem, $orderItem->id);
    $this->assertModelData($fakeOrderItem, $updatedOrderItem->toArray());
    $dbOrderItem = $this->orderItemRepo->find($orderItem->id);
    $this->assertModelData($fakeOrderItem, $dbOrderItem->toArray());
    }

test('delete_order_item', function () {
    $orderItem = factory(OrderItem::class)->create();
    $resp = $this->orderItemRepo->delete($orderItem->id);
    $this->assertTrue($resp);
    $this->assertNull(OrderItem::find($orderItem->id), 'OrderItem should not exist in DB');
    }
