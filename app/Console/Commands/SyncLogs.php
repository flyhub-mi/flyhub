<?php

namespace App\Console\Commands;

use App\Jobs\Tenant\MaintenceJob;
use Illuminate\Console\Command;

class SyncLogs extends Command
{
    protected $signature = 'sync-logs {task=clear}';
    protected $description = <<<STR
        Task (clear): Clear logs older than 5 days, and set as complete jobs not finished older than 5 hours\n
        Task (mark-failed): Set as failed jobs not updated more than 3 hours ago\n
    STR;

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        MaintenceJob::dispatch($this->argument('task'));
    }
}
