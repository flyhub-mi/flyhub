<?php

namespace App\Integration\Channels\WooCommerce\Mapping;

use App\Integration\Mapping\ResourceMapper;
use App\Integration\Mapping\Resource;
use App\Integration\Mapping\DataMapper;
use App\Integration\Mapping\Column;

class OrderMapper extends ResourceMapper
{
    /**
     * @param \App\Models\Tenant\Channel $channel
     * @param array $configs
     * @param array $mapping
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
        $mappedData = $this->mapData($remoteItem, 'local');
        $mappedData['payments'] = $this->mapPaymentsMetadataToLocal($remoteItem['meta_data'], $mappedData['payments']);

        return $mappedData;
    }

    /**
     * @param array $remoteItem
     * @return array
     */
    private function mapPaymentsMetadataToLocal($metaData, $mappedPayments)
    {
        if (isset($metaData['_wc_pagseguro_payment_data'])) {
            $pagseguroValue = $metaData['_wc_pagseguro_payment_data'];
            $mappedPayments[0]['installments'] = $pagseguroValue['installments'];
            $mappedPayments[0]['notes'] = $pagseguroValue['method'];

            return $mappedPayments;
        }

        if (isset($metaData['_wc_pagarme_transaction_data'])) {
            $pagarmeValue = $metaData['_wc_pagarme_transaction_data'];
            $mappedPayment[0]['installments'] = $pagarmeValue['installments'];
            $mappedPayment[0]['notes'] = $pagarmeValue['payment_method'];

            if (isset($meta['_wc_pagarme_transaction_id'])) {
                $mappedPayment['transaction_id'] = $metaData['_wc_pagarme_transaction_id'];
            }
        }
    }

    public function toRemote($localItem)
    {
        $mappedOrder = $this->mapData($localItem, 'remote');
        $mappedOrder = $this->mapMetaData($mappedOrder, $localItem['channel_name']);

        return $mappedOrder;
    }

    /**
     * @param array $mappedOrder
     * @param string $channelName
     * @return array
     * @throws \Exception
     */
    public function mapMetaData($mappedOrder, $channelName)
    {
        $customer = $mappedOrder['customer'];
        $email = $customer['email'];
        $cpfCnpj = $customer['cpf_cnpj'];

        return array_merge(
            $mappedOrder,
            [
                'customer' => array_merge($customer, [
                    'email' => $email ?: "{$cpfCnpj}@noemail.flyhub.com.br",
                    'username' => DataMapper::format($cpfCnpj, 'numbers'),
                    'password' => \Str::random(16),
                    'meta_data' => array_merge(
                        $customer['meta_data'],
                        [
                            ['key' => 'channel', 'value' => $channelName],
                            ['key' => 'billing_cpf', 'value' => $cpfCnpj],
                            ['key' => '_billing_cpf', 'value' => $cpfCnpj],
                        ]
                    ),
                ]),
                'meta_data' => array_merge(
                    $mappedOrder['meta_data'],
                    [
                        ['key' => 'channel', 'value' => $channelName],
                        ['key' => '_billing_cpf', 'value' => $cpfCnpj],
                    ]
                ),
            ],
        );
    }

    /** @return array  */
    public static function buildMapping()
    {
        return Resource::mapping(
            Resource::columns(
                Column::local('channel_name', 'WooCommerce'),
                /*******************************************************/
                Column::string('number',                    'remote_id'),
                Column::string('status',                    'status'),
                Column::string('customer.email',            'customer_email'),
                Column::concat(['customer.first_name', 'customer.last_name'], 'customer_name'),
                Column::double('discount_total',            'discount_amount'),
                Column::double('shipping_total',            'shipping_amount'),
                Column::double('total',                     'grand_total'),
                Column::double('total_tax',                 'tax_amount'),
                /*******************************************************/
                Column::remote('status', 'processing'),
                Column::remote('currency', 'BRL'),
                Column::remote('set_paid', true),
            ),
            Resource::relations(
                // CUSTOMER
                Resource::mapping(
                    Resource::local('customer'),
                    Resource::remote('customer'),
                    Resource::columns(
                        Column::string('id',            'remote_id'),
                        Column::string('persontype',    'type'),
                        Column::concat(['first_name', 'last_name'], 'name'),
                        Column::string('company',       'name'),
                        Column::string('phone',         'phone'),
                        Column::string('cellphone',     'cellphone'),
                        Column::string('cpf',           'cpf_cnpj'),
                        Column::string('rg',            'rg'),
                        Column::string('cnpj',          'cpf_cnpj'),
                        Column::string('ie',            'ie'),
                        Column::string('sex',           'gender'),
                        // Column::date('birthdate',       'birthdate'),
                        Column::string('email',         'email'),
                        Column::string('sex',           'gender'),
                    )
                ),
                // ORDER ITEMS
                Resource::mapping(
                    Resource::local('items', true),
                    Resource::remote('line_items', true),
                    Resource::columns(
                        Column::string('product_id',            'remote_product_id'),
                        Column::string('variation_id',          'remote_variation_id'),
                        Column::string('sku',                   'sku'),
                        Column::string('name',                  'name'),
                        Column::integer('quantity',             'qty_ordered'),
                        Column::double('price',                 'price'),
                        Column::double('total',                 'total'),
                    )
                ),
                // SHIPPING ADDRESS
                Resource::mapping(
                    Resource::local('shippingAddress'),
                    Resource::remote('shipping'),
                    Resource::columns(
                        Column::concat(['first_name', 'last_name'], 'name'),
                        Column::string('company',       'name'),
                        Column::string('address_1',    'street'),
                        Column::string('address_2',    'complement'),
                        Column::string('city',         'city'),
                        Column::string('state',        'state'),
                        Column::string('postcode',     'postcode'),
                        Column::string('country',      'country', 'BR'),
                        Column::string('number',       'number'),
                        Column::string('neighborhood', 'neighborhood'),
                    )
                ),
                // BILLING ADDRESS
                Resource::mapping(
                    Resource::local('billingAddress'),
                    Resource::remote('billing'),
                    Resource::columns(
                        Column::concat(['first_name', 'last_name'], 'name'),
                        Column::string('company',       'name'),
                        Column::string('address_1',     'street'),
                        Column::string('address_2',     'complement'),
                        Column::string('city',          'city'),
                        Column::string('state',         'state'),
                        Column::string('postcode',      'postcode'),
                        Column::string('country',       'country', 'BR'),
                        Column::string('email',         'email'),
                        Column::string('phone',         'phone'),
                        Column::string('number',        'number'),
                        Column::string('neighborhood',  'neighborhood'),
                    )
                ),
                // PAYMENTS
                Resource::mapping(
                    Resource::local('payments', true),
                    Resource::remote(null, false),
                    Resource::columns(
                        Column::string('payment_method',             'method'),
                        Column::string('payment_method_title',       'method_title'),
                        Column::double('transaction_id',             'transaction_id'),
                        Column::date('date_paid',                    'issued_date', null, 'Y-m-d\\TH:i:s'),
                        Column::date('meta_data.order_payment_date', 'issued_date', null, 'Y-m-d\\TH:i:s'),
                    ),
                ),
                // SHIPMENTS
                Resource::mapping(
                    Resource::local('shipments', true),
                    Resource::remote('shipping_lines', true),
                    Resource::columns(
                        Column::string('method_title',          'carrier'),
                        Column::string('method_id',             'method'),
                        Column::double('total',                 'total_price'),
                    ),
                ),
            ),
        );
    }
}
