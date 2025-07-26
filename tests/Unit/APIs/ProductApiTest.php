<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use App\Models\Tenant\Product;
use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

uses(Tests\TestCase::class);

test('create_product', function () {
    $product = factory(Product::class)->make()->toArray();
    $this->response = $this->json( 'POST', '/api/products', $product );
    $this->assertApiResponse($product);
    }

test('read_product', function () {
    $product = factory(Product::class)->create();
    $this->response = $this->json( 'GET', '/api/products/' . $product->id );
    $this->assertApiResponse($product->toArray());
    }

test('update_product', function () {
    $product = factory(Product::class)->create();
    $editedProduct = factory(Product::class)->make()->toArray();
    $this->response = $this->json( 'PUT', '/api/products/' . $product->id, $editedProduct );
    $this->assertApiResponse($editedProduct);
    }

test('delete_product', function () {
    $product = factory(Product::class)->create();
    $this->response = $this->json( 'DELETE', '/api/products/' . $product->id );
    $this->assertApiSuccess();
    $this->response = $this->json( 'GET', '/api/products/' . $product->id );
    $this->response->assertStatus(404);
    }
