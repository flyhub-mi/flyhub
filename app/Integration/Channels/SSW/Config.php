<?php

namespace App\Integration\Channels\SSW;

use Illuminate\Support\Collection;
use App\Integration\ChannelConfig;

class Config extends ChannelConfig
{
    /** @return Collection  */
    static function fields()
    {
        return collect([
            self::text('dominio', 'Domínio de login do WebService'),
            self::text('login', 'Usuário do WebService'),
            self::text('senha', 'Senha do WebService'),
        ]);
    }
}
