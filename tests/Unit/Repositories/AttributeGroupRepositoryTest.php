<?php

namespace Tests\Unit\Repositories;

use App\Models\Tenant\AttributeGroup;
use App\Repositories\AttributeGroupRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class AttributeGroupRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var AttributeGroupRepository
     */
    protected $attributeGroupRepo;

    public function setUp(): void
    {
        parent::setUp();
        $this->attributeGroupRepo = \App::make(AttributeGroupRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_attribute_group()
    {
        $attributeGroup = factory(AttributeGroup::class)->make()->toArray();

        $createdAttributeGroup = $this->attributeGroupRepo->create($attributeGroup);

        $createdAttributeGroup = $createdAttributeGroup->toArray();
        $this->assertArrayHasKey('id', $createdAttributeGroup);
        $this->assertNotNull($createdAttributeGroup['id'], 'Created AttributeGroup must have id specified');
        $this->assertNotNull(AttributeGroup::find($createdAttributeGroup['id']), 'AttributeGroup with given id must be in DB');
        $this->assertModelData($attributeGroup, $createdAttributeGroup);
    }

    /**
     * @test read
     */
    public function test_read_attribute_group()
    {
        $attributeGroup = factory(AttributeGroup::class)->create();

        $dbAttributeGroup = $this->attributeGroupRepo->find($attributeGroup->id);

        $dbAttributeGroup = $dbAttributeGroup->toArray();
        $this->assertModelData($attributeGroup->toArray(), $dbAttributeGroup);
    }

    /**
     * @test update
     */
    public function test_update_attribute_group()
    {
        $attributeGroup = factory(AttributeGroup::class)->create();
        $fakeAttributeGroup = factory(AttributeGroup::class)->make()->toArray();

        $updatedAttributeGroup = $this->attributeGroupRepo->update($fakeAttributeGroup, $attributeGroup->id);

        $this->assertModelData($fakeAttributeGroup, $updatedAttributeGroup->toArray());
        $dbAttributeGroup = $this->attributeGroupRepo->find($attributeGroup->id);
        $this->assertModelData($fakeAttributeGroup, $dbAttributeGroup->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_attribute_group()
    {
        $attributeGroup = factory(AttributeGroup::class)->create();

        $resp = $this->attributeGroupRepo->delete($attributeGroup->id);

        $this->assertTrue($resp);
        $this->assertNull(AttributeGroup::find($attributeGroup->id), 'AttributeGroup should not exist in DB');
    }
}
