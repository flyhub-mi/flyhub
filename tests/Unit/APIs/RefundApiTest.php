<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use App\Models\Tenant\Refund;
use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

uses(Tests\TestCase::class);

test('create_refund', function () {
    $refund = factory(Refund::class)->make()->toArray();
    $this->response = $this->json( 'POST', '/api/refunds', $refund );
    $this->assertApiResponse($refund);
    }

test('read_refund', function () {
    $refund = factory(Refund::class)->create();
    $this->response = $this->json( 'GET', '/api/refunds/' . $refund->id );
    $this->assertApiResponse($refund->toArray());
    }

test('update_refund', function () {
    $refund = factory(Refund::class)->create();
    $editedRefund = factory(Refund::class)->make()->toArray();
    $this->response = $this->json( 'PUT', '/api/refunds/' . $refund->id, $editedRefund );
    $this->assertApiResponse($editedRefund);
    }

test('delete_refund', function () {
    $refund = factory(Refund::class)->create();
    $this->response = $this->json( 'DELETE', '/api/refunds/' . $refund->id );
    $this->assertApiSuccess();
    $this->response = $this->json( 'GET', '/api/refunds/' . $refund->id );
    $this->response->assertStatus(404);
    }
