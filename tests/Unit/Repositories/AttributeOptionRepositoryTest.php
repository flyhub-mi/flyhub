<?php

use App\Models\Tenant\AttributeOption;
use App\Repositories\AttributeOptionRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use ApiTestTrait, DatabaseTransactions;

uses(Tests\TestCase::class);

test('create_attribute_option', function () {
    $attributeOption = factory(AttributeOption::class)->make()->toArray();
    $createdAttributeOption = $this->attributeOptionRepo->create($attributeOption);
    $createdAttributeOption = $createdAttributeOption->toArray();
    $this->assertArrayHasKey('id', $createdAttributeOption);
    $this->assertNotNull($createdAttributeOption['id'], 'Created AttributeOption must have id specified');
    $this->assertNotNull(AttributeOption::find($createdAttributeOption['id']), 'AttributeOption with given id must be in DB');
    $this->assertModelData($attributeOption, $createdAttributeOption);
    }

test('read_attribute_option', function () {
    $attributeOption = factory(AttributeOption::class)->create();
    $dbAttributeOption = $this->attributeOptionRepo->find($attributeOption->id);
    $dbAttributeOption = $dbAttributeOption->toArray();
    $this->assertModelData($attributeOption->toArray(), $dbAttributeOption);
    }

test('update_attribute_option', function () {
    $attributeOption = factory(AttributeOption::class)->create();
    $fakeAttributeOption = factory(AttributeOption::class)->make()->toArray();
    $updatedAttributeOption = $this->attributeOptionRepo->update($fakeAttributeOption, $attributeOption->id);
    $this->assertModelData($fakeAttributeOption, $updatedAttributeOption->toArray());
    $dbAttributeOption = $this->attributeOptionRepo->find($attributeOption->id);
    $this->assertModelData($fakeAttributeOption, $dbAttributeOption->toArray());
    }

test('delete_attribute_option', function () {
    $attributeOption = factory(AttributeOption::class)->create();
    $resp = $this->attributeOptionRepo->delete($attributeOption->id);
    $this->assertTrue($resp);
    $this->assertNull(AttributeOption::find($attributeOption->id), 'AttributeOption should not exist in DB');
    }
