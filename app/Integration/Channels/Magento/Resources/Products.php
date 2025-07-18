<?php

namespace App\Integration\Channels\Magento\Resources;

use App\Integration\ChannelResource;
use App\Integration\Channels\Magento\Api;
use App\Integration\Channels\Magento\Mapping\ProductMapper;
use function _\find;
use function _\get;
use function _\map;

class Products extends ChannelResource
{
    protected $api;
    protected $mapper;

    /**
     * @param \App\Models\Tenant\Channel $channel
     */
    public function __construct($channel)
    {
        parent::__construct($channel, 'products');

        $this->api = new Api($this->configs);
        $this->mapper = new ProductMapper($this->channel, $this->configs);
    }

    /**
     * @param array|object $data
     * @return array
     * @throws \Exception
     */
    public function moreInfo($localData)
    {
        $attributes = new \stdClass();
        $attributes->additional_attributes = array_map(
            fn ($item) => $item['slug'],
            $this->mapping['meta']['attributes'],
        );
        $remoteData = $this->api->getProductInfo($localData['remote_id'], $attributes);

        return array_merge($this->mapProduct($localData['remote_id'], $remoteData), [
            'variations' => $this->mapVariations($remoteData),
        ]);
    }

    private function mapProduct($remoteId, object $remoteData)
    {
        $mappedProduct = $this->mapper->toLocal($this->mapping, $remoteData, 'local');
        $mappedProduct['stock_quantity'] = $this->api->getProductStockQty($remoteId);
        $mappedProduct['status'] = $remoteData['status'] === '2' ? 'disabled' : 'enabled';

        if (isset($remoteData->additional_attributes)) {
            foreach ($this->mapping['meta']['attributes'] as $key => $attr) {
                $remoteAttr = find($remoteData->additional_attributes, ['key' => $attr['slug']]);

                if (is_null($remoteAttr)) {
                    continue;
                }

                $mappedProduct[$key] = $this->findAttributeOptionLabelById($attr['slug'], $remoteAttr->value);
            }
        }

        return $mappedProduct;
    }

    /**
     * @param int|null $pg
     * @param null $lastReceivedAt
     * @return array
     * @throws \Exception
     */
    public function receive($pg = 1, $lastReceivedAt = null)
    {
        $filter = [];
        if (!is_null($lastReceivedAt)) {
            $filter = [
                'complex_filter' => [
                    [
                        'key' => 'updated_at',
                        'value' => ['key' => 'gt', 'value' => $lastReceivedAt],
                    ],
                ],
            ];
        }

        $remoteList = $this->api->getProductList($filter);
        $products = array_map(fn ($item) => $this->mapper->toLocal($item), $remoteList);

        return $this->sortProductsByConfigurableAndSKU($products);
    }

    /**
     * @param $attributeCode
     * @param $value
     * @return mixed
     */
    private function findAttributeOptionLabelById($attributeCode, $value)
    {
        $configCode = "{$attributeCode}.list";
        $channelOptionsConfig = get($this->configs, $configCode);

        try {
            $options = json_decode($channelOptionsConfig->value, true);
        } catch (\Exception $_ex) {
            $options = $this->api->getAttributeOptions($attributeCode);
        }

        return get(find($options, 'value', $value), 'label', $value);
    }

    /**
     * @param $remoteData
     * @return array
     */
    private function mapVariations($remoteData)
    {
        if (get($remoteData, 'type') !== 'configurable') {
            return [];
        }

        return map(get($remoteData, 'associated_skus', []), fn ($sku) => ['data' => ['sku' => $sku]]);
    }

    /**
     * @param $products
     * @return array
     */
    private function sortProductsByConfigurableAndSKU($products)
    {
        $cloned = array_replace([], $products);

        usort($cloned, function ($a, $b) {
            $aIsConfigurable = $a['type'] === 'configurable';
            $bIsConfigurable = $b['type'] === 'configurable';

            if ($aIsConfigurable && $bIsConfigurable) {
                return strcmp($a['sku'], $b['sku']);
            }
            if ($aIsConfigurable) {
                return -1;
            }
            if ($bIsConfigurable) {
                return +1;
            }

            return strcmp($a['sku'], $b['sku']);
        });

        return $cloned;
    }
}
