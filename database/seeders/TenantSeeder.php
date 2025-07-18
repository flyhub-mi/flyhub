<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    public function run()
    {
        $now = \Carbon\Carbon::now();

        $tenant1 = \App\Models\Tenant::create([
            'id' => 'demo-store',
            'data' => [
                'name' => 'Demo Store',
                'company' => 'Demo E-commerce Store LTDA',
                'logo' => 'https://via.placeholder.com/200x80/4F46E5/FFFFFF?text=Demo+Store',
                'email' => 'contact@demo-store.com',
                'phone' => '(11) 9999-8888',
            ],
            'created_at' => $now,
            'updated_at' => $now
        ]);
        $tenant1->domains()->create(['domain' => 'demo-store.localhost']);
        $tenant1->addresses()->create([
            'id' => '1',
            'tenant_id' => 'demo-store',
            'street' => 'Rua das Flores',
            'number' => '123',
            'country' => 'BR',
            'state' => 'SP',
            'city' => 'São Paulo',
            'postcode' => '01234-567',
            'phone' => '(31) 7777-6666',
            'created_at' => $now,
            'updated_at' => $now
        ]);

        $tenant2 = \App\Models\Tenant::create([
            'id' => 'test-shop',
            'data' => [
                'name' => 'Test Shop',
                'company' => 'Test Shop Comércio Eletrônico LTDA',
                'logo' => 'https://via.placeholder.com/200x80/10B981/FFFFFF?text=Test+Shop',
                'email' => 'info@test-shop.com',
                'phone' => '(21) 8888-7777',
            ],
            'created_at' => $now,
            'updated_at' => $now
        ]);
        $tenant2->domains()->create(['domain' => 'test-shop.localhost']);
        $tenant2->addresses()->create([
            'id' => '2',
            'tenant_id' => 'test-shop',
            'street' => 'Avenida Atlântica',
            'number' => '456',
            'country' => 'BR',
            'state' => 'RJ',
            'city' => 'Rio de Janeiro',
            'postcode' => '22070-001',
            'phone' => '(21) 8888-7777',
            'created_at' => $now,
            'updated_at' => $now
        ]);

        $tenant3 = \App\Models\Tenant::create([
            'id' => 'sample-mart',
            'data' => [
                'name' => 'Sample Mart',
                'company' => 'Sample Mart Distribuidora LTDA',
                'logo' => 'https://via.placeholder.com/200x80/F59E0B/FFFFFF?text=Sample+Mart',
                'email' => 'sales@sample-mart.com',
                'phone' => '(31) 7777-6666',
            ],
            'created_at' => $now,
            'updated_at' => $now
        ]);
        $tenant3->domains()->create(['domain' => 'sample-mart.localhost']);
        $tenant3->addresses()->create([
            'id' => '3',
            'tenant_id' => 'sample-mart',
            'street' => 'Rua da Liberdade',
            'number' => '789',
            'country' => 'BR',
            'state' => 'MG',
            'city' => 'Belo Horizonte',
            'postcode' => '30112-000',
            'phone' => '(31) 7777-6666',
            'created_at' => $now,
            'updated_at' => $now
        ]);
    }
}
