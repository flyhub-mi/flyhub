<?php

namespace App\Integration\Channels\Sisplan;

use App\Integration\ChannelConfig;
use Illuminate\Support\Collection;

class Config extends ChannelConfig
{
    /** @return Collection  */
    static function fields()
    {
        return collect([
            self::text('url', 'URL'),
            self::text('username', 'Usuário'),
            self::password('password', 'Senha'),
            self::text('deposito', 'Depósito'),
            self::text('tabpreco', 'Tabela de Preço'),
            self::text('codrep', 'Código do Representante'),
        ]);
    }
}
