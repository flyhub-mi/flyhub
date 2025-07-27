<?php

use App\Models\Tenant\OrderItem;
use App\Observers\OrderItemObserver;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(Tests\TestCase::class, DatabaseTransactions::class);

test('creating_calculates_total_correctly', function () {
    $orderItemData = OrderItem::factory()->make()->toArray();
    $orderItemData['price'] = 100.00;
    $orderItemData['qty_ordered'] = 2;
    $orderItemData['discount_amount'] = 10.00;
    $orderItemData['total'] = null; // Ensure total is not set initially

    $orderItem = new OrderItem($orderItemData);
    $observer = new OrderItemObserver();

    $observer->creating($orderItem);

    $expectedTotal = (100.00 * 2) - 10.00; // price * qty - discount
    $this->assertEquals($expectedTotal, $orderItem->total);
});

test('creating_calculates_total_with_zero_discount', function () {
    $orderItemData = OrderItem::factory()->make()->toArray();
    $orderItemData['price'] = 50.00;
    $orderItemData['qty_ordered'] = 3;
    $orderItemData['discount_amount'] = 0.00;
    $orderItemData['total'] = null;

    $orderItem = new OrderItem($orderItemData);
    $observer = new OrderItemObserver();

    $observer->creating($orderItem);

    $expectedTotal = 50.00 * 3; // price * qty
    $this->assertEquals($expectedTotal, $orderItem->total);
});

test('creating_calculates_total_with_zero_quantity', function () {
    $orderItemData = OrderItem::factory()->make()->toArray();
    $orderItemData['price'] = 100.00;
    $orderItemData['qty_ordered'] = 0;
    $orderItemData['discount_amount'] = 5.00;
    $orderItemData['total'] = null;

    $orderItem = new OrderItem($orderItemData);
    $observer = new OrderItemObserver();

    $observer->creating($orderItem);

    $expectedTotal = (100.00 * 0) - 5.00; // price * qty - discount
    $this->assertEquals($expectedTotal, $orderItem->total);
});

test('updating_calculates_total_correctly', function () {
    $orderItem = OrderItem::factory()->create([
        'price' => 100.00,
        'qty_ordered' => 1,
        'discount_amount' => 0.00,
        'total' => 100.00
    ]);

    $orderItem->price = 150.00;
    $orderItem->qty_ordered = 2;
    $orderItem->discount_amount = 20.00;

    $observer = new OrderItemObserver();

    $observer->updating($orderItem);

    $expectedTotal = (150.00 * 2) - 20.00; // new price * new qty - new discount
    $this->assertEquals($expectedTotal, $orderItem->total);
});

test('updating_calculates_total_with_decimal_values', function () {
    $orderItem = OrderItem::factory()->create([
        'price' => 10.50,
        'qty_ordered' => 1,
        'discount_amount' => 0.00,
        'total' => 10.50
    ]);

    $orderItem->price = 25.75;
    $orderItem->qty_ordered = 4;
    $orderItem->discount_amount = 5.25;

    $observer = new OrderItemObserver();

    $observer->updating($orderItem);

    $expectedTotal = (25.75 * 4) - 5.25; // 103.00 - 5.25 = 97.75
    $this->assertEquals($expectedTotal, $orderItem->total);
});

test('updating_calculates_total_with_large_discount', function () {
    $orderItem = OrderItem::factory()->create([
        'price' => 100.00,
        'qty_ordered' => 1,
        'discount_amount' => 0.00,
        'total' => 100.00
    ]);

    $orderItem->price = 50.00;
    $orderItem->qty_ordered = 2;
    $orderItem->discount_amount = 150.00; // Discount larger than subtotal

    $observer = new OrderItemObserver();

    $observer->updating($orderItem);

    $expectedTotal = (50.00 * 2) - 150.00; // 100.00 - 150.00 = -50.00
    $this->assertEquals($expectedTotal, $orderItem->total);
});
