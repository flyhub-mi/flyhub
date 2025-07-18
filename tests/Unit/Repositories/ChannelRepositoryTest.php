<?php namespace Tests\Unit\Repositories;

use App\Models\Tenant\Channel;
use App\Repositories\ChannelRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ChannelRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var ChannelRepository
     */
    protected $channelRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->channelRepo = \App::make(ChannelRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_channel()
    {
        $channel = factory(Channel::class)->make()->toArray();

        $createdChannel = $this->channelRepo->create($channel);

        $createdChannel = $createdChannel->toArray();
        $this->assertArrayHasKey('id', $createdChannel);
        $this->assertNotNull($createdChannel['id'], 'Created Channel must have id specified');
        $this->assertNotNull(Channel::find($createdChannel['id']), 'Channel with given id must be in DB');
        $this->assertModelData($channel, $createdChannel);
    }

    /**
     * @test read
     */
    public function test_read_channel()
    {
        $channel = factory(Channel::class)->create();

        $dbChannel = $this->channelRepo->find($channel->id);

        $dbChannel = $dbChannel->toArray();
        $this->assertModelData($channel->toArray(), $dbChannel);
    }

    /**
     * @test update
     */
    public function test_update_channel()
    {
        $channel = factory(Channel::class)->create();
        $fakeChannel = factory(Channel::class)->make()->toArray();

        $updatedChannel = $this->channelRepo->update($fakeChannel, $channel->id);

        $this->assertModelData($fakeChannel, $updatedChannel->toArray());
        $dbChannel = $this->channelRepo->find($channel->id);
        $this->assertModelData($fakeChannel, $dbChannel->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_channel()
    {
        $channel = factory(Channel::class)->create();

        $resp = $this->channelRepo->delete($channel->id);

        $this->assertTrue($resp);
        $this->assertNull(Channel::find($channel->id), 'Channel should not exist in DB');
    }
}
