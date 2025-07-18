<?php

namespace Database\Seeders\Tenant;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run()
    {
        DB::table('orders')->delete();
        DB::table('order_items')->delete();
        DB::table('order_payment')->delete();
        DB::statement("ALTER TABLE orders AUTO_INCREMENT = 1");
        DB::statement("ALTER TABLE order_items AUTO_INCREMENT = 1");
        DB::statement("ALTER TABLE order_payment AUTO_INCREMENT = 1");

        $now = Carbon::now();

        DB::table('orders')->insert([
            [
                'id' => '1',
                'channel_id' => '1',
                'customer_id' => '1',
                'customer_email' => 'jose@sauro.com.br',
                'customer_name' => 'José Sauro',
                'shipping_method' => 'sedex',
                'total_item_count' => '1',
                'total_qty_ordered' => '1',
                'grand_total' => '1699.00',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);

        DB::table('order_items')->insert([
            [
                'id' => '1',
                'order_id' => '1',
                'product_id' => '1',
                'qty_ordered' => '1',
                'sku' => 'CUH-2000',
                'name' => 'PlayStation 4',
                'price' => '1699.00',
                'total' => '1699.00',
                'total_invoiced' => '1699.00',
                'amount_refunded' => '0.00',
            ]
        ]);

        DB::table('order_payment')->insert([
            [
                'id' => '1',
                'order_id' => '1',
                'method' => 'Cartão'
            ]
        ]);
    }
}
