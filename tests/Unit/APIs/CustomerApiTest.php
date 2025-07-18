<?php

namespace Tests\Unit\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Tenant\Customer;

class CustomerApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_customer()
    {
        $customer = factory(Customer::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/customers',
            $customer
        );

        $this->assertApiResponse($customer);
    }

    /**
     * @test
     */
    public function test_read_customer()
    {
        $customer = factory(Customer::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/customers/' . $customer->id
        );

        $this->assertApiResponse($customer->toArray());
    }

    /**
     * @test
     */
    public function test_update_customer()
    {
        $customer = factory(Customer::class)->create();
        $editedCustomer = factory(Customer::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/customers/' . $customer->id,
            $editedCustomer
        );

        $this->assertApiResponse($editedCustomer);
    }

    /**
     * @test
     */
    public function test_delete_customer()
    {
        $customer = factory(Customer::class)->create();

        $this->response = $this->json(
            'DELETE',
            '/api/customers/' . $customer->id
        );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/customers/' . $customer->id
        );

        $this->response->assertStatus(404);
    }
}
