<?php

namespace Database\Seeders\Tenant;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ChannelSeeder extends Seeder
{
    public function run()
    {
        DB::table('channels')->delete();
        DB::table('channel_inventory_sources')->delete();
        DB::statement("ALTER TABLE channels AUTO_INCREMENT = 1");
        DB::statement("ALTER TABLE channel_inventory_sources AUTO_INCREMENT = 1");

        $now = Carbon::now();

        DB::table('channels')->insert([
            [
                'id' => 1,
                'code' => 'WooCommerce',
                'name' => 'WooCommerce',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);

        DB::table('channel_inventory_sources')->insert([
            'channel_id' => 1,
            'inventory_source_id' => 1,
        ]);
    }
}
