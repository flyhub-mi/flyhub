<?php

namespace Database\Seeders\Tenant;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AddressesSeeder extends Seeder
{
    public function run()
    {
        DB::table('addresses')->delete();
        DB::statement("ALTER TABLE addresses AUTO_INCREMENT = 1");

        $now = Carbon::now();

        DB::table('addresses')->insert([
            [
                'id' => '1',
                'customer_id' => 1,
                'street' => 'Rua X',
                'number' => '15',
                'country' => 'BR',
                'state' => 'SC',
                'city' => 'Sao Joao Batista',
                'postcode' => 'true',
                'phone' => '4899855774433',
                'name' => 'Casa',
                'address_type' => 'shipping',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);

        DB::table('addresses')->insert([
            [
                'id' => '2',
                'order_id' => '1',
                'customer_id' => '1',
                'address_type' => 'shipping',
                'name' => 'José Sauro',
                'email' => 'jose@sauro.com.br',
                'phone' => '4899855774433',
                'street' => 'Rua X',
                'number' => '15',
                'country' => 'BR',
                'postcode' => '88240-000',
                'state' => 'SC',
                'city' => 'Sao Joao Batista',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);
    }
}
