<?php

namespace Tests\Unit\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Tenant\State;

class CityApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_country()
    {
        $country = factory(State::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/countries',
            $country
        );

        $this->assertApiResponse($country);
    }

    /**
     * @test
     */
    public function test_read_country()
    {
        $country = factory(State::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/countries/' . $country->id
        );

        $this->assertApiResponse($country->toArray());
    }

    /**
     * @test
     */
    public function test_update_country()
    {
        $country = factory(State::class)->create();
        $editedCountry = factory(State::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/countries/' . $country->id,
            $editedCountry
        );

        $this->assertApiResponse($editedCountry);
    }

    /**
     * @test
     */
    public function test_delete_country()
    {
        $country = factory(State::class)->create();

        $this->response = $this->json(
            'DELETE',
            '/api/countries/' . $country->id
        );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/countries/' . $country->id
        );

        $this->response->assertStatus(404);
    }
}
