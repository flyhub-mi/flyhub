<?php

use App\Models\Tenant\Attribute;
use App\Repositories\AttributeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use ApiTestTrait, DatabaseTransactions;

uses(Tests\TestCase::class);

test('create_attribute', function () {
    $attribute = factory(Attribute::class)->make()->toArray();
    $createdAttribute = $this->attributeRepo->create($attribute);
    $createdAttribute = $createdAttribute->toArray();
    $this->assertArrayHasKey('id', $createdAttribute);
    $this->assertNotNull($createdAttribute['id'], 'Created Attribute must have id specified');
    $this->assertNotNull(Attribute::find($createdAttribute['id']), 'Attribute with given id must be in DB');
    $this->assertModelData($attribute, $createdAttribute);
    }

test('read_attribute', function () {
    $attribute = factory(Attribute::class)->create();
    $dbAttribute = $this->attributeRepo->find($attribute->id);
    $dbAttribute = $dbAttribute->toArray();
    $this->assertModelData($attribute->toArray(), $dbAttribute);
    }

test('update_attribute', function () {
    $attribute = factory(Attribute::class)->create();
    $fakeAttribute = factory(Attribute::class)->make()->toArray();
    $updatedAttribute = $this->attributeRepo->update($fakeAttribute, $attribute->id);
    $this->assertModelData($fakeAttribute, $updatedAttribute->toArray());
    $dbAttribute = $this->attributeRepo->find($attribute->id);
    $this->assertModelData($fakeAttribute, $dbAttribute->toArray());
    }

test('delete_attribute', function () {
    $attribute = factory(Attribute::class)->create();
    $resp = $this->attributeRepo->delete($attribute->id);
    $this->assertTrue($resp);
    $this->assertNull(Attribute::find($attribute->id), 'Attribute should not exist in DB');
    }
