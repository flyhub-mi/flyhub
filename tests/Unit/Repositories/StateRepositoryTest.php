<?php

namespace Tests\Unit\Repositories;

use App\Models\Tenant\State;
use App\Repositories\StateRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class StateRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var StateRepository
     */
    protected $countryRepo;

    public function setUp(): void
    {
        parent::setUp();
        $this->countryRepo = \App::make(StateRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_country()
    {
        $country = factory(State::class)->make()->toArray();

        $createdCountry = $this->countryRepo->create($country);

        $createdCountry = $createdCountry->toArray();
        $this->assertArrayHasKey('id', $createdCountry);
        $this->assertNotNull($createdCountry['id'], 'Created Country must have id specified');
        $this->assertNotNull(State::find($createdCountry['id']), 'Country with given id must be in DB');
        $this->assertModelData($country, $createdCountry);
    }

    /**
     * @test read
     */
    public function test_read_country()
    {
        $country = factory(State::class)->create();

        $dbCountry = $this->countryRepo->find($country->id);

        $dbCountry = $dbCountry->toArray();
        $this->assertModelData($country->toArray(), $dbCountry);
    }

    /**
     * @test update
     */
    public function test_update_country()
    {
        $country = factory(State::class)->create();
        $fakeCountry = factory(State::class)->make()->toArray();

        $updatedCountry = $this->countryRepo->update($fakeCountry, $country->id);

        $this->assertModelData($fakeCountry, $updatedCountry->toArray());
        $dbCountry = $this->countryRepo->find($country->id);
        $this->assertModelData($fakeCountry, $dbCountry->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_country()
    {
        $country = factory(State::class)->create();

        $resp = $this->countryRepo->delete($country->id);

        $this->assertTrue($resp);
        $this->assertNull(State::find($country->id), 'Country should not exist in DB');
    }
}
