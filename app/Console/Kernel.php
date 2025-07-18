<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * @var array
     */
    protected $commands = [];

    /**
     * @param Schedule $schedule
     */
    protected function schedule(Schedule $schedule)
    {
        // sync receive jobs
        $schedule->command('sync receive categories')->everySixHours();
        $schedule->command('sync receive orders')->everyFifteenMinutes();
        $schedule->command('sync receive products')->hourly();

        // sync send jobs
        $schedule->command('sync send categories')->everySixHours();
        $schedule->command('sync send products')->hourly();
        $schedule->command('sync send orders')->hourly();

        // sync log jobs
        $schedule->command('sync-logs clear')->dailyAt('05:00');
        $schedule->command('sync-logs mark-failed')->hourly();
    }

    /**
     * Load created commands
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
