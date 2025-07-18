<?php

namespace App\Integration\Channels\Correios;

use Illuminate\Support\Collection;
use App\Integration\ChannelConfig;

class Config extends ChannelConfig
{
    /** @return Collection  */
    static function fields()
    {
        return collect([
            self::text('login', 'Usuário do WebService'),
            self::text('password', 'Senha do WebService'),
        ]);
    }
}
