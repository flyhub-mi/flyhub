<?php

namespace App\Integration\Channels\Sisplan\Mapping;

use App\Integration\Mapping\ResourceMapper;
use App\Integration\Mapping\Column;
use App\Integration\Mapping\Resource;
use App\Models\Channel;

class ProductMapper extends ResourceMapper
{
    /**
     * @param Channel|null $channel
     * @param array|null $configs
     * @return void
     */
    public function __construct($channel = null, $configs = null)
    {
        parent::__construct($channel, $configs, self::buildMapping());
    }

    public static function buildMapping()
    {
        return Resource::mapping(
            Resource::columns(
                Column::local('channel_name', 'SisPlan'),
                Column::string('ativo', 'status'),
                Column::sku(['codigo', 'cor.descricao']),
                Column::string('descricao', 'name'),
                Column::double('preco', 'price'),
                Column::double('peso', 'gross_weight'),
                Column::string('unidade', 'un'),
            ),
            Resource::relations(
                Resource::mapping(
                    Resource::local('variations', true),
                    Resource::remote('estoque', true),
                    Resource::columns(
                        Column::sku(['codigo', 'cor.descricao', 'tam']),
                        Column::concat(['descricao', 'tam'], 'name', null, ' - '),
                        Column::string('ativo', 'status'),
                        Column::double('preco', 'preco_sku'),
                        Column::integer('qtde', 'stock_quantity'),
                        Column::double('peso', 'gross_weight', 0.31),
                        Column::string('cor.descricao', 'color'),
                        Column::string('cor.codigo', 'channel_product_attributes.color_code'),
                        Column::string('tam', 'size'),
                    ),
                ),
            ),
        );
    }
}
