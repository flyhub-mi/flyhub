<?php

namespace App\Integration\Channels\Bling\Mapping;

use App\Integration\Mapping\ResourceMapper;
use App\Integration\Mapping\Column;
use App\Integration\Mapping\Resource;

use App\Models\Tenant\Channel;

class ProductMapper extends ResourceMapper
{
    protected $api;

    /**
     * @param Channel $channel
     * @param array $configs
     * @return void
     */
    public function __construct($channel, $configs = null)
    {
        parent::__construct($channel, $configs, self::buildMapping());
    }

    /** @return array  */
    public static function buildMapping()
    {
        return Resource::mapping(
            Resource::columns(
                Column::string('nome', 'name'),
                Column::string('codigo', 'sku'),
                Column::string('descricao', 'description'),
                Column::string('descricaoCurta', 'short_description'),
                Column::string('un', 'unit'),
                Column::double('vlr_unit', 'price'),
                Column::double('preco_custo', 'cost'),
                Column::double('peso_bruto', 'gross_weight'),
                Column::double('peso_liq', 'net_weight'),
                Column::double('marca', 'brand'),
                Column::double('estoque', 'stock_quantity'),
                Column::string('gtin', 'gtin'),
                Column::string('largura', 'width'),
                Column::string('altura', 'height'),
                Column::string('profundidade', 'depth'),
            ),
            Resource::relations(
                Resource::mapping(
                    Resource::local('variations'),
                    Resource::remote('variacoes'),
                    Resource::columns(
                        Column::string('variacao.nome', 'name'),
                        Column::string('variacao.codigo', 'sku'),
                        Column::double('variacao.vlr_unit', 'price'),
                        Column::double('variacao.estoque', 'stock_quantity'),
                        Column::string('variacao.un', 'unit'),
                        /* ----------------------------------------- */
                        Column::remote('variacao.clonarDadosPai', 'S'),
                    ),
                ),
            ),
        );
    }
}
