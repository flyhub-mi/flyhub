<?php

use Tests\ApiTestTrait;
use App\Repositories\ProductRepository;
use App\Models\Tenant\Product;
use App\Models\Tenant\Channel;
use ApiTestTrait;

uses(Tests\TestCase::class);

test('create_product', function () {
    $createdProduct = $this->productRepo->create($this->productInput);
    $createdProduct = $createdProduct->toArray();
    $this->assertArrayHasKey('id', $createdProduct);
    $this->assertNotNull($createdProduct['id'], 'Created Product must have id specified');
    $this->assertNotNull(Product::find($createdProduct['id']), 'Product with given id must be in DB');
    }

test('read_product', function () {
    $product = $this->productRepo->create($this->productInput[0]);
    $dbProduct = $this->productRepo->find($product->id);
    $dbProduct = $dbProduct->toArray();
    $this->assertModelData($product->toArray(), $dbProduct);
    }

test('update_product', function () {
    $product = $this->productRepo->create($this->productInput[0]);
    $updatedProduct = $this->productRepo->update([], $product->id);
    $this->assertModelData([], $updatedProduct->toArray());
    $dbProduct = $this->productRepo->find($product->id);
    $this->assertModelData([], $dbProduct->toArray());
    }

test('delete_product', function () {
    $product = $this->productRepo->create($this->productInput[0]);
    $resp = $this->productRepo->delete($product->id);
    $this->assertTrue($resp);
    $this->assertNull($this->productRepo->find($product->id), 'Product should not exist in DB');
    }
