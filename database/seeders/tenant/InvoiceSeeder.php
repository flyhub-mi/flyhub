<?php

namespace Database\Seeders\Tenant;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    public function run()
    {
        DB::table('invoices')->delete();
        DB::statement("ALTER TABLE invoices AUTO_INCREMENT = 1");

        $now = Carbon::now();

        DB::table('invoices')->insert([
            [
                'id' => '1',
                'status' => '',
                'channel_name	' => 'MercadoLivre',
                'is_guest' => '',
                'customer_email' => 'jose@sauro.com.br',
                'customer_name' => 'José Sauro',
                'shipping_method' => 'sedex',
                'shipping_description' => '',
                'coupon_code' => '',
                'is_gift' => false,
                'total_item_count' => '1',
                'total_qty_ordered' => '1',
                'grand_total' => '1699.00',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);
    }
}
