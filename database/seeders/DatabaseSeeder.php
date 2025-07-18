<?php

namespace Database\Seeders;

use Database\Seeders\PermissionSeeder;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        $this->call(PermissionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(TenantSeeder::class);

        Schema::enableForeignKeyConstraints();
    }
}
