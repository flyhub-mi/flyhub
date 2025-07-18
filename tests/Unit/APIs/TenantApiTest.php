<?php

namespace Tests\Unit\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Tenant;

class TenantApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_tenant()
    {
        $tenant = factory(Tenant::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/tenants',
            $tenant
        );

        $this->assertApiResponse($tenant);
    }

    /**
     * @test
     */
    public function test_read_tenant()
    {
        $tenant = factory(Tenant::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/tenants/' . $tenant->id
        );

        $this->assertApiResponse($tenant->toArray());
    }

    /**
     * @test
     */
    public function test_update_tenant()
    {
        $tenant = factory(Tenant::class)->create();
        $editedTenant = factory(Tenant::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/tenants/' . $tenant->id,
            $editedTenant
        );

        $this->assertApiResponse($editedTenant);
    }

    /**
     * @test
     */
    public function test_delete_tenant()
    {
        $tenant = factory(Tenant::class)->create();

        $this->response = $this->json(
            'DELETE',
            '/api/tenants/' . $tenant->id
        );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/tenants/' . $tenant->id
        );

        $this->response->assertStatus(404);
    }
}
