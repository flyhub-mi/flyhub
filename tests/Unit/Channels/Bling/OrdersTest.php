<?php

namespace Tests\Unit\Channels\Bling;

use App\Integration\Channels\Bling\Orders;
use App\Models\Tenant\Channel;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class OrdersTest extends TestCase
{
    private Orders $subject;

    public function setUp(): void
    {
        parent::setUp();

        $remoteOrders = $this->decodeJsonFile(__DIR__ . "/_files/remote_orders.json");
        Http::fake(['bling.com.br/Api/v2/pedidos/json/*' => Http::response($remoteOrders, 200)]);

        $this->subject = new Orders(
            new Channel(['id' => 1, 'code' => 'Bling', 'name' => 'Bling']),
            ['apiKey' => 'api-key'],
        );
    }

    public function tearDown(): void
    {
        parent::tearDown();

        $this->subject = null;
    }

    public function testSisplanOrdersReceive()
    {
        $response = $this->subject->receive();
        $firstOrder = $response[0];
        $lastOrder = $response[99];

        $this->assertCount(100, $response);

        $this->assertEquals([
            'discount_amount' => 0,
            'remote_id' => '54',
            'shipping_amount' => 15.83,
            'sub_total' => 33.99,
            'grand_total' => 49.82,
            'status' => 'Em aberto',
            'customer_name' => 'Amanda Borsuk',
            'customer_email' => '07318093940@email.com.br',
            'channel_name' => 'Bling - Olist',
            'observacoes' => '',
            'observacaointerna' => '',
            'vendedor' => '',
            'loja' => '',
            'customer' => [
                'remote_id' => '9341007387',
                'name' => 'Amanda Borsuk',
                'email' => '07318093940@email.com.br',
                'cpf_cnpj' => '073.180.939-40',
                'ie' => '',
                'rg' => '',
            ],
            'items' => [
                [
                    'sku' => '39764',
                    'name' => 'Jogo Crocodilo Morde Dedo - Art Brink',
                    'qty_ordered' => 1,
                    'price' => 33.99,
                    'cost' => 0,
                    'discount_amount' => 0,
                    'unit' => 'UN',
                ],
            ],
            'shippingAddress' => [
                'name' => '',
                'street' => '',
                'number' => '',
                'complement' => '',
                'neighborhood' => '',
                'postcode' => '',
                'city' => '',
                'state' => '',
            ],
            'billingAddress' => [
                'name' => 'Amanda Borsuk',
                'phone' => '',
                'cellphone' => '',
                'cpf_cnpj' => '',
                'street' => 'Rua Emílio Zattera',
                'number' => '103',
                'complement' => 'Sobrado 2/Próximo ao Super mercado Condor São Braz',
                'city' => 'Curitiba',
                'neighborhood' => 'São Braz',
                'postcode' => '82300660',
                'state' => 'PR',
            ],
            'payments' => [
                [
                    'transaction_id' => '',
                    'total_paid' => 49.82,
                    'due_date' => '2020-10-01',
                    'notes' => 'Método de pagamento: credit_card',
                    'method' => 'Conta a receber/pagar',
                ],
            ],
        ], $firstOrder);

        $this->assertEquals([
            'remote_id' => '100',
            'discount_amount' => 0,
            'shipping_amount' => 31.05,
            'sub_total' => 67.98,
            'grand_total' => 99.03,
            'status' => 'Em aberto',
            'customer_name' => 'CAROLINE SCHWAN GUERINI CARNEIRO',
            'customer_email' => '08358727771@email.com.br',
            'channel_name' => 'Bling - SkyHub',
            'observacoes' => '',
            'observacaointerna' => '',
            'vendedor' => '',
            'loja' => '',
            'customer' => [
                'remote_id' => '9475273672',
                'name' => 'CAROLINE SCHWAN GUERINI CARNEIRO',
                'email' => '08358727771@email.com.br',
                'cpf_cnpj' => '083.587.277-71',
                'ie' => '',
                'rg' => '',
            ],
            'items' => [
                [
                    'sku' => '41471',
                    'name' => 'Boneca LQL Surpresa Fashion O.M.G. - Imporluc',
                    'qty_ordered' => 2,
                    'price' => 33.99,
                    'cost' => 0,
                    'discount_amount' => 0,
                    'unit' => 'UN',
                ],
            ],
            'shippingAddress' => [
                'name' => 'Caroline Schwan Guerini',
                'street' => 'Avenida Presidente Vargas',
                'number' => '400,',
                'complement' => 'Casa 55 - Ao lado do parque de exposição',
                'neighborhood' => 'Santa Cruz',
                'postcode' => '28.055-293',
                'city' => 'Campos dos Goytacazes',
                'state' => 'RJ'
            ],
            'billingAddress' => [
                'name' => 'CAROLINE SCHWAN GUERINI CARNEIRO',
                'phone' => '',
                'cellphone' => '',
                'cpf_cnpj' => '',
                'street' => 'Avenida Presidente Vargas',
                'number' => '400,',
                'complement' => 'Casa 55 - Ao lado do parque de exposição',
                'neighborhood' => 'Santa Cruz',
                'postcode' => '28055293',
                'city' => 'Campos dos Goytacazes',
                'state' => 'RJ',
            ],
            'payments' => [
                [
                    'transaction_id' => '',
                    'total_paid' => 99.03,
                    'due_date' => '2020-09-15',
                    'notes' => '',
                    'method' => 'Dinheiro',
                ],
            ],
        ], $lastOrder);
    }
}
