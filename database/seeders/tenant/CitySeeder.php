<?php

namespace Database\Seeders\Tenant;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    public function run()
    {
        DB::table('cities')->delete();
        DB::statement("ALTER TABLE cities AUTO_INCREMENT = 1");

        $cities = json_decode(file_get_contents(resource_path('data/cities.json')), true);

        DB::table('cities')->insert($cities);
    }
}
