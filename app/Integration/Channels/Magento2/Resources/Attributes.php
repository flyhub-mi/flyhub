<?php

namespace App\Integration\Channels\Magento2\Resources;

use App\Integration\ChannelResource;
use App\Integration\Channels\Magento2\Api;

class Attributes extends ChannelResource
{
    protected $api;

    /**
     * @param \App\Models\Tenant\Channel $channel
     */
    public function __construct($channel)
    {
        parent::__construct($channel, 'attributes');

        $this->api = new Api($this->configs['url'], $this->configs['access_token']);
    }

    /**
     * @param int $id
     * @param null $lastReceivedAt
     * @return array
     * @throws \Exception
     */
    public function receive($id = null)
    {
        $items = $this->api->get('products/attribute-sets/' . $id . '/attributes');

        return $items;
    }
}
