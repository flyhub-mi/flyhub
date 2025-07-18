<?php

namespace App\Integration\Channels\Sisplan\Resources;

class Attributes
{
    public function getAll()
    {
        return collect([
            [
                'id' => 'color_code',
                'name' => 'Código da Cor',
                'type' => 'string',
                'required' => true,
                'readOnly' => true,
                'multiple' => false,
                'allowVariations' => true,
                'variationAttribute' => true,
                'values' => [],
            ],
        ]);
    }
}
