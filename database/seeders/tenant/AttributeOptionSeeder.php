<?php

namespace Database\Seeders\Tenant;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class AttributeOptionSeeder extends Seeder
{
    public function run()
    {
        DB::table('attribute_options')->delete();
        DB::statement("ALTER TABLE attribute_options AUTO_INCREMENT = 1");

        $clothes = [
            ['id' => '1', 'name' => 'PP', 'sort_order' => '1', 'attribute_id' => '1'],
            ['id' => '2', 'name' => 'P', 'sort_order' => '2', 'attribute_id' => '1'],
            ['id' => '3', 'name' => 'M', 'sort_order' => '3', 'attribute_id' => '1'],
            ['id' => '4', 'name' => 'G', 'sort_order' => '4', 'attribute_id' => '1'],
            ['id' => '5', 'name' => 'GG', 'sort_order' => '5', 'attribute_id' => '1'],
            ['id' => '6', 'name' => 'EGG', 'sort_order' => '6', 'attribute_id' => '1']
        ];

        $shoes = [];
        for ($i = 0; $i < 33; $i++) {
            $shoes[] = ['id' => $i + 13, 'name' => $i + 13, 'sort_order' => $i + 1, 'attribute_id' => '2'];
        }

        DB::table('attribute_options')->insert(array_merge($clothes, $shoes));
    }
}
