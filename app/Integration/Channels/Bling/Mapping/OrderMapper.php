<?php

namespace App\Integration\Channels\Bling\Mapping;

use App\Integration\Channels\Bling\Api;
use App\Integration\Mapping\ResourceMapper;
use App\Integration\Mapping\Column;
use App\Integration\Mapping\Resource;
use App\Models\Tenant\Channel;

class OrderMapper extends ResourceMapper
{
    protected $api;

    /**
     * @param Channel|null $channel
     * @param array|null $configs
     * @return void
     */
    public function __construct($channel = null, $configs = null)
    {
        parent::__construct($channel, $configs, self::buildMapping());
    }

    /**
     * @param array $resourceData
     * @return array
     */
    public function toLocal($remoteData)
    {
        $mappedData = $this->mapData($remoteData, 'local');

        if (!empty($mappedData['channel_name'])) {
            $mappedData['channel_name'] = "Bling - {$mappedData['channel_name']}";
        }

        return $mappedData;
    }

    /** @return array  */
    public static function buildMapping()
    {
        return Resource::mapping(
            Resource::columns(
                Column::string('numero', 'remote_id'),
                Column::double('desconto', 'discount_amount'),
                Column::date('data', 'date'),
                Column::double('valorfrete', 'shipping_amount'),
                Column::double('totalprodutos', 'sub_total'),
                Column::double('totalvenda', 'grand_total'),
                Column::string('situacao', 'status'),
                Column::date('dataSaida', ''),
                Column::string('numeroPedidoLoja', 'remote_id'),
                Column::string('cliente.nome', 'customer_name'),
                Column::string('cliente.email', 'customer_email'),
                Column::string('tipoIntegracao', 'channel_name'),
                /* ------------------------------------------- */
                Column::remote('observacoes'),
                Column::remote('observacaointerna'),
                Column::remote('vendedor'),
                Column::remote('loja'),
            ),
            Resource::relations(
                Resource::mapping(
                    Resource::local('customer'),
                    Resource::remote('cliente'),
                    Resource::columns(
                        Column::string('id', 'remote_id'),
                        Column::string('nome', 'name'),
                        Column::string('email', 'email'),
                        Column::string('cnpj', 'cpf_cnpj'),
                        Column::string('ie', 'ie'),
                        Column::string('rg', 'rg'),
                    ),
                ),
                Resource::mapping(
                    Resource::local('items', true),
                    Resource::remote('itens', true),
                    Resource::columns(
                        Column::string('item.codigo', 'sku'),
                        Column::string('item.descricao', 'name'),
                        Column::integer('item.quantidade', 'qty_ordered'),
                        Column::double('item.valorunidade', 'price'),
                        Column::double('item.precocusto', 'cost'),
                        Column::double('item.descontoItem', 'discount_amount'),
                        Column::string('item.un', 'unit'),
                    ),
                ),
                Resource::mapping(
                    Resource::local('shippingAddress'),
                    Resource::remote('transporte.enderecoEntrega'),
                    Resource::columns(
                        Column::string('nome', 'name'),
                        Column::string('endereco', 'street'),
                        Column::string('numero', 'number'),
                        Column::string('complemento', 'complement'),
                        Column::string('bairro', 'neighborhood'),
                        Column::string('cep', 'postcode'),
                        Column::string('cidade', 'city'),
                        Column::string('uf', 'state'),
                    ),
                ),
                Resource::mapping(
                    Resource::local('billingAddress'),
                    Resource::remote('cliente'),
                    Resource::columns(
                        Column::string('nome', 'name'),
                        Column::string('email', 'email'),
                        Column::string('fone', 'phone'),
                        Column::string('celular', 'cellphone'),
                        Column::string('cnpj', 'cpf_cnpj'),
                        Column::string('ie', 'cpf_cnpj'),
                        Column::string('rg', 'cpf_cnpj'),
                        Column::string('endereco', 'street'),
                        Column::string('numero', 'number'),
                        Column::string('complemento', 'complement'),
                        Column::string('bairro', 'neighborhood'),
                        Column::string('cep', 'postcode'),
                        Column::string('cidade', 'city'),
                        Column::string('uf', 'state'),
                    ),
                ),
                Resource::mapping(
                    Resource::local('payments'),
                    Resource::remote('parcelas'),
                    Resource::columns(
                        Column::string('parcela.idLancamento', 'transaction_id'),
                        Column::double('parcela.valor', 'total_paid'),
                        Column::date('parcela.dataVencimento', 'due_date'),
                        Column::string('parcela.obs', 'method'),
                    ),
                )
            )
        );
    }
}
