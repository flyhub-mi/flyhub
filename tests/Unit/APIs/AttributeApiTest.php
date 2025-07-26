<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use App\Models\Tenant\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;

uses(Tests\TestCase::class, ApiTestTrait::class, WithoutMiddleware::class, DatabaseTransactions::class);

test('can create attribute', function () {
    $attribute = factory(Attribute::class)->make()->toArray();

    $this->response = $this->json(
        'POST',
        '/api/attributes',
        $attribute
    );

    $this->assertApiResponse($attribute);
});

test('can read attribute', function () {
    $attribute = factory(Attribute::class)->create();

    $this->response = $this->json(
        'GET',
        '/api/attributes/' . $attribute->id
    );

    $this->assertApiResponse($attribute->toArray());
});

test('can update attribute', function () {
    $attribute = factory(Attribute::class)->create();
    $editedAttribute = factory(Attribute::class)->make()->toArray();

    $this->response = $this->json(
        'PUT',
        '/api/attributes/' . $attribute->id,
        $editedAttribute
    );

    $this->assertApiResponse($editedAttribute);
});

test('can delete attribute', function () {
    $attribute = factory(Attribute::class)->create();

    $this->response = $this->json(
        'DELETE',
        '/api/attributes/' . $attribute->id
    );

    $this->assertApiSuccess();

    $this->response = $this->json(
        'GET',
        '/api/attributes/' . $attribute->id
    );

    $this->response->assertStatus(404);
});
