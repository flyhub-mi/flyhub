<?php

namespace App\Console\Commands;

use App\Jobs\Tenant\SyncChannelsJob;
use Illuminate\Console\Command;

class Sync extends Command
{
    protected $signature = 'sync {type=receive} {resource=all}';
    protected $description = 'Syncronize Integrations with Third Party - Params: type=(send|receive), resource=(all|products|orders|categories)';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        SyncChannelsJob::dispatch($this->argument('type'), $this->argument('resource'));
    }
}
