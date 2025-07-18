<?php

namespace App\Integration\Channels\Magento;

use App\Integration\ChannelConfig;
use Illuminate\Support\Collection;

class Config extends ChannelConfig
{
    /** @return Collection  */
    static function fields()
    {
        return collect([
            [
                'name' => 'url',
                'label' => 'URL',
                'type' => 'text',
            ],
            [
                'name' => 'api_user',
                'label' => 'Usuário da API',
                'type' => 'text',
            ],
            [
                'name' => 'api_key',
                'label' => 'Chave da API',
                'type' => 'text',
            ],
            [
                'name' => 'compatible_adsomos',
                'label' => 'Formato de pedido compatível com ERP Adsomos',
                'type' => 'checkbox',
            ],
        ]);
    }
}
