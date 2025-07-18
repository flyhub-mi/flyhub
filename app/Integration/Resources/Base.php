<?php

namespace App\Integration\Resources;

abstract class Base
{
    /**
     * @param \App\Models\Tenant\Channel $channel
     * @param array $mappedItems
     * @return array
     */
    abstract public function save($channel, $mappedItems);

    /**
     * @param \App\Models\Tenant\Channel $channel
     * @param \Illuminate\Database\Eloquent\Model $resource
     * @return bool
     */
    abstract public function canSend($channel, $resource);

    /**
     * @param \Illuminate\Database\Eloquent\Model $resource
     * @return array
     */
    abstract public function getData($resource);

    /**
     * @param \Illuminate\Database\Eloquent\Model|\App\Models\Tenant\Channel $channel
     * @return array
     */
    abstract public function itemsToSend($channel);
}
