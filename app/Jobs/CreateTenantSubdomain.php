<?php

namespace App\Jobs;

use Http;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Stancl\Tenancy\Contracts\TenantWithDatabase;

class CreateTenantSubdomain implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var TenantWithDatabase */
    protected $tenant;

    public function __construct(TenantWithDatabase $tenant)
    {
        $this->tenant = $tenant;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $apiToken = env('CLOUDFLARE_TOKEN');
        $zoneId = env('CLOUDFLARE_ZONE_ID');

        Http::withToken($apiToken)
            ->post('https://api.cloudflare.com/client/v4/zones/' . $zoneId . '/dns_records', [
                "type" => "A",
                "name" =>  $this->tenant->getTenantKey() . '.flyhub.com.br',
                "content" => "54.88.38.41",
                "ttl" => 3600,
                "priority" => 10,
                "proxied" => true
            ]);
    }
}
