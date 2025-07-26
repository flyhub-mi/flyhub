<?php

use App\Models\Tenant\City;
use App\Repositories\CityRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use ApiTestTrait, DatabaseTransactions;

uses(Tests\TestCase::class);

test('create_country_state', function () {
    $countryState = factory(City::class)->make()->toArray();
    $createdCountryState = $this->countryStateRepo->create($countryState);
    $createdCountryState = $createdCountryState->toArray();
    $this->assertArrayHasKey('id', $createdCountryState);
    $this->assertNotNull($createdCountryState['id'], 'Created CountryState must have id specified');
    $this->assertNotNull(City::find($createdCountryState['id']), 'CountryState with given id must be in DB');
    $this->assertModelData($countryState, $createdCountryState);
    }

test('read_country_state', function () {
    $countryState = factory(City::class)->create();
    $dbCountryState = $this->countryStateRepo->find($countryState->id);
    $dbCountryState = $dbCountryState->toArray();
    $this->assertModelData($countryState->toArray(), $dbCountryState);
    }

test('update_country_state', function () {
    $countryState = factory(City::class)->create();
    $fakeCountryState = factory(City::class)->make()->toArray();
    $updatedCountryState = $this->countryStateRepo->update($fakeCountryState, $countryState->id);
    $this->assertModelData($fakeCountryState, $updatedCountryState->toArray());
    $dbCountryState = $this->countryStateRepo->find($countryState->id);
    $this->assertModelData($fakeCountryState, $dbCountryState->toArray());
    }

test('delete_country_state', function () {
    $countryState = factory(City::class)->create();
    $resp = $this->countryStateRepo->delete($countryState->id);
    $this->assertTrue($resp);
    $this->assertNull(City::find($countryState->id), 'CountryState should not exist in DB');
    }
