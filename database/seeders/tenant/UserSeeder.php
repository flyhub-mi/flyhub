<?php

namespace Database\Seeders\Tenant;

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run()
    {
        $user = \App\Models\User::create([
            'name' => 'Jean Carlos Farias',
            'email' => 'contato@jeancf.com.br',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('x123456x')
        ]);

        $user->assignRole('admin');
    }
}
