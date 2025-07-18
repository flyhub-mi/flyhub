<?php

namespace Tests\Unit\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Tenant\Tax;

class TaxRateApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_tax_rate()
    {
        $taxRate = factory(Tax::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/taxes',
            $taxRate
        );

        $this->assertApiResponse($taxRate);
    }

    /**
     * @test
     */
    public function test_read_tax_rate()
    {
        $taxRate = factory(Tax::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/taxes/' . $taxRate->id
        );

        $this->assertApiResponse($taxRate->toArray());
    }

    /**
     * @test
     */
    public function test_update_tax_rate()
    {
        $taxRate = factory(Tax::class)->create();
        $editedTaxRate = factory(Tax::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/taxes/' . $taxRate->id,
            $editedTaxRate
        );

        $this->assertApiResponse($editedTaxRate);
    }

    /**
     * @test
     */
    public function test_delete_tax_rate()
    {
        $taxRate = factory(Tax::class)->create();

        $this->response = $this->json(
            'DELETE',
            '/api/taxes/' . $taxRate->id
        );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/taxes/' . $taxRate->id
        );

        $this->response->assertStatus(404);
    }
}
