<?php

namespace App\Integration\Channels\WooCommerce\Mapping;

use App\Integration\Mapping\ResourceMapper;
use function _\get;

class AttributeMapper extends ResourceMapper
{
    /**
     * @param \App\Models\Tenant\Channel $channel
     * @param array $configs
     */
    public function __construct($channel, $configs = null)
    {
        parent::__construct($channel, $configs, $this->buildMapping());
    }

    /**
     * @param array $localData
     * @param array $remoteAttributes
     * @return array
     */
    public function toRemote($localData)
    {
        return array_map(function ($localKey) use ($localData) {
            $attribute = $this->mapping[$localKey];

            $terms = [];
            if ($localData['type'] == 'variable') {
                $terms = $this->mapAttributeTermsToRemote($localKey, $localData['variations']);
            } else {
                $term = get($localData, $localKey);

                if (!is_null($term)) {
                    $terms[] = ['name' => get($localData, $localKey)];
                }
            }

            return array_merge($attribute, ['terms' => $terms]);
        }, array_keys($this->mapping));
    }

    /**
     * @param array $localVariations
     * @param string $sku
     * @return array
     */
    private function mapAttributeTermsToRemote($localKey, $localVariations)
    {
        $terms = array_map(fn ($localVariation) => get($localVariation, $localKey), $localVariations);
        $terms = array_unique($terms);

        return array_map(fn ($term) => ['name' => $term], $terms);
    }

    /** @return array  */
    public static function buildMapping()
    {
        return [
            'color' => [
                'name' => 'COR',
                'slug' => 'pa_cor',
                'type' => 'select',
                'order_by' => 'name',
            ],
            'size' => [
                'name' => 'TAMANHO',
                'slug' => 'pa_tamanho',
                'type' => 'select',
                'order_by' => 'name',
            ]
        ];
    }
}
