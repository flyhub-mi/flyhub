<?php namespace Tests\Unit\Repositories;

use App\Models\Tenant;
use App\Repositories\TenantRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class TenantRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var TenantRepository
     */
    protected $tenantRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->tenantRepo = \App::make(TenantRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_tenant()
    {
        $tenant = factory(Tenant::class)->make()->toArray();

        $createdTenant = $this->tenantRepo->create($tenant);

        $createdTenant = $createdTenant->toArray();
        $this->assertArrayHasKey('id', $createdTenant);
        $this->assertNotNull($createdTenant['id'], 'Created Tenant must have id specified');
        $this->assertNotNull(Tenant::find($createdTenant['id']), 'Tenant with given id must be in DB');
        $this->assertModelData($tenant, $createdTenant);
    }

    /**
     * @test read
     */
    public function test_read_tenant()
    {
        $tenant = factory(Tenant::class)->create();

        $dbTenant = $this->tenantRepo->find($tenant->id);

        $dbTenant = $dbTenant->toArray();
        $this->assertModelData($tenant->toArray(), $dbTenant);
    }

    /**
     * @test update
     */
    public function test_update_tenant()
    {
        $tenant = factory(Tenant::class)->create();
        $fakeTenant = factory(Tenant::class)->make()->toArray();

        $updatedTenant = $this->tenantRepo->update($fakeTenant, $tenant->id);

        $this->assertModelData($fakeTenant, $updatedTenant->toArray());
        $dbTenant = $this->tenantRepo->find($tenant->id);
        $this->assertModelData($fakeTenant, $dbTenant->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_tenant()
    {
        $tenant = factory(Tenant::class)->create();

        $resp = $this->tenantRepo->delete($tenant->id);

        $this->assertTrue($resp);
        $this->assertNull(Tenant::find($tenant->id), 'Tenant should not exist in DB');
    }
}
