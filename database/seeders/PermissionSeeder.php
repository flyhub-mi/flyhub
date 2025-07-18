<?php

namespace Database\Seeders;

use Spatie\Permission\PermissionRegistrar as PermissionRegistrarAlias;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

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

        app()[PermissionRegistrarAlias::class]->forgetCachedPermissions();

        $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->givePermissionTo(Permission::all());

        $userRole = Role::create(['name' => 'user', 'guard_name' => 'web']);
        $userRole->givePermissionTo(Permission::where('name', 'NOT LIKE ', 'tenant-%')->get());

        app()[PermissionRegistrarAlias::class]->forgetCachedPermissions();
    }
}
