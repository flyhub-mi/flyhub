<?php

namespace Database\Seeders\Tenant;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CategorySeeder extends Seeder
{
    public function run()
    {
        DB::table('categories')->delete();
        DB::statement("ALTER TABLE categories AUTO_INCREMENT = 1");

        $now = Carbon::now();

        DB::table('categories')->insert([
            //tenant 1
            [
                'id' => '1', 'name' => 'Raiz', 'status' => '1', '_lft' => '1',
                '_rgt' => '14', 'parent_id' => NULL, 'created_at' => $now, 'updated_at' => $now
            ],
            [
                'id' => '2', 'name' => 'Roupas', 'status' => '1', '_lft' => '1',
                '_rgt' => '14', 'parent_id' => '1', 'created_at' => $now, 'updated_at' => $now
            ],
            [
                'id' => '3', 'name' => 'Infantil', 'status' => '1', '_lft' => '1',
                '_rgt' => '14', 'parent_id' => '2', 'created_at' => $now, 'updated_at' => $now
            ],
            [
                'id' => '4', 'name' => 'Feminino', 'status' => '1', '_lft' => '1',
                '_rgt' => '14', 'parent_id' => '3', 'created_at' => $now, 'updated_at' => $now
            ],
            [
                'id' => '5', 'name' => 'Masculino', 'status' => '1', '_lft' => '1',
                '_rgt' => '14', 'parent_id' => '3', 'created_at' => $now, 'updated_at' => $now
            ],
            [
                'id' => '6', 'name' => 'Adulto', 'status' => '1', '_lft' => '1',
                '_rgt' => '14', 'parent_id' => '2', 'created_at' => $now, 'updated_at' => $now
            ],
            [
                'id' => '7', 'name' => 'Feminino', 'status' => '1', '_lft' => '1',
                '_rgt' => '14', 'parent_id' => '6', 'created_at' => $now, 'updated_at' => $now
            ],
            [
                'id' => '8', 'name' => 'Masculino', 'status' => '1', '_lft' => '1',
                '_rgt' => '14', 'parent_id' => '6', 'created_at' => $now, 'updated_at' => $now
            ],
            //tenant 2
            [
                'id' => '9', 'name' => 'Raiz', 'status' => '1', '_lft' => '1',
                '_rgt' => '14', 'parent_id' => NULL, 'created_at' => $now, 'updated_at' => $now
            ],
            [
                'id' => '10', 'name' => 'Calçados', 'status' => '1', '_lft' => '1',
                '_rgt' => '14', 'parent_id' => '9', 'created_at' => $now, 'updated_at' => $now
            ],
            [
                'id' => '11', 'name' => 'Infantil', 'status' => '1', '_lft' => '1',
                '_rgt' => '14', 'parent_id' => '10', 'created_at' => $now, 'updated_at' => $now
            ],
            [
                'id' => '12', 'name' => 'Feminino', 'status' => '1', '_lft' => '1',
                '_rgt' => '14', 'parent_id' => '11', 'created_at' => $now, 'updated_at' => $now
            ],
            [
                'id' => '13', 'name' => 'Masculino', 'status' => '1', '_lft' => '1',
                '_rgt' => '14', 'parent_id' => '12', 'created_at' => $now, 'updated_at' => $now
            ],
            [
                'id' => '14', 'name' => 'Adulto', 'status' => '1', '_lft' => '1',
                '_rgt' => '14', 'parent_id' => '12', 'created_at' => $now, 'updated_at' => $now
            ],
            [
                'id' => '15', 'name' => 'Feminino', 'status' => '1', '_lft' => '1',
                '_rgt' => '14', 'parent_id' => '11', 'created_at' => $now, 'updated_at' => $now
            ],
            [
                'id' => '16', 'name' => 'Masculino', 'status' => '1', '_lft' => '1',
                '_rgt' => '14', 'parent_id' => '11', 'created_at' => $now, 'updated_at' => $now
            ]
        ]);
    }
}
