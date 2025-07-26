<?php

use App\Integration\Channels\WooCommerce\Products;
use App\Models\Tenant\Channel;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class);

test('can send products', function () {
    $response = $this->subject->send($this->sourceProducts);
    $spy = $this->spy(\Automattic\WooCommerce\Client::class);
    $spy->shouldReceive('get');
    }
