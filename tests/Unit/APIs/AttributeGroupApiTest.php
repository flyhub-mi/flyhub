<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use App\Models\Tenant\AttributeGroup;
use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

uses(Tests\TestCase::class);

test('create_attribute_group', function () {
    $attributeGroup = factory(AttributeGroup::class)->make()->toArray();
    $this->response = $this->json( 'POST', '/api/attribute-groups', $attributeGroup );
    $this->assertApiResponse($attributeGroup);
    }

test('read_attribute_group', function () {
    $attributeGroup = factory(AttributeGroup::class)->create();
    $this->response = $this->json( 'GET', '/api/attribute-groups/' . $attributeGroup->id );
    $this->assertApiResponse($attributeGroup->toArray());
    }

test('update_attribute_group', function () {
    $attributeGroup = factory(AttributeGroup::class)->create();
    $editedAttributeGroup = factory(AttributeGroup::class)->make()->toArray();
    $this->response = $this->json( 'PUT', '/api/attribute-groups/' . $attributeGroup->id, $editedAttributeGroup );
    $this->assertApiResponse($editedAttributeGroup);
    }

test('delete_attribute_group', function () {
    $attributeGroup = factory(AttributeGroup::class)->create();
    $this->response = $this->json( 'DELETE', '/api/attribute-groups/' . $attributeGroup->id );
    $this->assertApiSuccess();
    $this->response = $this->json( 'GET', '/api/attribute-groups/' . $attributeGroup->id );
    $this->response->assertStatus(404);
    }
