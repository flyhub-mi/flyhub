<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use App\Models\Tenant\State;
use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

uses(Tests\TestCase::class);

test('create_country', function () {
    $country = factory(State::class)->make()->toArray();
    $this->response = $this->json( 'POST', '/api/countries', $country );
    $this->assertApiResponse($country);
    }

test('read_country', function () {
    $country = factory(State::class)->create();
    $this->response = $this->json( 'GET', '/api/countries/' . $country->id );
    $this->assertApiResponse($country->toArray());
    }

test('update_country', function () {
    $country = factory(State::class)->create();
    $editedCountry = factory(State::class)->make()->toArray();
    $this->response = $this->json( 'PUT', '/api/countries/' . $country->id, $editedCountry );
    $this->assertApiResponse($editedCountry);
    }

test('delete_country', function () {
    $country = factory(State::class)->create();
    $this->response = $this->json( 'DELETE', '/api/countries/' . $country->id );
    $this->assertApiSuccess();
    $this->response = $this->json( 'GET', '/api/countries/' . $country->id );
    $this->response->assertStatus(404);
    }
