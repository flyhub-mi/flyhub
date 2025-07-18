<?php

namespace App\Integration\Channels\Medusa\Mapping;

use App\Integration\Mapping\ResourceMapper;
use App\Integration\Mapping\Resource;
use App\Integration\Mapping\Column;

class CategoryMapper extends ResourceMapper
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
     * @param array $remoteItem
     * @return array
     */
    public function toLocal($remoteItem)
    {
        return $this->mapData($remoteItem, 'local');
    }

    /**
     * @param array $localItem
     * @param null|array $remoteAttributes
     * @return array
     */
    public function toRemote($localItem, $remoteAttributes = [])
    {
        return $this->mapData($localItem, 'remote');
    }


    /** @return array  */
    public static function buildMapping()
    {
        return Resource::mapping(
            Resource::columns(
                Column::integer('id', 'remote_id'),
                Column::string('name', 'name', ''),
                Column::boolean('is_active', 'is_active', true)
            ),
        );
    }
}
