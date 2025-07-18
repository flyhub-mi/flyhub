<?php

namespace Tests\Unit\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Tenant\TaxGroup;

class TaxCategoryApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_tax_category()
    {
        $taxCategory = factory(TaxGroup::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/tax-groups',
            $taxCategory
        );

        $this->assertApiResponse($taxCategory);
    }

    /**
     * @test
     */
    public function test_read_tax_category()
    {
        $taxCategory = factory(TaxGroup::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/tax-groups/' . $taxCategory->id
        );

        $this->assertApiResponse($taxCategory->toArray());
    }

    /**
     * @test
     */
    public function test_update_tax_category()
    {
        $taxCategory = factory(TaxGroup::class)->create();
        $editedTaxCategory = factory(TaxGroup::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/tax-groups/' . $taxCategory->id,
            $editedTaxCategory
        );

        $this->assertApiResponse($editedTaxCategory);
    }

    /**
     * @test
     */
    public function test_delete_tax_category()
    {
        $taxCategory = factory(TaxGroup::class)->create();

        $this->response = $this->json(
            'DELETE',
            '/api/tax-groups/' . $taxCategory->id
        );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/tax-groups/' . $taxCategory->id
        );

        $this->response->assertStatus(404);
    }
}
