<?php

namespace App\Integration\Channels\Medusa\Mapping;

use App\Integration\Mapping\ResourceMapper;
use App\Integration\Mapping\Resource;
use App\Integration\Mapping\Column;

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
        $mapped = $this->mapData($remoteItem, 'local');

        return $mapped;
    }

    /**
     * @param array $localItem
     * @param null|array $remoteAttributes
     * @return array
     */
    public function toRemote($localItem, $remoteAttributes = [])
    {
        $mapped = $this->mapData($localItem, 'remote');

        return $mapped;
    }

    /** @return array  */
    public static function buildMapping()
    {
        $base = [
            Column::string('title', 'name'),
            Column::string('description', 'description'),
            Column::integer('inventory_quantity', 'stock_quantity'),
            Column::string('weight', 'weight', '0.31'),
            Column::string('width', 'width', '15'),
            Column::string('height', 'height', '15'),
            Column::string('length', 'depth', '15'),
        ];

        return Resource::mapping(
            Resource::columns(
                Column::string('status', 'status', 'private'),
                Column::string('handle', 'sku'),
                Column::string('original_price', 'price'),
                ...$base,
            ),
            Resource::relations(
                Resource::mapping(
                    Resource::local('variations', true),
                    Resource::remote('variants', true),
                    Resource::columns(
                        Column::string('sku', 'sku'),
                        ...$base,
                    ),
                ),
                Resource::mapping(
                    Resource::local('images', true),
                    Resource::remote('images', true),
                    Resource::columns(
                        Column::string('id', 'remote_id'),
                        Column::string('url', 'path'),
                    ),
                ),
            ),
        );
    }
}
