
<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

/** @package Tests */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, ApiTestTrait;

    protected function setUp(): void
    {
        parent::setUp();

        // Ensure we're using the testing database connection
        $this->app['config']->set('database.default', 'testing');

        $this->runMigrations();

        // Ensure tenancy is properly configured for testing
        $this->configureTenancyForTesting();
    }

    protected function runMigrations(): void
    {
        // Run main migrations
        Artisan::call('migrate', ['--database' => 'testing']);

        // Run tenant migrations
        Artisan::call('migrate', [
            '--database' => 'testing',
            '--path' => 'database/migrations/tenant'
        ]);
    }

    protected function decodeJsonFile(string $path)
    {
        return json_decode(file_get_contents($path), true);
    }

    protected function migrationsHaveRun(): bool
    {
        try {
            // Check if the migrations table exists and has records
            return \Schema::hasTable('migrations') && \DB::table('migrations')->count() > 0;
        } catch (\Exception $e) {
            return false;
        }
    }

    protected function configureTenancyForTesting(): void
    {
        // Ensure tenancy system is properly configured for testing
        $this->app['config']->set('tenancy.database.central_connection', 'testing');

        // Disable automatic tenant database creation in tests to avoid conflicts
        $this->app['config']->set('tenancy.database.auto_create', false);
        $this->app['config']->set('tenancy.database.auto_update_schema', false);
    }
}
