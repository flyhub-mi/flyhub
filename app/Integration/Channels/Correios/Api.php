<?php

namespace App\Integration\Channels\Correios;

use SoapClient;
use App\Integration\ChannelApi;

class Api extends ChannelApi
{
    /** @var string $url  */
    protected $url = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.asmx?wsdl';

    /** @var array $configs  */
    protected $configs;

    /** @var SoapClient $client  */
    protected $client;

    /**
     * @param array $configs
     * @return void
     */
    function __construct($configs)
    {
        $this->configs = $configs;
        $this->client = new SoapClient($this->url, [
            'trace'         => 1,
            'exceptions'    => true,
            'cache_wsdl'    => WSDL_CACHE_NONE,
            'encoding'      => 'UTF-8',
        ]);
    }

    /**
     * @param mixed $order
     * @return mixed
     */
    public function shipmentQuote($params)
    {
        return $this->client->CalcPrecoPrazo(array_merge([
            'nCdServico'            => '',
            'sCepOrigem'            => '',
            'sCepDestino'           => '',
            'nVlPeso'               => number_format(10, 2, ',', ''),
            'nVlComprimento'        => number_format(10, 2, ',', ''),
            'nVlAltura'             => number_format(10, 2, ',', ''),
            'nVlLargura'            => number_format(20, 2, ',', ''),
            'nVlDiametro'           => number_format(10, 2, ',', ''),
            'nVlValorDeclarado'     => number_format(0, 2, ',', ''),
            //
            'nCdEmpresa'            => $this->configs['login'],
            'sDsSenha'              => $this->configs['password'],
            'nCdFormato'            => $this->configs['format'],
            'sCdMaoPropria'         => $this->configs['own_hands'],
            'sCdAvisoRecebimento'   => $this->configs['receipt_notice'],
            'StrRetorno'            => 'xml',
        ], $params));
    }

    public function shipmentTracking($filterDate = null)
    {
        return [];
    }
}
