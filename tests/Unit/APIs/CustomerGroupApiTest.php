<?php

namespace Tests\Unit\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Tenant\CustomerGroup;

class CustomerGroupApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_customer_group()
    {
        $customerGroup = factory(CustomerGroup::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/customer-groups',
            $customerGroup
        );

        $this->assertApiResponse($customerGroup);
    }

    /**
     * @test
     */
    public function test_read_customer_group()
    {
        $customerGroup = factory(CustomerGroup::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/customer-groups/' . $customerGroup->id
        );

        $this->assertApiResponse($customerGroup->toArray());
    }

    /**
     * @test
     */
    public function test_update_customer_group()
    {
        $customerGroup = factory(CustomerGroup::class)->create();
        $editedCustomerGroup = factory(CustomerGroup::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/customer-groups/' . $customerGroup->id,
            $editedCustomerGroup
        );

        $this->assertApiResponse($editedCustomerGroup);
    }

    /**
     * @test
     */
    public function test_delete_customer_group()
    {
        $customerGroup = factory(CustomerGroup::class)->create();

        $this->response = $this->json(
            'DELETE',
            '/api/customer-groups/' . $customerGroup->id
        );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/customer-groups/' . $customerGroup->id
        );

        $this->response->assertStatus(404);
    }
}
