<?php

namespace Database\Seeders\Tenant;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Tenant\Customer;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        DB::table('addresses')->delete();
        DB::table('customers')->delete();
        DB::statement("ALTER TABLE addresses AUTO_INCREMENT = 1");
        DB::statement("ALTER TABLE customers AUTO_INCREMENT = 1");

        $now = Carbon::now();

        DB::table('customers')->insert([
            [
                'channel_id' => 1,
                'name' => 'José Sauro',
                'gender' => 'Masculino',
                'birthdate' => '2001-01-01',
                'email' => 'jose@sauro.com.br',
                'phone' => '4899855774433',
                'notes' => 'Note',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);

        DB::table('addresses')->insert([
            [
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
    }
}
