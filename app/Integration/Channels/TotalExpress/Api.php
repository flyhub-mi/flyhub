<?php

namespace App\Integration\Channels\TotalExpress;

use SoapClient;
use App\Integration\ChannelApi;

class Api extends ChannelApi
{
    protected $auth;

    function __construct($configs)
    {
        $this->auth = ['login' => $configs['login'], 'password' => $configs['password']];
    }

    /**
     * Agendar Coleta
     * @param mixed $orders
     * @return mixed
     */
    public function registerPickup($orders)
    {
        $client = new SoapClient('https://edi.totalexpress.com.br/webservice24.php?wsdl', $this->auth);

        return $client->registraColeta([
            'Encomendas' => [
                [
                    'TipoServico' => 'EXP',
                    'TipoServicoTipo' => 'EXP', // Em caso do TipoServico = 4, deverá ser informado o CNPJ do Estabelecimento de retirada da encomenda
                    'TipoEntrega' => 0, // 0 = Entrega Normal (padrão) / 1 = GoBack / 2 = RMA
                    'CepDestino' => '88240000',
                    'Peso' => number_format(1, 2, ',', ''),
                    'Volumes' => 1,
                    'CondFrete' => 'CIF', // Preencher com CIF
                    'ValorDeclarado' => number_format(80, 2, ',', ''),
                    'Natureza' => '', // Natureza da Mercadoria
                    'TipoVolumes' => 'CX',
                    'IsencaoIcms' => 1,
                ]
            ]
        ]);
    }

    /**
     * Quotação de Frete
     * @param mixed $order
     * @return mixed
     */
    public function shipmentQuote()
    {
        $client = new SoapClient('https://edi.totalexpress.com.br/webservice_calculo_frete.php?wsdl', $this->auth);

        return $client->calcularFrete([
            'TipoServico' => 'EXP',
            'CepDestino' => '88240000',
            'Peso' => number_format(1, 2, ',', ''),
            'ValorDeclarado' => number_format(80, 2, ',', ''),
            'TipoEntrega' => 0,
            'ServicoCOD' => false,
            'Altura' => number_format(10, 2, ',', ''),
            'Largura' => number_format(15, 2, ',', ''),
            'Profundidade' => number_format(17, 2, ',', ''),
        ]);
    }

    /**
     * Rstreamento
     * @param mixed $filterDate
     * @return mixed
     */
    public function shipmentTracking($filterDate = null)
    {
        $client = new SoapClient('https://edi.totalexpress.com.br/webservice24.php?wsdl', $this->auth);


        return $client->obterTracking(['DataConsulta' => $filterDate])->ArrayLoteRetorno;
    }
}
