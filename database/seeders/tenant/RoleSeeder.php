<?php

namespace Database\Seeders\Tenant;

use Spatie\Permission\PermissionRegistrar as PermissionRegistrarAlias;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        DB::table('roles')->delete();
        DB::table('role_has_permissions')->delete();
        DB::statement("ALTER TABLE roles AUTO_INCREMENT = 1");
        DB::statement("ALTER TABLE role_has_permissions AUTO_INCREMENT = 1");

        app()[PermissionRegistrarAlias::class]->forgetCachedPermissions();

        $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->givePermissionTo(Permission::all());

        $userRole = Role::create(['name' => 'user', 'guard_name' => 'web']);
        $userRole->givePermissionTo(Permission::where('name', 'NOT LIKE ', 'tenant-%')->get());
    }
}
