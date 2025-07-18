<?php

namespace Database\Seeders\Tenant;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AttributeSeeder extends Seeder
{
    public function run()
    {
        DB::table('attributes')->delete();
        DB::statement("ALTER TABLE attributes AUTO_INCREMENT = 1");

        $now = Carbon::now();
        $common_atributes = ['input_type' => 'text', 'created_at' => $now, 'updated_at' => $now];

        DB::table('attributes')->insert([
            array_merge($common_atributes, ['id' => '1', 'code' => 'size', 'name' => 'Tamanho Calçado']),
            array_merge($common_atributes, ['id' => '2', 'code' => 'size', 'name' => 'Tamanho Roupa']),
        ]);
    }
}
