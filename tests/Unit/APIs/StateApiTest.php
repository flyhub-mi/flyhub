<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use App\Models\Tenant\City;
use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

uses(Tests\TestCase::class);

test('create_country_state', function () {
    $countryState = factory(City::class)->make()->toArray();
    $this->response = $this->json( 'POST', '/api/country_states', $countryState );
    $this->assertApiResponse($countryState);
    }

test('read_country_state', function () {
    $countryState = factory(City::class)->create();
    $this->response = $this->json( 'GET', '/api/country_states/' . $countryState->id );
    $this->assertApiResponse($countryState->toArray());
    }

test('update_country_state', function () {
    $countryState = factory(City::class)->create();
    $editedCountryState = factory(City::class)->make()->toArray();
    $this->response = $this->json( 'PUT', '/api/country_states/' . $countryState->id, $editedCountryState );
    $this->assertApiResponse($editedCountryState);
    }

test('delete_country_state', function () {
    $countryState = factory(City::class)->create();
    $this->response = $this->json( 'DELETE', '/api/country_states/' . $countryState->id );
    $this->assertApiSuccess();
    $this->response = $this->json( 'GET', '/api/country_states/' . $countryState->id );
    $this->response->assertStatus(404);
    }
