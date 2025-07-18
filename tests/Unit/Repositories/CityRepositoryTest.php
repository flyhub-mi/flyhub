<?php namespace Tests\Unit\Repositories;

use App\Models\Tenant\City;
use App\Repositories\CityRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class CityRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var CityRepository
     */
    protected $countryStateRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->countryStateRepo = \App::make(CityRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_country_state()
    {
        $countryState = factory(City::class)->make()->toArray();

        $createdCountryState = $this->countryStateRepo->create($countryState);

        $createdCountryState = $createdCountryState->toArray();
        $this->assertArrayHasKey('id', $createdCountryState);
        $this->assertNotNull($createdCountryState['id'], 'Created CountryState must have id specified');
        $this->assertNotNull(City::find($createdCountryState['id']), 'CountryState with given id must be in DB');
        $this->assertModelData($countryState, $createdCountryState);
    }

    /**
     * @test read
     */
    public function test_read_country_state()
    {
        $countryState = factory(City::class)->create();

        $dbCountryState = $this->countryStateRepo->find($countryState->id);

        $dbCountryState = $dbCountryState->toArray();
        $this->assertModelData($countryState->toArray(), $dbCountryState);
    }

    /**
     * @test update
     */
    public function test_update_country_state()
    {
        $countryState = factory(City::class)->create();
        $fakeCountryState = factory(City::class)->make()->toArray();

        $updatedCountryState = $this->countryStateRepo->update($fakeCountryState, $countryState->id);

        $this->assertModelData($fakeCountryState, $updatedCountryState->toArray());
        $dbCountryState = $this->countryStateRepo->find($countryState->id);
        $this->assertModelData($fakeCountryState, $dbCountryState->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_country_state()
    {
        $countryState = factory(City::class)->create();

        $resp = $this->countryStateRepo->delete($countryState->id);

        $this->assertTrue($resp);
        $this->assertNull(City::find($countryState->id), 'CountryState should not exist in DB');
    }
}
