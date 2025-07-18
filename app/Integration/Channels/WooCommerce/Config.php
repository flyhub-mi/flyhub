<?php

namespace App\Integration\Channels\WooCommerce;

use App\Integration\ChannelConfig;
use Illuminate\Support\Collection;

class Config extends ChannelConfig
{
    /** @return Collection  */
    static function fields()
    {
        return collect([
            self::text('url', 'URL'),
            self::text('consumer_key', 'Chave do consumidor (Consumer Key)'),
            self::text('consumer_secret', 'Segredo do consumidor (Consumer Secret)'),
            self::select('products_sync', 'Sincronização de Produtos (ENVIO)', [
                'selected' => 'Somente selecionados',
                'all' => 'Todos',
            ]),
            self::checkbox('create_customer', 'Criar cadastro de comprador junto com o pedido.'),
            self::checkbox('receive_products_stock', 'Receber estoque junto com os produtos.'),
        ]);
    }
}
