<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use App\Models\Tenant\ProductAttribute;
use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

uses(Tests\TestCase::class);

test('create_product_attribute_value', function () {
    $productAttributeValue = factory(ProductAttribute::class)->make()->toArray();
    $this->response = $this->json( 'POST', '/api/product-attributes', $productAttributeValue );
    $this->assertApiResponse($productAttributeValue);
    }

test('read_product_attribute_value', function () {
    $productAttributeValue = factory(ProductAttribute::class)->create();
    $this->response = $this->json( 'GET', '/api/product-attributes/' . $productAttributeValue->id );
    $this->assertApiResponse($productAttributeValue->toArray());
    }

test('update_product_attribute_value', function () {
    $productAttributeValue = factory(ProductAttribute::class)->create();
    $editedProductAttribute = factory(ProductAttribute::class)->make()->toArray();
    $this->response = $this->json( 'PUT', '/api/product-attributes/' . $productAttributeValue->id, $editedProductAttribute );
    $this->assertApiResponse($editedProductAttribute);
    }

test('delete_product_attribute_value', function () {
    $productAttributeValue = factory(ProductAttribute::class)->create();
    $this->response = $this->json( 'DELETE', '/api/product-attributes/' . $productAttributeValue->id );
    $this->assertApiSuccess();
    $this->response = $this->json( 'GET', '/api/product-attributes/' . $productAttributeValue->id );
    $this->response->assertStatus(404);
    }
