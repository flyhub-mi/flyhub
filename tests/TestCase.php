<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

/** @package Tests */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations;

    protected function decodeJsonFile(string $path)
    {
        return json_decode(file_get_contents($path), true);
    }
}
