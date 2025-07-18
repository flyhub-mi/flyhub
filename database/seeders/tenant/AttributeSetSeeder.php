<?php

namespace Database\Seeders\Tenant;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AttributeSetSeeder extends Seeder
{
    public function run()
    {
        DB::table('attribute_sets')->delete();
        DB::table('attribute_set_mappings')->delete();
        DB::statement("ALTER TABLE attribute_sets AUTO_INCREMENT = 1");
        DB::statement("ALTER TABLE attribute_set_mappings AUTO_INCREMENT = 1");

        $now = Carbon::now();

        DB::table('attribute_sets')->insert([
            ['created_at' => $now, 'updated_at' => $now, 'id' => '1', 'name' => 'Roupa'],
            ['created_at' => $now, 'updated_at' => $now, 'id' => '2', 'name' => 'Calçado'],
        ]);

        DB::table('attribute_set_mappings')->insert([
            ['attribute_id' => '1', 'attribute_set_id' => '1'],
            ['attribute_id' => '1', 'attribute_set_id' => '2'],
            ['attribute_id' => '2', 'attribute_set_id' => '1'],
            ['attribute_id' => '2', 'attribute_set_id' => '2'],
        ]);
    }
}
