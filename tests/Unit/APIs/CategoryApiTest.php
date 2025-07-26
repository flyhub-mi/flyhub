<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use App\Models\Tenant\Category;
use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

uses(Tests\TestCase::class);

test('create_category', function () {
    $category = factory(Category::class)->make()->toArray();
    $this->response = $this->json( 'POST', '/api/categories', $category );
    $this->assertApiResponse($category);
    }

test('read_category', function () {
    $category = factory(Category::class)->create();
    $this->response = $this->json( 'GET', '/api/categories/' . $category->id );
    $this->assertApiResponse($category->toArray());
    }

test('update_category', function () {
    $category = factory(Category::class)->create();
    $editedCategory = factory(Category::class)->make()->toArray();
    $this->response = $this->json( 'PUT', '/api/categories/' . $category->id, $editedCategory );
    $this->assertApiResponse($editedCategory);
    }

test('delete_category', function () {
    $category = factory(Category::class)->create();
    $this->response = $this->json( 'DELETE', '/api/categories/' . $category->id );
    $this->assertApiSuccess();
    $this->response = $this->json( 'GET', '/api/categories/' . $category->id );
    $this->response->assertStatus(404);
    }
