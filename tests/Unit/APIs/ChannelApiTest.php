<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use App\Models\Tenant\Channel;
use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

uses(Tests\TestCase::class);

test('create_channel', function () {
    $channel = factory(Channel::class)->make()->toArray();
    $this->response = $this->json( 'POST', '/api/channels', $channel );
    $this->assertApiResponse($channel);
    }

test('read_channel', function () {
    $channel = factory(Channel::class)->create();
    $this->response = $this->json( 'GET', '/api/channels/' . $channel->id );
    $this->assertApiResponse($channel->toArray());
    }

test('update_channel', function () {
    $channel = factory(Channel::class)->create();
    $editedChannel = factory(Channel::class)->make()->toArray();
    $this->response = $this->json( 'PUT', '/api/channels/' . $channel->id, $editedChannel );
    $this->assertApiResponse($editedChannel);
    }

test('delete_channel', function () {
    $channel = factory(Channel::class)->create();
    $this->response = $this->json( 'DELETE', '/api/channels/' . $channel->id );
    $this->assertApiSuccess();
    $this->response = $this->json( 'GET', '/api/channels/' . $channel->id );
    $this->response->assertStatus(404);
    }
