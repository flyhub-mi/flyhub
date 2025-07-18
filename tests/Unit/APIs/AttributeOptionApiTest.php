<?php

namespace Tests\Unit\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Tenant\AttributeOption;

class AttributeOptionApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_attribute_option()
    {
        $attributeOption = factory(AttributeOption::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/attribute-options',
            $attributeOption
        );

        $this->assertApiResponse($attributeOption);
    }

    /**
     * @test
     */
    public function test_read_attribute_option()
    {
        $attributeOption = factory(AttributeOption::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/attribute-options/' . $attributeOption->id
        );

        $this->assertApiResponse($attributeOption->toArray());
    }

    /**
     * @test
     */
    public function test_update_attribute_option()
    {
        $attributeOption = factory(AttributeOption::class)->create();
        $editedAttributeOption = factory(AttributeOption::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/attribute-options/' . $attributeOption->id,
            $editedAttributeOption
        );

        $this->assertApiResponse($editedAttributeOption);
    }

    /**
     * @test
     */
    public function test_delete_attribute_option()
    {
        $attributeOption = factory(AttributeOption::class)->create();

        $this->response = $this->json(
            'DELETE',
            '/api/attribute-options/' . $attributeOption->id
        );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/attribute-options/' . $attributeOption->id
        );

        $this->response->assertStatus(404);
    }
}
