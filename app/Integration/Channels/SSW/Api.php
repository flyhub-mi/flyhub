<?php

namespace App\Integration\Channels\SSW;

use SoapClient;
use App\Integration\ChannelApi;

class Api extends ChannelApi
{
    protected array $auth;

    function __construct($configs)
    {
        $this->auth = [
            'dominio' => $configs['dominio'],
            'login' => $configs['login'],
            'senha' => $configs['senha'],
        ];
    }

    /**
     * Agendar Coleta
     * @param mixed $orders
     * @return mixed
     */
    public function registerPickup($shipment = null)
    {
        $client = new SoapClient('https://ssw.inf.br/ws/sswColeta/index.php?wsdl');

        return $client->coletar(array_merge([
            'cnpjRemetente' => '',
            'cnpjDestinatario' => '',
            'numeroNF' => '',
            'tipoPagamento' => 'O',
            'enderecoEntrega' => '',
            'cepEntrega' => '88240000',
            'solicitante' => '',
            'limiteColeta' => '',
            'quantidade' => 1,
            'peso' => number_format(1, 2, ',', ''),
            'observacao' => '',
            'instrucao' => '',
            'cubagem' => number_format(80, 2, ',', ''),
            'valor_mercadoria 	' => number_format(80, 2, ',', ''),
            'chave_nfe' => '',
            'cnpjSolicitante' => '',
            'nroPedido' => '',
        ], $this->auth));
    }

    /**
     * Quotação de Frete
     * @param mixed $order
     * @return mixed
     */
    public function shipmentQuote($shipment = null)
    {
        $client = new SoapClient('https://ssw.inf.br/ws/sswCotacao/index.php?wsdl');

        $data = array_merge([
            'cnpjPagador' => '',
            'cepOrigem' => '88240000',
            'cepDestino' => '88240000',
            'valorNF' => number_format(80, 2, ',', ''),
            'quantidade' => 1,
            'peso' => number_format(1, 2, ',', ''),
            'volume' => number_format(10, 2, ',', ''),
            'mercadoria' => 1,
            'cnpjDestinatario' => '',
            'coletar' => 'S',
            'entDificil' => 'N',
            'destContribuinte' => 'N',
        ], $this->auth);

        return $client->__soapCall('cotar', $data);
    }

    /**
     * Rstreamento
     * @param mixed $filterDate
     * @return mixed
     */
    public function shipmentTracking($filterDate = null)
    {
        $client = new SoapClient('https://ssw.inf.br/ws/sswCotacao/index.php?wsdl');

        return $client->obterTracking(['DataConsulta' => $filterDate])->ArrayLoteRetorno;
    }
}
