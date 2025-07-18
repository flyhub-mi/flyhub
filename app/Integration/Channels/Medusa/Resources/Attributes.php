<?php

namespace App\Integration\Channels\Medusa\Resources;

use App\Integration\ChannelResource;
use App\Integration\Channels\Medusa\Api;

class Attributes extends ChannelResource
{
    protected $api;

    /**
     * @param \App\Models\Tenant\Channel $channel
     */
    public function __construct($channel)
    {
        parent::__construct($channel, 'attributes');

        $this->api = new Api($this->configs);
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
