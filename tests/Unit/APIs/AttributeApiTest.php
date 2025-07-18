<?php

namespace Tests\Unit\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Tenant\Attribute;

class AttributeApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_attribute()
    {
        $attribute = factory(Attribute::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/attributes',
            $attribute
        );

        $this->assertApiResponse($attribute);
    }

    /**
     * @test
     */
    public function test_read_attribute()
    {
        $attribute = factory(Attribute::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/attributes/' . $attribute->id
        );

        $this->assertApiResponse($attribute->toArray());
    }

    /**
     * @test
     */
    public function test_update_attribute()
    {
        $attribute = factory(Attribute::class)->create();
        $editedAttribute = factory(Attribute::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/attributes/' . $attribute->id,
            $editedAttribute
        );

        $this->assertApiResponse($editedAttribute);
    }

    /**
     * @test
     */
    public function test_delete_attribute()
    {
        $attribute = factory(Attribute::class)->create();

        $this->response = $this->json(
            'DELETE',
            '/api/attributes/' . $attribute->id
        );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/attributes/' . $attribute->id
        );

        $this->response->assertStatus(404);
    }
}
