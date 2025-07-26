<?php

use App\Models\Tenant\ProductAttribute;
use App\Repositories\ProductAttributeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use ApiTestTrait, DatabaseTransactions;

uses(Tests\TestCase::class);

test('create_product_attribute_value', function () {
    $productAttribute = factory(ProductAttribute::class)->make()->toArray();
    $createdProductAttribute = $this->productAttributeRepo->create($productAttribute);
    $createdProductAttribute = $createdProductAttribute->toArray();
    $this->assertArrayHasKey('id', $createdProductAttribute);
    $this->assertNotNull($createdProductAttribute['id'], 'Created ProductAttribute must have id specified');
    $this->assertNotNull(ProductAttribute::find($createdProductAttribute['id']), 'ProductAttribute with given id must be in DB');
    $this->assertModelData($productAttribute, $createdProductAttribute);
    }

test('read_product_attribute_value', function () {
    $productAttribute = factory(ProductAttribute::class)->create();
    $dbProductAttribute = $this->productAttributeRepo->find($productAttribute->id);
    $dbProductAttribute = $dbProductAttribute->toArray();
    $this->assertModelData($productAttribute->toArray(), $dbProductAttribute);
    }

test('update_product_attribute_value', function () {
    $productAttribute = factory(ProductAttribute::class)->create();
    $fakeProductAttribute = factory(ProductAttribute::class)->make()->toArray();
    $updatedProductAttribute = $this->productAttributeRepo->update($fakeProductAttribute, $productAttribute->id);
    $this->assertModelData($fakeProductAttribute, $updatedProductAttribute->toArray());
    $dbProductAttribute = $this->productAttributeRepo->find($productAttribute->id);
    $this->assertModelData($fakeProductAttribute, $dbProductAttribute->toArray());
    }

test('delete_product_attribute_value', function () {
    $productAttribute = factory(ProductAttribute::class)->create();
    $resp = $this->productAttributeRepo->delete($productAttribute->id);
    $this->assertTrue($resp);
    $this->assertNull(ProductAttribute::find($productAttribute->id), 'ProductAttribute should not exist in DB');
    }
