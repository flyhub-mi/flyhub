<?php

namespace App\Integration\Channels\WooCommerce\Mapping;

use function _\get;
use function _\find;
use function _\upperCase;

use App\Integration\Mapping\ResourceMapper;
use App\Integration\Mapping\Resource;
use App\Integration\Mapping\Column;

class ProductMapper extends ResourceMapper
{
    protected $attributes = [
        'color' => [
            'name' => 'COR',
            'slug' => 'pa_cor',
        ],
        'size' => [
            'name' => 'TAMANHO',
            'slug' => 'pa_tamanho',
        ],
    ];

    /**
     * @param \App\Models\Tenant\Channel $channel
     * @param array $configs
     */
    public function __construct($channel, $configs = null)
    {
        parent::__construct($channel, $configs, $this->buildMapping());
    }

    /**
     * @param array $remoteItem
     * @return array
     */
    public function toLocal($remoteItem)
    {
        $mapped = $this->mapData($remoteItem, 'local');
        $mapped = $this->mapAttributesToLocal($remoteItem, $mapped);

        if (get($this->configs, 'receive_products_stock') == false) {
            unset($mapped['stock_quantity']);
        }

        $mapped['variations'] = array_map(function ($mappedVariation) use ($remoteItem) {
            $remoteVariation = find(get($remoteItem, 'variations', []), ['sku' => $mappedVariation['sku']]);
            $mappedVariation = $this->mapAttributesToLocal($remoteVariation, $mappedVariation);

            if (get($this->configs, 'receive_products_stock') == false) {
                unset($mappedVariation['stock_quantity']);
            }

            return $mappedVariation;
        }, $mapped['variations']);

        return $mapped;
    }

    private function mapAttributesToLocal($remoteItem, $mapped)
    {
        if (in_array($remoteItem['type'], ['simple', 'variation'])) {
            $mapped['color'] = $this->mapAttributeToLocal('color', $remoteItem['attributes']);
            $mapped['size'] = $this->mapAttributeToLocal('size', $remoteItem['attributes']);
        }

        return $mapped;
    }

    /**
     * @param string $atributeName
     * @param array $attributes
     * @return string
     */
    private function mapAttributeToLocal($atributeName, $attributes)
    {
        foreach ($attributes as $attribute) {
            if (upperCase($attribute['name']) == upperCase($this->attributes[$atributeName]['name'])) {
                return get($attribute, 'option', '');
            }
        }

        return '';
    }

    /**
     * @param array $localItem
     * @param null|array $remoteAttributes
     * @return array
     */
    public function toRemote($localItem, $remoteAttributes = [])
    {
        $mapped = $this->mapData($localItem, 'remote');
        $mapped['status'] = in_array($mapped['status'], ['disabled', 'private']) ? 'private' : 'publish';
        $mapped['images'] = array_map(function ($img) {
            $name = array_pop(explode($img['src'], '/'));
            $src = 'https://s3.flyhub.com.br/' . $img['src'];

            return ['name' => $name, 'src' => $src];
        }, $mapped['images']);
        $mapped['variations'] = [];

        if (count($mapped['variations']) > 0) {
            $mapped['type'] = 'variable';
            $mapped['manage_stock'] = false;
            $mapped['variations'] = array_map(
                fn($variation) => array_merge($variation, [
                    'status' => in_array($variation['status'], ['disabled', 'private']) ? 'private' : 'publish',
                    'attributes' => $this->mapVariationsAttributesToRemote(
                        $variation['sku'],
                        $localItem['variations'],
                        $remoteAttributes,
                    ),
                ]),
                $mapped['variations'],
            );
        }

        $mapped['attributes'] = $this->mapProductAttributesToRemote(
            $localItem,
            $mapped['variations'],
            $remoteAttributes,
        );

        return $mapped;
    }

    /**
     * @param string $sku
     * @param array $localVariations
     * @param mixed $remoteAttributes
     * @return int[]|string[]
     */
    private function mapVariationsAttributesToRemote($sku, $localVariations, $remoteAttributes)
    {
        $localVariation = find($localVariations, ['sku' => $sku]);

        return array_map(function ($localKey) use ($localVariation, $remoteAttributes) {
            $name = $this->attributes[$localKey]['name'];
            $remoteId = $this->findRemoteAttributeId($name, $remoteAttributes);
            $option = get($localVariation, $localKey);

            return [
                'id' => $remoteId,
                'name' => $name,
                'option' => $option,
            ];
        }, array_keys($this->attributes));
    }

    /**
     * @param array $localItem
     * @param array $remoteAttributes
     * @return mixed
     */
    private function mapProductAttributesToRemote($localItem, $mappedVariations, $remoteAttributes)
    {
        return array_map(function ($localKey) use ($localItem, $mappedVariations, $remoteAttributes) {
            $name = $this->attributes[$localKey]['name'];
            $remoteId = $this->findRemoteAttributeId($name, $remoteAttributes);
            $options = [];

            if (count($mappedVariations) > 0) {
                $options[] = array_map(
                    fn($variation) => get(find($variation, ['id' => $remoteId]), 'option'),
                    $mappedVariations,
                );
            } else {
                $options[] = get($localItem, $localKey, null);
            }

            $hasMultipleOptions = count($options) > 1;

            return [
                'id' => $remoteId,
                'name' => $name,
                'visible' => $hasMultipleOptions,
                'variation' => $hasMultipleOptions,
                'options' => $options,
            ];
        }, array_keys($this->attributes));
    }

    /**
     * @param mixed $name
     * @param mixed $remoteAttributes
     * @return mixed
     */
    private function findRemoteAttributeId($name, $remoteAttributes)
    {
        foreach ($remoteAttributes as $rAttr) {
            if (strtolower($rAttr['name']) === strtolower($name)) {
                return $rAttr['id'];
            }
        }

        return null;
    }

    /** @return array  */
    public static function buildMapping()
    {
        $base = [
            Column::string('id', 'remote_id'),
            Column::string('sku', 'sku'),
            Column::string('name', 'name'),
            Column::string('description', 'description'),
            Column::string('regular_price', 'price', '0'),
            Column::integer('stock_quantity', 'stock_quantity'),
            Column::string('gross_weight', 'weight', '0.31'),
            Column::string('dimensions.width', 'width', '15'),
            Column::string('dimensions.height', 'height', '15'),
            Column::string('dimensions.depth', 'depth', '15'),
            Column::remote('manage_stock', true),
        ];

        return Resource::mapping(
            Resource::columns(
                Column::string('status', 'status', 'private'),
                Column::remote('type', 'simple'),
                ...$base,
            ),
            Resource::relations(
                Resource::mapping(
                    Resource::local('variations', true),
                    Resource::remote('variations', true),
                    Resource::columns(
                        Column::string('status', 'status', 'publish'),
                        Column::remote('type', 'variation'),
                        ...$base,
                    ),
                ),
                Resource::mapping(
                    Resource::local('images', true),
                    Resource::remote('images', true),
                    Resource::columns(
                        Column::string('name', 'name'),
                        Column::string('src', 'path')
                    ),
                ),
                Resource::mapping(
                    Resource::local('categories', true),
                    Resource::remote('categories', true),
                    Resource::columns(
                        Column::string('id', 'remote_id'),
                        Column::string('name', 'name'),
                    ),
                ),
            ),
        );
    }
}
