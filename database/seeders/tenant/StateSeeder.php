<?php

namespace Database\Seeders\Tenant;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    public function run()
    {
        DB::table('states')->delete();
        DB::statement("ALTER TABLE states AUTO_INCREMENT = 1");

        $states = json_decode(file_get_contents(resource_path('data/states.json')), true);

        DB::table('states')->insert($states);
    }
}
