<?php

use App\Models\Tenant\ChannelSyncResult;
use App\Observers\ChannelSyncResultObserver;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(Tests\TestCase::class, DatabaseTransactions::class);

test('updated_sets_status_to_complete_when_processed_equals_total', function () {
    $syncResult = \Mockery::mock(ChannelSyncResult::class);
    $syncResult->shouldReceive('wasChanged')->with('processed')->andReturn(true);
    $syncResult->shouldReceive('getAttribute')->with('processed')->andReturn(10);
    $syncResult->shouldReceive('getAttribute')->with('total')->andReturn(10);
    $syncResult->shouldReceive('update')->with(['status' => 'complete'])->once();

    $observer = new ChannelSyncResultObserver();
    $observer->updated($syncResult);
});

test('updated_sets_status_to_complete_when_processed_exceeds_total', function () {
    $syncResult = \Mockery::mock(ChannelSyncResult::class);
    $syncResult->shouldReceive('wasChanged')->with('processed')->andReturn(true);
    $syncResult->shouldReceive('getAttribute')->with('processed')->andReturn(15);
    $syncResult->shouldReceive('getAttribute')->with('total')->andReturn(10);
    $syncResult->shouldReceive('update')->with(['status' => 'complete'])->once();

    $observer = new ChannelSyncResultObserver();
    $observer->updated($syncResult);
});

test('updated_does_not_change_status_when_processed_less_than_total', function () {
    $syncResult = \Mockery::mock(ChannelSyncResult::class);
    $syncResult->shouldReceive('wasChanged')->with('processed')->andReturn(true);
    $syncResult->shouldReceive('getAttribute')->with('processed')->andReturn(7);
    $syncResult->shouldReceive('getAttribute')->with('total')->andReturn(10);
    $syncResult->shouldReceive('update')->never();

    $observer = new ChannelSyncResultObserver();
    $observer->updated($syncResult);
});

test('updated_does_not_change_status_when_processed_was_not_changed', function () {
    $syncResult = \Mockery::mock(ChannelSyncResult::class);
    $syncResult->shouldReceive('wasChanged')->with('processed')->andReturn(false);
    $syncResult->shouldReceive('update')->never();

    $observer = new ChannelSyncResultObserver();
    $observer->updated($syncResult);
});
