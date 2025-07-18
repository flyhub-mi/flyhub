<?php

namespace App\Integration\Channels\Magento\Mapping;

use App\Integration\Mapping\ResourceMapper;
use App\Integration\Mapping\Column;
use App\Integration\Mapping\Resource;

class ProductMapper extends ResourceMapper
{
    /**
     * @param \App\Models\Tenant\Channel $channel
     * @param array $configs
     */
    public function __construct($channel, $configs = null)
    {
        parent::__construct($channel, $configs, $this->buildMapping());
    }

    /** @return array  */
    public static function buildMapping()
    {
        return Resource::mapping(
            Resource::columns(
                Column::string('product_id', 'remote_id'),
                Column::string('type', 'type'),
                Column::string('sku', 'sku'),
                Column::string('name', 'name', '', ['trim', 'html-remove']),
                Column::string('description', 'description'),
                Column::string('short_description', 'short_description'),
                Column::string('price', 'price', '0'),
                Column::string('gross_weight', 'weight', '0.31'),
                Column::string('status', 'status', '1'),
            )
        );
    }
}
