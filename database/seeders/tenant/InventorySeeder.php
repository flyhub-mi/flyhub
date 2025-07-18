<?php

namespace Database\Seeders\Tenant;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class InventorySeeder extends Seeder
{
    public function run()
    {
        DB::table('inventory_sources')->delete();
        DB::statement("ALTER TABLE inventory_sources AUTO_INCREMENT = 1");

        $now = Carbon::now();

        DB::table('inventory_sources')->insert([
            [
                'id' => 1,
                'name' => 'Default',
                'contact_name' => 'Odirlon Herart',
                'contact_email' => 'warehouse@flyhub.com.br',
                'contact_number' => 1234567899,
                'status' => 1,
                'country' => 'BR',
                'state' => 'SC',
                'street' => 'Genesio Jeronimo Sestrem',
                'number' => '132',
                'city' => 'São João Batista',
                'postcode' => '88240000',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 2,
                'name' => 'Default',
                'contact_name' => 'Odirlon Herart',
                'contact_email' => 'not-me@flyhub.com.br',
                'contact_number' => 1234567899,
                'status' => 1,
                'country' => 'BR',
                'state' => 'SC',
                'street' => 'Av. Germano Furbringer, 950, Sala 4, Jardim Maluche',
                'number' => '132',
                'city' => 'Brusque',
                'postcode' => '88354600',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);
    }
}
