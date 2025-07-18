<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        $admin = \App\Models\User::create([
            'name' => 'Admin User',
            'email' => 'admin@demo.com',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('password123')
        ]);
        $admin->assignRole('admin');

        // Create manager user
        $manager = \App\Models\User::create([
            'name' => 'Manager User',
            'email' => 'manager@demo.com',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('password123')
        ]);
        $manager->assignRole('manager');

        // Create regular user
        $user = \App\Models\User::create([
            'name' => 'Demo User',
            'email' => 'user@demo.com',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('password123')
        ]);
        $user->assignRole('user');

        // Create support user
        $support = \App\Models\User::create([
            'name' => 'Support User',
            'email' => 'support@demo.com',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('password123')
        ]);
        $support->assignRole('support');
    }
}
