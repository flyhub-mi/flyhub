<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use App\Models\Tenant\Subscriber;
use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

uses(Tests\TestCase::class);

test('create_subscriber', function () {
    $subscriber = factory(Subscriber::class)->make()->toArray();
    $this->response = $this->json( 'POST', '/api/subscribers', $subscriber );
    $this->assertApiResponse($subscriber);
    }

test('read_subscriber', function () {
    $subscriber = factory(Subscriber::class)->create();
    $this->response = $this->json( 'GET', '/api/subscribers/' . $subscriber->id );
    $this->assertApiResponse($subscriber->toArray());
    }

test('update_subscriber', function () {
    $subscriber = factory(Subscriber::class)->create();
    $editedSubscriber = factory(Subscriber::class)->make()->toArray();
    $this->response = $this->json( 'PUT', '/api/subscribers/' . $subscriber->id, $editedSubscriber );
    $this->assertApiResponse($editedSubscriber);
    }

test('delete_subscriber', function () {
    $subscriber = factory(Subscriber::class)->create();
    $this->response = $this->json( 'DELETE', '/api/subscribers/' . $subscriber->id );
    $this->assertApiSuccess();
    $this->response = $this->json( 'GET', '/api/subscribers/' . $subscriber->id );
    $this->response->assertStatus(404);
    }
