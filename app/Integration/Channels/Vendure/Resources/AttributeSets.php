<?php

namespace App\Integration\Channels\Vendure\Resources;

use App\Integration\ChannelResource;
use App\Integration\Channels\Vendure\Api;
use App\Integration\Mapping\DataMapper;

class AttributeSets extends ChannelResource
{
    protected $api;

    /**
     * @param \App\Models\Tenant\Channel $channel
     */
    public function __construct($channel)
    {
        parent::__construct($channel, 'attribute_sets');

        $this->api = new Api($this->configs['url'], $this->configs['access_token']);
    }

    /**
     * @param int $pg
     * @param null $lastReceivedAt
     * @return array
     * @throws \Exception
     */
    public function receive($pg = 1, $lastReceivedAt = null)
    {
        $attributeSets = [];
        $remoteAttributeSets = $this->api->get('products/attribute-sets/24/attributes');

        foreach ($remoteAttributeSets['items'] as $item) {
            $attributeSets[] = DataMapper::map($this->mapping['attribute_set'], $item, 'local');
        }

        return ['attributeSets' => $attributeSets, 'attributes' => []];
    }
}
