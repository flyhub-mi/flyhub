<?php

use App\Models\Tenant\Config;
use App\Repositories\ConfigRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use ApiTestTrait, DatabaseTransactions;

uses(Tests\TestCase::class);

test('create_config', function () {
    $config = factory(Config::class)->make()->toArray();
    $createdConfig = $this->configRepo->create($config);
    $createdConfig = $createdConfig->toArray();
    $this->assertArrayHasKey('id', $createdConfig);
    $this->assertNotNull($createdConfig['id'], 'Created Config must have id specified');
    $this->assertNotNull(Config::find($createdConfig['id']), 'Config with given id must be in DB');
    $this->assertModelData($config, $createdConfig);
    }

test('read_config', function () {
    $config = factory(Config::class)->create();
    $dbConfig = $this->configRepo->find($config->id);
    $dbConfig = $dbConfig->toArray();
    $this->assertModelData($config->toArray(), $dbConfig);
    }

test('update_config', function () {
    $config = factory(Config::class)->create();
    $fakeConfig = factory(Config::class)->make()->toArray();
    $updatedConfig = $this->configRepo->update($fakeConfig, $config->id);
    $this->assertModelData($fakeConfig, $updatedConfig->toArray());
    $dbConfig = $this->configRepo->find($config->id);
    $this->assertModelData($fakeConfig, $dbConfig->toArray());
    }

test('delete_config', function () {
    $config = factory(Config::class)->create();
    $resp = $this->configRepo->delete($config->id);
    $this->assertTrue($resp);
    $this->assertNull(Config::find($config->id), 'Config should not exist in DB');
    }
