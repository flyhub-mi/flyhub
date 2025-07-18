<?php

namespace App\Integration\Channels\Bling;

use Illuminate\Support\Collection;
use App\Integration\ChannelConfig;

class Config extends ChannelConfig
{
    /** @return Collection  */
    static function fields()
    {
        return collect([
            self::text('apiKey', 'Chave API'),
        ]);
    }
}
