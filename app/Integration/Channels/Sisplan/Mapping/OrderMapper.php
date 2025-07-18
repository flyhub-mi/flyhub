<?php

namespace App\Integration\Channels\Sisplan\Mapping;

use App\Integration\Channels\Sisplan\Api;
use App\Integration\Mapping\ResourceMapper;
use App\Integration\Mapping\Column;
use App\Integration\Mapping\Resource;
use App\Models\Tenant\Channel;
use App\Models\Tenant\City;
use Carbon\Carbon;
use Http;

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
        $this->api = new Api($configs['url'], $configs['username'], $configs['password']);

        parent::__construct($channel, $configs, self::buildMapping());
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model|\App\Models\Tenant\Order $localOrder
     * @return array
     */
    public function toRemote($localOrder)
    {
        $mappedOrder = $this->mapData($localOrder, 'remote');
        if ($mappedOrder['per_desc'] > 0) {
            $mappedOrder['per_desc'] = 100 / $localOrder->grand_total * $mappedOrder['per_desc'];
        }
        $mappedOrder['items'] = $this->mapItemsToRemote($localOrder['items']);
        $mappedOrder['cliente'] = $this->mapCustomerToRemote($localOrder['customer'], $localOrder['billingAddress']);
        $mappedOrder['transportadora']['codigo'] = $this->mapCarrier($localOrder['order_shipments']);

        return $mappedOrder;
    }

    /**
     * @param $orderItems
     * @return array
     * @throws \Exception
     */
    private function mapItemsToRemote($orderItems)
    {
        return array_map(function ($item) {
            $product = $item['product']['parent'];

            return [
                'codigo' => explode('-', $product['sku'])[0],
            ];
        }, $orderItems);
    }

    /**
     * @param array $customer
     * @param array $billing
     * @return array
     */
    private function mapCustomerToRemote($customer, $billing)
    {
        $customerData['tipo'] = $customer['person_type'] == 'F' ? '1' : '2';
        $customerData['cep']['codmun'] = $this->getIbgeCode($billing);
        $customerData = array_merge(
            [
                'cep_cob' => $customerData['cep'],
                'cep_ent' => $customerData['cep'],
                'cnpj_cob' => $customerData['cnpj'],
                'cnpj_ent' => $customerData['cnpj'],
                'cons_final' => $customer['person_type'] == 'F' ? 'Sim' : 'Nao',
            ],
            $customerData,
        );

        return $customerData;
    }

    /**
     * @param mixed $state
     * @param mixed $city
     * @return string|null
     */
    private function getIbgeCodeByStateAndCity($state, $city)
    {
        $city = City::whereRaw('LOWER(state_code) = LOWER(?) AND LOWER(name) = LOWER(?)', [$state, $city])->first();

        return is_null($city) ? null : $city->ibge_id;
    }

    /**
     * @param mixed $postcode
     * @return string|null
     */
    private function getIbgeCodeByCep($postcode)
    {
        $response = Http::get("https://ws.apicep.com/cep/{$postcode}.json")->body();

        return isset($response['city'])
            ? $this->getIbgeCodeByStateAndCity($response['state'], $response['city'])
            : null;
    }

    /**
     * @param array $address
     * @return integer
     */
    private function getIbgeCode($address)
    {
        return $this->getIbgeCodeByStateAndCity($address['state'], $address['city'])
            || $this->getIbgeCodeByCep($address['postcode']);
    }

    private function mapCarrier($orderShipments)
    {
        foreach ($orderShipments as $shipment) {
            $carrier = strtolower($shipment['carrier']);

            if (strpos($carrier, 'braspress') !== false) return '02105';
            if (strpos($carrier, 'dlog') !== false) return '28578';
            if (strpos($carrier, 'sedex') !== false) return '04997';
            if (strpos($carrier, 'correios') !== false) return '00559';
            if (strpos($carrier, 'miguel') !== false) return '03317';
            if (strpos($carrier, 'jamef') !== false) return '29210';
            if (strpos($carrier, 'azul') !== false) return '01950';
            if (strpos($carrier, 'total') !== false) return '29168';
            if (strpos($carrier, 'jadlog') !== false) return '00591';
        }

        return '00002';
    }

    /** @return array  */
    public static function buildMapping()
    {
        return Resource::mapping(
            Resource::columns(
                Column::string('ped_cli', 'remote_id'),
                Column::string('dt_emissao', 'created_at'),
                Column::string('dt_fatura', 'created_at'),
                Column::string('desconto', 'discount_amount'),
                // remote
                Column::remote('dt_entrega', Carbon::now()->addDays(30)),
                Column::remote('dt_saida', ''),
                Column::remote('situacao', ''),
                Column::remote('colecao', ''),
                Column::remote('bloqueio', '1'),
                Column::remote('financeiro', '1'),
                Column::remote('natureza', ''),
                Column::remote('obs', ''),
                Column::remote('periodo', 0),
                Column::remote('per_desc', 'discount_amount'),
                Column::remote('val_desc_empenho', 0),
                Column::remote('frete', 1),
                Column::remote('com1', 0),
                Column::remote('com2', 0),
                Column::remote('tipo.descricao', ''),
                Column::remote('redespacho.codigo', ''),
            ),
            Resource::relations(
                Resource::mapping(
                    Resource::local('customer'),
                    Resource::remote('cliente'),
                    Resource::columns(
                        Column::string('nome', 'name'),
                        Column::string('fantasia', 'fantasy_name'),
                        Column::string('tipo', 'person_type'),
                        Column::string('inscricao', 'ie', 'ISENTO'),
                        Column::string('telefone', 'phone'),
                        Column::string('cnpj', 'cpf_cnpj', '', 'cpf_cnpj'),
                        Column::string('cnpj_cob', 'cpf_cnpj', '', 'cpf_cnpj'),
                        Column::string('cnpj_ent', 'cpf_cnpj', '', 'cpf_cnpj'),
                        Column::string('email', 'email'),
                        // remote
                        Column::remote('ativo', 'S'),
                        Column::remote('tipo_entidade', 'C'),
                        Column::remote('tributacao', 'N'),
                        Column::remote('cons_final', 'S'),
                        Column::remote('data_cad', now()),
                    ),
                ),
                Resource::mapping(
                    Resource::local('items', true),
                    Resource::remote('itens', true),
                    Resource::columns(
                        Column::string('codigo', 'product.parent.sku'),
                        Column::string('tamanho', 'product.parent.size'),
                        Column::string('cor', 'channelProduct.color_code'),
                        Column::double('preco', 'price'),
                        Column::double('preco_orig', 'price'),
                        Column::integer('qtde', 'qty_ordered'),
                        Column::remote('tipo', 'P'),
                    ),
                ),
                Resource::mapping(
                    Resource::local('billingAddress'),
                    Resource::remote('cliente'),
                    Resource::columns(
                        // entidade
                        Column::string('endereco', 'street'),
                        Column::string('numero', 'number', 'SN'),
                        Column::string('complemento', 'complement'),
                        Column::string('bairro', 'neighborhood'),
                        Column::string('cep.cep', 'postcode'),
                        Column::string('fone_cob', 'phone'),
                        Column::string('insc_cob', 'ie', 'ISENTO'),
                        // cobranca
                        Column::string('end_cob', 'street'),
                        Column::string('num_cob', 'number', 'SN'),
                        Column::string('compl_cob', 'complement'),
                        Column::string('bairro_cob', 'neighborhood'),
                        Column::string('cep_cob.cep', 'postcode'),
                    ),
                ),
                Resource::mapping(
                    Resource::local('shippingAddress'),
                    Resource::remote('cliente'),
                    Resource::columns(
                        Column::string('end_ent', 'street'),
                        Column::string('num_ent', 'number', 'SN'),
                        Column::string('compl_ent', 'complement'),
                        Column::string('bairro_ent', 'neighborhood'),
                        Column::string('cep_ent.cep', 'postcode'),
                        Column::string('insc_ent', 'ie', 'ISENTO'),
                    ),
                ),
            ),
            Resource::configs(
                Resource::columns(
                    Column::remote('deposito', '0001'),
                    Column::remote('pgto', '30'),
                    Column::remote('status', '002'),
                    Column::remote('tab_pre', '010'),
                    Column::remote('tipo.id_tipo', '3'),
                    Column::remote('cliente.representante.codrep', '25692'),
                    Column::remote('representante.codrep', '25692'),
                    Column::remote('transportadora.codigo', '00002'),
                    Column::string('cliente.cod_pais', 'country', '1058'),
                ),
            ),
        );
    }
}
