<?php

use Illuminate\Support\Facades\Http;

uses(Tests\TestCase::class);

test('basic test example', function () {
    Http::fake();

    Http::withHeaders([
        'X-First' => 'foo',
    ])->post('http://test.com/users', [
        'name' => 'Taylor',
        'role' => 'Developer',
    ]);

    Http::assertSent(function ($request) {
        return $request->hasHeader('X-First', 'foo') &&
            $request->url() == 'http://test.com/users' &&
            $request['name'] == 'Taylor' &&
            $request['role'] == 'Developer';
    });
});
