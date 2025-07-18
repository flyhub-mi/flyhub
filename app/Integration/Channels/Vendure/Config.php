<?php

namespace App\Integration\Channels\Vendure;

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
                'name' => 'username',
                'label' => 'username',
                'type' => 'text',
            ],
            [
                'name' => 'password',
                'label' => 'password',
                'type' => 'text',
            ],
        ]);
    }
}
