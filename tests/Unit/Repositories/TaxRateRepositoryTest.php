<?php namespace Tests\Unit\Repositories;

use App\Models\Tenant\Tax;
use App\Repositories\TaxRateRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class TaxRateRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var TaxRateRepository
     */
    protected $taxRateRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->taxRateRepo = \App::make(TaxRateRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_tax_rate()
    {
        $taxRate = factory(Tax::class)->make()->toArray();

        $createdTaxRate = $this->taxRateRepo->create($taxRate);

        $createdTaxRate = $createdTaxRate->toArray();
        $this->assertArrayHasKey('id', $createdTaxRate);
        $this->assertNotNull($createdTaxRate['id'], 'Created TaxRate must have id specified');
        $this->assertNotNull(Tax::find($createdTaxRate['id']), 'TaxRate with given id must be in DB');
        $this->assertModelData($taxRate, $createdTaxRate);
    }

    /**
     * @test read
     */
    public function test_read_tax_rate()
    {
        $taxRate = factory(Tax::class)->create();

        $dbTaxRate = $this->taxRateRepo->find($taxRate->id);

        $dbTaxRate = $dbTaxRate->toArray();
        $this->assertModelData($taxRate->toArray(), $dbTaxRate);
    }

    /**
     * @test update
     */
    public function test_update_tax_rate()
    {
        $taxRate = factory(Tax::class)->create();
        $fakeTaxRate = factory(Tax::class)->make()->toArray();

        $updatedTaxRate = $this->taxRateRepo->update($fakeTaxRate, $taxRate->id);

        $this->assertModelData($fakeTaxRate, $updatedTaxRate->toArray());
        $dbTaxRate = $this->taxRateRepo->find($taxRate->id);
        $this->assertModelData($fakeTaxRate, $dbTaxRate->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_tax_rate()
    {
        $taxRate = factory(Tax::class)->create();

        $resp = $this->taxRateRepo->delete($taxRate->id);

        $this->assertTrue($resp);
        $this->assertNull(Tax::find($taxRate->id), 'TaxRate should not exist in DB');
    }
}
