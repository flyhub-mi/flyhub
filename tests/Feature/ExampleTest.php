<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
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
    }
}
