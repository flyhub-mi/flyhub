<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use App\Models\Tenant\AttributeSet;
use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

uses(Tests\TestCase::class);

test('create_attribute_set', function () {
    $attributeSet = factory(AttributeSet::class)->make()->toArray();
    $this->response = $this->json( 'POST', '/api/attribute-sets', $attributeSet );
    $this->assertApiResponse($attributeSet);
    }

test('read_attribute_set', function () {
    $attributeSet = factory(AttributeSet::class)->create();
    $this->response = $this->json( 'GET', '/api/attribute-sets/' . $attributeSet->id );
    $this->assertApiResponse($attributeSet->toArray());
    }

test('update_attribute_set', function () {
    $attributeSet = factory(AttributeSet::class)->create();
    $editedAttributeSet = factory(AttributeSet::class)->make()->toArray();
    $this->response = $this->json( 'PUT', '/api/attribute-sets/' . $attributeSet->id, $editedAttributeSet );
    $this->assertApiResponse($editedAttributeSet);
    }

test('delete_attribute_set', function () {
    $attributeSet = factory(AttributeSet::class)->create();
    $this->response = $this->json( 'DELETE', '/api/attribute-sets/' . $attributeSet->id );
    $this->assertApiSuccess();
    $this->response = $this->json( 'GET', '/api/attribute-sets/' . $attributeSet->id );
    $this->response->assertStatus(404);
    }
