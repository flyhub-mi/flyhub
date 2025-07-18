<?php

namespace Tests\Unit\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Tenant\AttributeSet;

class AttributeSetApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_attribute_set()
    {
        $attributeSet = factory(AttributeSet::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/attribute-sets',
            $attributeSet
        );

        $this->assertApiResponse($attributeSet);
    }

    /**
     * @test
     */
    public function test_read_attribute_set()
    {
        $attributeSet = factory(AttributeSet::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/attribute-sets/' . $attributeSet->id
        );

        $this->assertApiResponse($attributeSet->toArray());
    }

    /**
     * @test
     */
    public function test_update_attribute_set()
    {
        $attributeSet = factory(AttributeSet::class)->create();
        $editedAttributeSet = factory(AttributeSet::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/attribute-sets/' . $attributeSet->id,
            $editedAttributeSet
        );

        $this->assertApiResponse($editedAttributeSet);
    }

    /**
     * @test
     */
    public function test_delete_attribute_set()
    {
        $attributeSet = factory(AttributeSet::class)->create();

        $this->response = $this->json(
            'DELETE',
            '/api/attribute-sets/' . $attributeSet->id
        );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/attribute-sets/' . $attributeSet->id
        );

        $this->response->assertStatus(404);
    }
}
