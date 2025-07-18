<?php

namespace App\Integration\Channels\Medusa;

use App\Integration\ChannelConfig;
use Illuminate\Support\Collection;

class Config extends ChannelConfig
{
    /** @return Collection  */
    static function fields()
    {
        return collect([
            self::text('url', 'URL'),
            self::text('email', 'E-mail'),
            self::text('password', 'Senha'),
            self::select('products_sync', 'Sincronização de Produtos (ENVIO)', [
                'selected' => 'Somente selecionados',
                'all' => 'Todos',
            ]),
            self::checkbox('receive_products_stock', 'Receber estoque junto com os produtos.'),
        ]);
    }
}
