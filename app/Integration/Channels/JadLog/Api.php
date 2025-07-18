<?php

namespace App\Integration\Channels\JadLog;

use SoapClient;
use Http;
use App\Integration\ChannelApi;

class Api extends ChannelApi
{
    /** @var string $baseUrl  */
    protected $baseUrl = 'http => //www.jadlog.com.br/embarcador/api/';

    /** @var SoapClient $client  */
    protected $client;

    /**
     * @param mixed $configs
     * @return void
     */
    function __construct($configs)
    {
        $this->client = Http::withToken($configs['token'])->baseUrl($this->baseUrl);
    }

    /**
     * @param mixed $order
     * @return mixed
     */
    public function shipmentQuote($params)
    {
        return $this->client->post('frete/valor', [
            "frete" => [
                [
                    "cepori" => "06233200",
                    "cepdes" => "17213580",
                    "frap" => null,
                    "peso" => 13.78,
                    "cnpj" => "12345678901234",
                    "conta" => "000001",
                    "contrato" => "123",
                    "modalidade" => 3,
                    "tpentrega" => "D",
                    "tpseguro" => "N",
                    "vldeclarado" => 149.97,
                    "vlcoleta" => null
                ]
            ]
        ]);
    }

    public function createShipment($params)
    {
        return $this->client->post('pedido/incluir', [
            "conteudo" => "PENDRIVE E MOUSE",
            "pedido" => ["123456", "654321"],
            "totPeso" => 1,
            "totValor" => 25.52,
            "obs" => "OBS XXXXX",
            "modalidade" => 3,
            "contaCorrente" => "000001",
            "tpColeta" => "K",
            "tipoFrete" => 0,
            "cdUnidadeOri" => "1",
            "cdUnidadeDes" => null,
            "cdPickupOri" => null,
            "cdPickupDes" => "BR00001",
            "nrContrato" => 12345,
            "servico" => 1,
            "shipmentId" => null,
            "vlColeta" => null,
            "rem" => [
                "nome" => "NOME DO REMETENTE",
                "cnpjCpf" => "00000000000000",
                "ie" => null,
                "endereco" => "RUA DO REMETENTE",
                "numero" => "123",
                "compl" => null,
                "bairro" => "BAIRRO",
                "cidade" => "SAO PAULO",
                "uf" => "SP",
                "cep" => "01310000",
                "fone" => "11 99999999",
                "cel" => "11 999999999",
                "email" => "email@jremetente.com.br",
                "contato" => "NOME CONTATO"
            ],
            "des" => [
                "nome" => "NOME DO DESTINATARIO",
                "cnpjCpf" => "00000000000000",
                "ie" => null,
                "endereco" => "RUA DO DESTINATARIO",
                "numero" => "321",
                "compl" => null,
                "bairro" => "BAIRRO",
                "cidade" => "SAO PAULO",
                "uf" => "SP",
                "cep" => "01310000",
                "fone" => "11 99999999",
                "cel" => "11 999999999",
                "email" => "email@destinatario.com.br",
                "contato" => "NOME CONTATO"
            ],
            "dfe" => [ // Grupo dos documentos fiscais (Nfe/Cte/Etc)
                [
                    "cfop" => "6909",
                    "danfeCte" => "00000000000000000000000000000000000000000000",
                    "nrDoc" => "00000000",
                    "serie" => "0",
                    "tpDocumento" => 2,
                    "valor" => 20.2
                ],
                [
                    "cfop" => "6909",
                    "danfeCte" => "00000000000000000000000000000000000000000000",
                    "nrDoc" => "00000000",
                    "serie" => "0",
                    "tpDocumento" => 2,
                    "valor" => 13.1
                ]
            ],
            "volume" => [
                [
                    "altura" => 10,
                    "comprimento" => 10,
                    "identificador" => "1234567890",
                    "largura" => 10,
                    "peso" => 1.0
                ],
                [
                    "altura" => 8,
                    "comprimento" => 8,
                    "identificador" => "0987654321",
                    "largura" => 10,
                    "peso" => 1.0
                ]
            ]

        ]);
    }

    public function shipmentTracking($code)
    {
        return $this->client->post('tracking/consultar', [
            'consulta' => [
                ['codigo' => ''],
            ]
        ]);
    }
}
