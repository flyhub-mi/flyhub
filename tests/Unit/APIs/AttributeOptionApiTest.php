<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use App\Models\Tenant\AttributeOption;
use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

uses(Tests\TestCase::class);

test('create_attribute_option', function () {
    $attributeOption = factory(AttributeOption::class)->make()->toArray();
    $this->response = $this->json( 'POST', '/api/attribute-options', $attributeOption );
    $this->assertApiResponse($attributeOption);
    }

test('read_attribute_option', function () {
    $attributeOption = factory(AttributeOption::class)->create();
    $this->response = $this->json( 'GET', '/api/attribute-options/' . $attributeOption->id );
    $this->assertApiResponse($attributeOption->toArray());
    }

test('update_attribute_option', function () {
    $attributeOption = factory(AttributeOption::class)->create();
    $editedAttributeOption = factory(AttributeOption::class)->make()->toArray();
    $this->response = $this->json( 'PUT', '/api/attribute-options/' . $attributeOption->id, $editedAttributeOption );
    $this->assertApiResponse($editedAttributeOption);
    }

test('delete_attribute_option', function () {
    $attributeOption = factory(AttributeOption::class)->create();
    $this->response = $this->json( 'DELETE', '/api/attribute-options/' . $attributeOption->id );
    $this->assertApiSuccess();
    $this->response = $this->json( 'GET', '/api/attribute-options/' . $attributeOption->id );
    $this->response->assertStatus(404);
    }
