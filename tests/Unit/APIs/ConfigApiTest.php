<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use App\Models\Tenant\Config;
use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

uses(Tests\TestCase::class);

test('create_config', function () {
    $config = factory(Config::class)->make()->toArray();
    $this->response = $this->json( 'POST', '/api/configs', $config );
    $this->assertApiResponse($config);
    }

test('read_config', function () {
    $config = factory(Config::class)->create();
    $this->response = $this->json( 'GET', '/api/configs/' . $config->id );
    $this->assertApiResponse($config->toArray());
    }

test('update_config', function () {
    $config = factory(Config::class)->create();
    $editedConfig = factory(Config::class)->make()->toArray();
    $this->response = $this->json( 'PUT', '/api/configs/' . $config->id, $editedConfig );
    $this->assertApiResponse($editedConfig);
    }

test('delete_config', function () {
    $config = factory(Config::class)->create();
    $this->response = $this->json( 'DELETE', '/api/configs/' . $config->id );
    $this->assertApiSuccess();
    $this->response = $this->json( 'GET', '/api/configs/' . $config->id );
    $this->response->assertStatus(404);
    }
