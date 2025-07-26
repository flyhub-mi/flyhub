<?php

use App\Jobs\Tenant\SendProductJob;
use App\Models\Tenant\Product;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Str;

uses(Tests\TestCase::class);

test('created', function () {
    Queue::fake();
    // $product = Product::factory()->create();
    Queue::assertPushed(SendProductJob::class);
    }

test('updated', function () {
    Queue::fake();
    $product = new Product();
    $product->sku = Str::uuid();
    $product->price = 10;
    $product->save();
    $this->assertFalse($product->wasChanged('price'));
    $product->price = '10';
    $product->save();
    $this->assertFalse($product->wasChanged('price'));
    $product->price = '10.00';
    $product->save();
    $this->assertFalse($product->wasChanged('price'));
    $product->price = 10.00;
    $product->save();
    $this->assertFalse($product->wasChanged('price'));
    $product->price = 20;
    $product->save();
    $this->assertTrue($product->wasChanged('price') === true);
    }
