<?php

namespace App\Integration\Channels\Magento2\Mapping;

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

    /**
     * @param array $remoteItem
     * @return array
     */
    public function toLocal($remoteItem)
    {
        $mappedProduct = $this->mapData($remoteItem, 'local');

        return $mappedProduct;
    }

    /** @return array  */
    public static function buildMapping()
    {
        return Resource::mapping(
            Resource::columns(
                Column::string('id', 'remote_id'),
                Column::string('type_id', 'type'),
                Column::string('sku', 'sku'),
                Column::string('name', 'name', '', ['trim', 'html-remove']),
                Column::double('price', 'price'),
                Column::string('weight', 'gross_weight', '0.31'),
                Column::string('status', 'status', '1'),
            )
        );
    }
}
