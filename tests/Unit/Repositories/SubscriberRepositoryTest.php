<?php namespace Tests\Unit\Repositories;

use App\Models\Tenant\Subscriber;
use App\Repositories\SubscriberRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class SubscriberRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var SubscriberRepository
     */
    protected $subscriberRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->subscriberRepo = \App::make(SubscriberRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_subscriber()
    {
        $subscriber = factory(Subscriber::class)->make()->toArray();

        $createdSubscriber = $this->subscriberRepo->create($subscriber);

        $createdSubscriber = $createdSubscriber->toArray();
        $this->assertArrayHasKey('id', $createdSubscriber);
        $this->assertNotNull($createdSubscriber['id'], 'Created Subscriber must have id specified');
        $this->assertNotNull(Subscriber::find($createdSubscriber['id']), 'Subscriber with given id must be in DB');
        $this->assertModelData($subscriber, $createdSubscriber);
    }

    /**
     * @test read
     */
    public function test_read_subscriber()
    {
        $subscriber = factory(Subscriber::class)->create();

        $dbSubscriber = $this->subscriberRepo->find($subscriber->id);

        $dbSubscriber = $dbSubscriber->toArray();
        $this->assertModelData($subscriber->toArray(), $dbSubscriber);
    }

    /**
     * @test update
     */
    public function test_update_subscriber()
    {
        $subscriber = factory(Subscriber::class)->create();
        $fakeSubscriber = factory(Subscriber::class)->make()->toArray();

        $updatedSubscriber = $this->subscriberRepo->update($fakeSubscriber, $subscriber->id);

        $this->assertModelData($fakeSubscriber, $updatedSubscriber->toArray());
        $dbSubscriber = $this->subscriberRepo->find($subscriber->id);
        $this->assertModelData($fakeSubscriber, $dbSubscriber->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_subscriber()
    {
        $subscriber = factory(Subscriber::class)->create();

        $resp = $this->subscriberRepo->delete($subscriber->id);

        $this->assertTrue($resp);
        $this->assertNull(Subscriber::find($subscriber->id), 'Subscriber should not exist in DB');
    }
}
