<?php

namespace App\Integration\Channels\MercadoLivre;

use App\Integration\ChannelConfig;
use Illuminate\Support\Collection;

class Config extends ChannelConfig
{
    /** @return Collection  */
    static function fields()
    {
        return collect([
            [
                'name' => 'buying_mode',
                'label' => 'Modo de compra',
                'type' => 'select',
                'options' => [
                    'buy_it_now' => 'Compre agora',
                    'classified' => 'Classificado',
                ],
            ],
            [
                'name' => 'listing_type',
                'label' => 'Tipo de anúncio',
                'type' => 'select',
                'options' => [
                    'free' => 'Grátis',
                    'bronze' => 'Bronze',
                    'silver' => 'Prata',
                    'gold' => 'Ouro',
                    'gold_special' => 'Clássico',
                    'gold_premium' => 'Diamante',
                    'gold_pro' => 'Premium',
                ],
            ],
            [
                'name' => 'code',
                'label' => 'Código',
                'type' => 'text',
                'disabled' => true,
            ],
            [
                'name' => 'token',
                'label' => 'Token',
                'type' => 'text',
                'disabled' => true,
            ],
        ]);
    }
}
