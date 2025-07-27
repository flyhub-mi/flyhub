<?php

use App\Jobs\Tenant\ChannelSendResourceJob;
use App\Models\Tenant\Product;
use App\Models\Tenant\ProductInventory;
use App\Observers\ProductInventoryObserver;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;

uses(Tests\TestCase::class, DatabaseTransactions::class);

test('created_dispatches_job_when_product_price_greater_than_zero', function () {
    Queue::fake();

    $product = Product::factory()->create([
        'price' => 100.00
    ]);

    $productInventory = ProductInventory::factory()->create([
        'product_id' => $product->id
    ]);

    $observer = new ProductInventoryObserver();
    $observer->created($productInventory);

    Queue::assertPushed(ChannelSendResourceJob::class, function ($job) use ($product) {
        return $job->product->id === $product->id;
    });
});

test('created_dispatches_job_when_product_price_is_decimal', function () {
    Queue::fake();

    $product = Product::factory()->create([
        'price' => 25.50
    ]);

    $productInventory = ProductInventory::factory()->create([
        'product_id' => $product->id
    ]);

    $observer = new ProductInventoryObserver();
    $observer->created($productInventory);

    Queue::assertPushed(ChannelSendResourceJob::class);
});

test('created_does_not_dispatch_job_when_product_price_is_zero', function () {
    Queue::fake();

    $product = Product::factory()->create([
        'price' => 0.00
    ]);

    $productInventory = ProductInventory::factory()->create([
        'product_id' => $product->id
    ]);

    $observer = new ProductInventoryObserver();
    $observer->created($productInventory);

    Queue::assertNotPushed(ChannelSendResourceJob::class);
});

test('created_does_not_dispatch_job_when_product_price_is_negative', function () {
    Queue::fake();

    $product = Product::factory()->create([
        'price' => -10.00
    ]);

    $productInventory = ProductInventory::factory()->create([
        'product_id' => $product->id
    ]);

    $observer = new ProductInventoryObserver();
    $observer->created($productInventory);

    Queue::assertNotPushed(ChannelSendResourceJob::class);
});

test('created_does_not_dispatch_job_when_product_price_is_null', function () {
    Queue::fake();

    $product = Product::factory()->create([
        'price' => null
    ]);

    $productInventory = ProductInventory::factory()->create([
        'product_id' => $product->id
    ]);

    $observer = new ProductInventoryObserver();
    $observer->created($productInventory);

    Queue::assertNotPushed(ChannelSendResourceJob::class);
});

test('created_dispatches_job_with_correct_product_relationship', function () {
    Queue::fake();

    $product = Product::factory()->create([
        'price' => 50.00
    ]);

    $productInventory = ProductInventory::factory()->create([
        'product_id' => $product->id
    ]);

    // Ensure the relationship is loaded
    $productInventory->load('product');

    $observer = new ProductInventoryObserver();
    $observer->created($productInventory);

    Queue::assertPushed(ChannelSendResourceJob::class, function ($job) use ($product) {
        return $job->product && $job->product->id === $product->id;
    });
});
