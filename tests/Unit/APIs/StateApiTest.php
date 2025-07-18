<?php

namespace Tests\Unit\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Tenant\City;

class StateApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_country_state()
    {
        $countryState = factory(City::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/country_states',
            $countryState
        );

        $this->assertApiResponse($countryState);
    }

    /**
     * @test
     */
    public function test_read_country_state()
    {
        $countryState = factory(City::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/country_states/' . $countryState->id
        );

        $this->assertApiResponse($countryState->toArray());
    }

    /**
     * @test
     */
    public function test_update_country_state()
    {
        $countryState = factory(City::class)->create();
        $editedCountryState = factory(City::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/country_states/' . $countryState->id,
            $editedCountryState
        );

        $this->assertApiResponse($editedCountryState);
    }

    /**
     * @test
     */
    public function test_delete_country_state()
    {
        $countryState = factory(City::class)->create();

        $this->response = $this->json(
            'DELETE',
            '/api/country_states/' . $countryState->id
        );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/country_states/' . $countryState->id
        );

        $this->response->assertStatus(404);
    }
}
