<?php

namespace Tests\Unit\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Tenant\Subscriber;

class SubscriberApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_subscriber()
    {
        $subscriber = factory(Subscriber::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/subscribers',
            $subscriber
        );

        $this->assertApiResponse($subscriber);
    }

    /**
     * @test
     */
    public function test_read_subscriber()
    {
        $subscriber = factory(Subscriber::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/subscribers/' . $subscriber->id
        );

        $this->assertApiResponse($subscriber->toArray());
    }

    /**
     * @test
     */
    public function test_update_subscriber()
    {
        $subscriber = factory(Subscriber::class)->create();
        $editedSubscriber = factory(Subscriber::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/subscribers/' . $subscriber->id,
            $editedSubscriber
        );

        $this->assertApiResponse($editedSubscriber);
    }

    /**
     * @test
     */
    public function test_delete_subscriber()
    {
        $subscriber = factory(Subscriber::class)->create();

        $this->response = $this->json(
            'DELETE',
            '/api/subscribers/' . $subscriber->id
        );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/subscribers/' . $subscriber->id
        );

        $this->response->assertStatus(404);
    }
}
