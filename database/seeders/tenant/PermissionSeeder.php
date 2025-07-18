<?php

namespace Database\Seeders\Tenant;

use Spatie\Permission\PermissionRegistrar as PermissionRegistrarAlias;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        DB::table('permissions')->delete();
        DB::table('role_has_permissions')->delete();
        DB::statement("ALTER TABLE permissions AUTO_INCREMENT = 1");
        DB::statement("ALTER TABLE role_has_permissions AUTO_INCREMENT = 1");

        app()[PermissionRegistrarAlias::class]->forgetCachedPermissions();

        $permissions = [
            "attribute", "attribute-set", "category", "channel", "config", "customer",
            "integration", "inventory-source", "invoice", "order", "product", "refund",
            "role", "shipment", "subscriber", "tax", "tax-group", "tokens", "tenant", "user"
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => "{$permission}-list"]);
            Permission::create(['name' => "{$permission}-create"]);
            Permission::create(['name' => "{$permission}-edit"]);
            Permission::create(['name' => "{$permission}-delete"]);
        }
    }
}
