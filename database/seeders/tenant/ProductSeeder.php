<?php

namespace Database\Seeders\Tenant;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProductSeeder extends Seeder
{
    public function run()
    {
        DB::table('products')->delete();
        DB::statement("ALTER TABLE products AUTO_INCREMENT = 1");

        $now = Carbon::now();

        DB::table('products')->insert([
            [
                'id' => '1',
                'attribute_set_id' => '1',
                'sku' => 'CUH-2000',
                'name' => 'PlayStation 4',
                'description' => 'Graças à sua interconectividade global, você baixará os melhores jogos de vídeo e navegará na web sem limites. Por sua vez, a possibilidade de competir online com outras pessoas fará que você desfrute de aventuras inesquecíveis com amigos e pessoas de todo o mundo.',
                'new' => true,
                'thumbnail' => 'https://www.infostore.com.br/media/catalog/product/cache/e4d64343b1bc593f1c5348fe05efa4a6/p/l/playstation_4_slim_1tb_only_on_playstation_01_1.jpg',
                'price' => '1699.00',
                'cost' => '1200.00',
                'net_weight' => '2.1',
                'size' => 'UN',
                'color' => 'Jet Black',
                'short_description' => '',
                'width' => '265',
                'height' => '39',
                'depth' => '288',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);
    }
}
