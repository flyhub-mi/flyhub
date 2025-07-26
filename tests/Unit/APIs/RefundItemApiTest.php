<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use App\Models\Tenant\RefundItem;
use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

uses(Tests\TestCase::class);

test('create_refund_item', function () {
    $refundItem = factory(RefundItem::class)->make()->toArray();
    $this->response = $this->json( 'POST', '/api/refund-items', $refundItem );
    $this->assertApiResponse($refundItem);
    }

test('read_refund_item', function () {
    $refundItem = factory(RefundItem::class)->create();
    $this->response = $this->json( 'GET', '/api/refund-items/' . $refundItem->id );
    $this->assertApiResponse($refundItem->toArray());
    }

test('update_refund_item', function () {
    $refundItem = factory(RefundItem::class)->create();
    $editedRefundItem = factory(RefundItem::class)->make()->toArray();
    $this->response = $this->json( 'PUT', '/api/refund-items/' . $refundItem->id, $editedRefundItem );
    $this->assertApiResponse($editedRefundItem);
    }

test('delete_refund_item', function () {
    $refundItem = factory(RefundItem::class)->create();
    $this->response = $this->json( 'DELETE', '/api/refund-items/' . $refundItem->id );
    $this->assertApiSuccess();
    $this->response = $this->json( 'GET', '/api/refund-items/' . $refundItem->id );
    $this->response->assertStatus(404);
    }
