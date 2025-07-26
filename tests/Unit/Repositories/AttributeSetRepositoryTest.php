<?php

use App\Models\Tenant\AttributeSet;
use App\Repositories\AttributeSetRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use ApiTestTrait, DatabaseTransactions;

uses(Tests\TestCase::class);

test('create_attribute_set', function () {
    $attributeSet = factory(AttributeSet::class)->make()->toArray();
    $createdAttributeSet = $this->attributeSetRepo->create($attributeSet);
    $createdAttributeSet = $createdAttributeSet->toArray();
    $this->assertArrayHasKey('id', $createdAttributeSet);
    $this->assertNotNull($createdAttributeSet['id'], 'Created AttributeSet must have id specified');
    $this->assertNotNull(AttributeSet::find($createdAttributeSet['id']), 'AttributeSet with given id must be in DB');
    $this->assertModelData($attributeSet, $createdAttributeSet);
    }

test('read_attribute_set', function () {
    $attributeSet = factory(AttributeSet::class)->create();
    $dbAttributeSet = $this->attributeSetRepo->find($attributeSet->id);
    $dbAttributeSet = $dbAttributeSet->toArray();
    $this->assertModelData($attributeSet->toArray(), $dbAttributeSet);
    }

test('update_attribute_set', function () {
    $attributeSet = factory(AttributeSet::class)->create();
    $fakeAttributeSet = factory(AttributeSet::class)->make()->toArray();
    $updatedAttributeSet = $this->attributeSetRepo->update($fakeAttributeSet, $attributeSet->id);
    $this->assertModelData($fakeAttributeSet, $updatedAttributeSet->toArray());
    $dbAttributeSet = $this->attributeSetRepo->find($attributeSet->id);
    $this->assertModelData($fakeAttributeSet, $dbAttributeSet->toArray());
    }

test('delete_attribute_set', function () {
    $attributeSet = factory(AttributeSet::class)->create();
    $resp = $this->attributeSetRepo->delete($attributeSet->id);
    $this->assertTrue($resp);
    $this->assertNull(AttributeSet::find($attributeSet->id), 'AttributeSet should not exist in DB');
    }
