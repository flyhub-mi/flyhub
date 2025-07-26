<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use App\Models\Tenant\Refunds;
use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

uses(Tests\TestCase::class);

test('create_refunds', function () {
    $refunds = factory(Refunds::class)->make()->toArray();
    $this->response = $this->json( 'POST', '/api/refunds', $refunds );
    $this->assertApiResponse($refunds);
    }

test('read_refunds', function () {
    $refunds = factory(Refunds::class)->create();
    $this->response = $this->json( 'GET', '/api/refunds/' . $refunds->id );
    $this->assertApiResponse($refunds->toArray());
    }

test('update_refunds', function () {
    $refunds = factory(Refunds::class)->create();
    $editedRefunds = factory(Refunds::class)->make()->toArray();
    $this->response = $this->json( 'PUT', '/api/refunds/' . $refunds->id, $editedRefunds );
    $this->assertApiResponse($editedRefunds);
    }

test('delete_refunds', function () {
    $refunds = factory(Refunds::class)->create();
    $this->response = $this->json( 'DELETE', '/api/refunds/' . $refunds->id );
    $this->assertApiSuccess();
    $this->response = $this->json( 'GET', '/api/refunds/' . $refunds->id );
    $this->response->assertStatus(404);
    }
