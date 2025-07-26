<?php

use App\Models\Tenant\OrderPayment;
use App\Repositories\OrderPaymentRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use ApiTestTrait, DatabaseTransactions;

uses(Tests\TestCase::class);

test('create_order_payment', function () {
    $orderPayment = factory(OrderPayment::class)->make()->toArray();
    $createdOrderPayment = $this->orderPaymentRepo->create($orderPayment);
    $createdOrderPayment = $createdOrderPayment->toArray();
    $this->assertArrayHasKey('id', $createdOrderPayment);
    $this->assertNotNull($createdOrderPayment['id'], 'Created OrderPayment must have id specified');
    $this->assertNotNull(OrderPayment::find($createdOrderPayment['id']), 'OrderPayment with given id must be in DB');
    $this->assertModelData($orderPayment, $createdOrderPayment);
    }

test('read_order_payment', function () {
    $orderPayment = factory(OrderPayment::class)->create();
    $dbOrderPayment = $this->orderPaymentRepo->find($orderPayment->id);
    $dbOrderPayment = $dbOrderPayment->toArray();
    $this->assertModelData($orderPayment->toArray(), $dbOrderPayment);
    }

test('update_order_payment', function () {
    $orderPayment = factory(OrderPayment::class)->create();
    $fakeOrderPayment = factory(OrderPayment::class)->make()->toArray();
    $updatedOrderPayment = $this->orderPaymentRepo->update($fakeOrderPayment, $orderPayment->id);
    $this->assertModelData($fakeOrderPayment, $updatedOrderPayment->toArray());
    $dbOrderPayment = $this->orderPaymentRepo->find($orderPayment->id);
    $this->assertModelData($fakeOrderPayment, $dbOrderPayment->toArray());
    }

test('delete_order_payment', function () {
    $orderPayment = factory(OrderPayment::class)->create();
    $resp = $this->orderPaymentRepo->delete($orderPayment->id);
    $this->assertTrue($resp);
    $this->assertNull(OrderPayment::find($orderPayment->id), 'OrderPayment should not exist in DB');
    }
