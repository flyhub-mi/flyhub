<?php

use App\Jobs\Tenant\ChannelSendResourceJob;
use App\Models\Tenant\Order;
use App\Observers\OrderObserver;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;

uses(Tests\TestCase::class, DatabaseTransactions::class);

test('created_dispatches_job_when_status_is_processing', function () {
    Queue::fake();

    $order = Order::factory()->create([
        'status' => 'processing'
    ]);

    $observer = new OrderObserver();
    $observer->created($order);

    Queue::assertPushed(ChannelSendResourceJob::class, function ($job) use ($order) {
        return $job->order->id === $order->id;
    });
});

test('created_dispatches_job_when_status_is_em_separacao', function () {
    Queue::fake();

    $order = Order::factory()->create([
        'status' => 'em-separacao'
    ]);

    $observer = new OrderObserver();
    $observer->created($order);

    Queue::assertPushed(ChannelSendResourceJob::class);
});

test('created_dispatches_job_when_status_is_em_andamento', function () {
    Queue::fake();

    $order = Order::factory()->create([
        'status' => 'Em andamento'
    ]);

    $observer = new OrderObserver();
    $observer->created($order);

    Queue::assertPushed(ChannelSendResourceJob::class);
});

test('created_dispatches_job_when_status_is_em_aberto', function () {
    Queue::fake();

    $order = Order::factory()->create([
        'status' => 'Em aberto'
    ]);

    $observer = new OrderObserver();
    $observer->created($order);

    Queue::assertPushed(ChannelSendResourceJob::class);
});

test('created_does_not_dispatch_job_when_status_is_not_appropriate', function () {
    Queue::fake();

    $order = Order::factory()->create([
        'status' => 'completed'
    ]);

    $observer = new OrderObserver();
    $observer->created($order);

    Queue::assertNotPushed(ChannelSendResourceJob::class);
});

test('updated_dispatches_job_when_status_changes_to_processing', function () {
    Queue::fake();

    $order = Order::factory()->create([
        'status' => 'pending'
    ]);

    $order->status = 'processing';
    $order->save();

    $observer = new OrderObserver();
    $observer->updated($order);

    Queue::assertPushed(ChannelSendResourceJob::class);
});

test('updated_dispatches_job_when_status_changes_to_em_separacao', function () {
    Queue::fake();

    $order = Order::factory()->create([
        'status' => 'pending'
    ]);

    $order->status = 'em-separacao';
    $order->save();

    $observer = new OrderObserver();
    $observer->updated($order);

    Queue::assertPushed(ChannelSendResourceJob::class);
});

test('updated_does_not_dispatch_job_when_status_does_not_change', function () {
    Queue::fake();

    $order = Order::factory()->create([
        'status' => 'processing'
    ]);

    $order->status = 'processing'; // Same status
    $order->save();

    $observer = new OrderObserver();
    $observer->updated($order);

    Queue::assertNotPushed(ChannelSendResourceJob::class);
});

test('updated_does_not_dispatch_job_when_status_changes_to_inappropriate_value', function () {
    Queue::fake();

    $order = Order::factory()->create([
        'status' => 'processing'
    ]);

    $order->status = 'completed';
    $order->save();

    $observer = new OrderObserver();
    $observer->updated($order);

    Queue::assertNotPushed(ChannelSendResourceJob::class);
});

test('updated_does_not_dispatch_job_when_other_fields_change', function () {
    Queue::fake();

    $order = Order::factory()->create([
        'status' => 'processing'
    ]);

    $order->total = 150.00; // Change other field, not status
    $order->save();

    $observer = new OrderObserver();
    $observer->updated($order);

    Queue::assertNotPushed(ChannelSendResourceJob::class);
});
