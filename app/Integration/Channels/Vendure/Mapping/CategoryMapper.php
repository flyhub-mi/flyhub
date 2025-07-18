<?php

namespace App\Integration\Channels\Vendure\Mapping;

use App\Integration\Mapping\ResourceMapper;
use App\Integration\Mapping\Column;
use App\Integration\Mapping\Resource;

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

    /** @return array  */
    public static function buildMapping()
    {
        return Resource::mapping(
            Resource::columns(
                Column::integer('id', 'remote_id'),
                Column::string('name', 'name'),
                Column::integer('position', 'position'),
                Column::local('status', '1')
            ),
        );
    }
}
