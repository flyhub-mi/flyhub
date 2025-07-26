<?php

use App\Models\Tenant\Channel;
use App\Repositories\ChannelRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use ApiTestTrait, DatabaseTransactions;

uses(Tests\TestCase::class);

test('create_channel', function () {
    $channel = factory(Channel::class)->make()->toArray();
    $createdChannel = $this->channelRepo->create($channel);
    $createdChannel = $createdChannel->toArray();
    $this->assertArrayHasKey('id', $createdChannel);
    $this->assertNotNull($createdChannel['id'], 'Created Channel must have id specified');
    $this->assertNotNull(Channel::find($createdChannel['id']), 'Channel with given id must be in DB');
    $this->assertModelData($channel, $createdChannel);
    }

test('read_channel', function () {
    $channel = factory(Channel::class)->create();
    $dbChannel = $this->channelRepo->find($channel->id);
    $dbChannel = $dbChannel->toArray();
    $this->assertModelData($channel->toArray(), $dbChannel);
    }

test('update_channel', function () {
    $channel = factory(Channel::class)->create();
    $fakeChannel = factory(Channel::class)->make()->toArray();
    $updatedChannel = $this->channelRepo->update($fakeChannel, $channel->id);
    $this->assertModelData($fakeChannel, $updatedChannel->toArray());
    $dbChannel = $this->channelRepo->find($channel->id);
    $this->assertModelData($fakeChannel, $dbChannel->toArray());
    }

test('delete_channel', function () {
    $channel = factory(Channel::class)->create();
    $resp = $this->channelRepo->delete($channel->id);
    $this->assertTrue($resp);
    $this->assertNull(Channel::find($channel->id), 'Channel should not exist in DB');
    }
