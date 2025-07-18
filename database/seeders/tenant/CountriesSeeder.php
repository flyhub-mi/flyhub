<?php

namespace Database\Seeders\Tenant;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CountriesSeeder extends Seeder
{
    public function run()
    {
        DB::table('countries')->delete();
        DB::statement("ALTER TABLE countries AUTO_INCREMENT = 1");

        $countries = json_decode(file_get_contents(__DIR__ . '/data/countries.json'), true);

        DB::table('countries')->insert($countries);
    }
}
