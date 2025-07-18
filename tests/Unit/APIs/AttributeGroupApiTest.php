<?php

namespace Tests\Unit\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Tenant\AttributeGroup;

class AttributeGroupApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_attribute_group()
    {
        $attributeGroup = factory(AttributeGroup::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/attribute-groups',
            $attributeGroup
        );

        $this->assertApiResponse($attributeGroup);
    }

    /**
     * @test
     */
    public function test_read_attribute_group()
    {
        $attributeGroup = factory(AttributeGroup::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/attribute-groups/' . $attributeGroup->id
        );

        $this->assertApiResponse($attributeGroup->toArray());
    }

    /**
     * @test
     */
    public function test_update_attribute_group()
    {
        $attributeGroup = factory(AttributeGroup::class)->create();
        $editedAttributeGroup = factory(AttributeGroup::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/attribute-groups/' . $attributeGroup->id,
            $editedAttributeGroup
        );

        $this->assertApiResponse($editedAttributeGroup);
    }

    /**
     * @test
     */
    public function test_delete_attribute_group()
    {
        $attributeGroup = factory(AttributeGroup::class)->create();

        $this->response = $this->json(
            'DELETE',
            '/api/attribute-groups/' . $attributeGroup->id
        );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/attribute-groups/' . $attributeGroup->id
        );

        $this->response->assertStatus(404);
    }
}
