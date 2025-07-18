<?php

namespace App\Integration\Channels\Magento2;

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
                'name' => 'access_token',
                'label' => 'Token de Acesso',
                'type' => 'text',
            ],
        ]);
    }
}
