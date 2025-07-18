<?php

namespace Tests\Unit\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Tenant\ProductAttribute;

class ProductAttributeApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_product_attribute_value()
    {
        $productAttributeValue = factory(ProductAttribute::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/product-attributes',
            $productAttributeValue
        );

        $this->assertApiResponse($productAttributeValue);
    }

    /**
     * @test
     */
    public function test_read_product_attribute_value()
    {
        $productAttributeValue = factory(ProductAttribute::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/product-attributes/' . $productAttributeValue->id
        );

        $this->assertApiResponse($productAttributeValue->toArray());
    }

    /**
     * @test
     */
    public function test_update_product_attribute_value()
    {
        $productAttributeValue = factory(ProductAttribute::class)->create();
        $editedProductAttribute = factory(ProductAttribute::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/product-attributes/' . $productAttributeValue->id,
            $editedProductAttribute
        );

        $this->assertApiResponse($editedProductAttribute);
    }

    /**
     * @test
     */
    public function test_delete_product_attribute_value()
    {
        $productAttributeValue = factory(ProductAttribute::class)->create();

        $this->response = $this->json(
            'DELETE',
            '/api/product-attributes/' . $productAttributeValue->id
        );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/product-attributes/' . $productAttributeValue->id
        );

        $this->response->assertStatus(404);
    }
}
