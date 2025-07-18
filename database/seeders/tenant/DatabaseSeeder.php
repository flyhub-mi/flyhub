<?php

namespace Database\Seeders\Tenant;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        $this->call(StateSeeder::class);
        $this->call(CitySeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(AttributeSeeder::class);
        $this->call(AttributeOptionSeeder::class);
        $this->call(AttributeSetSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(InventorySeeder::class);
        $this->call(ChannelSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(OrderSeeder::class);
        $this->call(AddressesSeeder::class);

        Schema::enableForeignKeyConstraints();
    }
}
