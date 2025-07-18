<?php

namespace App\Integration\Channels\TotalExpress\Mapping;

use App\Integration\Mapping\ResourceMapper;
use App\Integration\Mapping\Resource;
use App\Integration\Mapping\Column;

class ShipmentMapper extends ResourceMapper
{
    /**
     * @param \App\Models\Tenant\Channel $channel
     * @param array $configs
     * @param array $mapping
     */
    public function __construct($channel)
    {
        parent::__construct($channel, $configs, $this->buildMapping());
    }

    public static function buildMapping()
    {
        return Resource::mapping(
            Resource::columns(
                Column::string('method_title',          'carrier'),
                Column::string('method_id',             'method'),
                Column::double('total',                 'total_price'),
            ),
        );
    }
}
