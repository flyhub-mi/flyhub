<?php

namespace App\Integration\Channels\WooCommerce\Resources;

use App\Integration\ChannelResource;
use App\Integration\Channels\WooCommerce\Api;
use App\Integration\Channels\WooCommerce\Mapping\AttributeMapper;

use function _\find;
use function _\get;

class Attributes extends ChannelResource
{
    protected $api;
    protected $mapper;

    /**
     * @param \App\Models\Tenant\Channel $channel
     * @param array $configs
     */
    public function __construct($channel)
    {
        parent::__construct($channel, 'attributes');

        $this->api = new Api($this->configs);
        $this->mapper = new AttributeMapper($channel, $this->configs);
    }

    /**
     * @param int $pg
     * @param mixed $lastReceivedAt
     * @return array
     */
    public function receive($pg = 1, $lastReceivedAt = null)
    {
        return $this->api->getAttributesWithTerms();
    }

    /**
     * @param array $localProduct
     * @return array
     */
    public function send($localProduct)
    {
        $remoteAttributes = $this->api->getAttributesWithTerms();
        $mappedAttrs = $this->mapper->toRemote($localProduct);

        return $this->saveAttributeAndTerms($mappedAttrs, $remoteAttributes);
    }

    /**
     * @param array $attributes
     * @param array $variations
     * @return array
     */
    private function saveAttributeAndTerms($mappedAttrs, $remoteAttributes)
    {
        $batch = ['create' => []];

        foreach ($mappedAttrs as $attr) {
            $remote = null;

            if (isset($attr['slug'])) {
                $remote = find($remoteAttributes, ['slug' => $attr['slug']]);
            }

            if (is_null($remote)) {
                $batch['create'][] = $attr;
            }
        }

        $remoteAttributes = $this->api->batch('products/attributes/batch', $batch, $remoteAttributes);

        return array_map(fn ($remoteAttr) => array_merge(
            $remoteAttr,
            ['terms' => $this->saveAttributeTerms($remoteAttr['id'], $mappedAttrs, $remoteAttr)]
        ), $remoteAttributes);
    }

    /**
     * @param array $attributes
     * @param array $variation
     * @return array
     */
    private function saveAttributeTerms($attributeId, $mappedAttrs, $remoteAttr)
    {
        $mappedAttr = find($mappedAttrs, ['slug' => $remoteAttr['slug']]);
        $mappedTerms = get($mappedAttr, 'terms', []);
        $remoteTerms = get($remoteAttr, 'terms', []);

        $batch = ['create' => []];
        foreach ($mappedTerms as $term) {
            $remote = null;

            if (isset($attr['slug'])) {
                $remote = find($remoteTerms, ['slug' => $attr['slug']]);
            }

            if (is_null($remote)) {
                $batch['create'][] = $term;
            }
        }
        return $this->api->batch("products/attributes/{$attributeId}/terms/batch", $batch, $remoteTerms);
    }
}
