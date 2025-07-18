<?php

namespace Tests\Unit\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Tenant\Config;

class ConfigApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_config()
    {
        $config = factory(Config::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/configs',
            $config
        );

        $this->assertApiResponse($config);
    }

    /**
     * @test
     */
    public function test_read_config()
    {
        $config = factory(Config::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/configs/' . $config->id
        );

        $this->assertApiResponse($config->toArray());
    }

    /**
     * @test
     */
    public function test_update_config()
    {
        $config = factory(Config::class)->create();
        $editedConfig = factory(Config::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/configs/' . $config->id,
            $editedConfig
        );

        $this->assertApiResponse($editedConfig);
    }

    /**
     * @test
     */
    public function test_delete_config()
    {
        $config = factory(Config::class)->create();

        $this->response = $this->json(
            'DELETE',
            '/api/configs/' . $config->id
        );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/configs/' . $config->id
        );

        $this->response->assertStatus(404);
    }
}
