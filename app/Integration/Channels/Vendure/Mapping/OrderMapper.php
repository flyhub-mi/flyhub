<?php

namespace App\Integration\Channels\Vendure\Mapping;

use App\Integration\Mapping\ResourceMapper;
use App\Integration\Mapping\Resource;
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

        return $mappedData;
    }

    public function toRemote($localItem)
    {
        $mappedOrder = $this->mapData($localItem, 'remote');

        return $mappedOrder;
    }

    /** @return array  */
    public static function buildMapping()
    {
        return Resource::mapping(
            Resource::columns(
                Column::local('channel_name', 'Vendure'),
                /*******************************************************/
                Column::string('code',                      'remote_id'),
                Column::string('state',                     'status'),
                Column::string('customer.emailAddress',     'customer_email'),
                Column::concat(['customer.firstName', 'customer.lastName'], 'customer_name'),
                // Column::double('discount_total',            'discount_amount'),
                Column::double('shippingWithTax',           'shipping_amount'),
                Column::double('total',                     'grand_total'),
                Column::double('totalWithTax',              'tax_amount'),
            ),
            Resource::relations(
                // CUSTOMER
                Resource::mapping(
                    Resource::local('customer'),
                    Resource::remote('customer'),
                    Resource::columns(
                        Column::string('id',                 'remote_id'),
                        Column::string('persontype',         'type'),
                        Column::concat(['firstName', 'lastName'], 'name'),
                        Column::string('company',            'name'),
                        Column::string('phoneNumber',        'phone'),
                        Column::string('customFields.cpf',   'cpf_cnpj'),
                        Column::string('customFields.rg',    'rg'),
                        Column::string('customFields.cnpj',  'cpf_cnpj'),
                        Column::string('customFields.ie',    'ie'),
                        Column::string('customFields.gender', 'gender'),
                        // Column::date('birthdate',       'birthdate'),
                        Column::string('emailAddress',         'email'),
                    )
                ),
                // ORDER ITEMS
                Resource::mapping(
                    Resource::local('items', true),
                    Resource::remote('line_items', true),
                    Resource::columns(
                        Column::string('productVariant.productId', 'remote_product_id'),
                        Column::string('variation_id',          'remote_variation_id'),
                        Column::string('productVariant.sku',                   'sku'),
                        Column::string('productVariant.name',                  'name'),
                        Column::integer('quantity',             'qty_ordered'),
                        Column::double('unitPriceWithTax',                 'price'),
                        Column::double('linePriceWithTax',                 'total'),
                    )
                ),
                // SHIPPING ADDRESS
                Resource::mapping(
                    Resource::local('shippingAddress'),
                    Resource::remote('shipping'),
                    Resource::columns(
                        Column::concat('fullName', 'name'),
                        Column::string('company',       'name'),
                        Column::string('streetLine1',    'street'),
                        Column::string('streetLine2',    'number'),
                        Column::string('city',         'city'),
                        Column::string('province',        'state'),
                        Column::string('postalCode',     'postcode'),
                        Column::string('countryCode',      'country', 'BR'),
                    )
                ),
                // BILLING ADDRESS
                Resource::mapping(
                    Resource::local('billingAddress'),
                    Resource::remote('billing'),
                    Resource::columns(
                        Column::concat('fullName', 'name'),
                        Column::string('company',       'name'),
                        Column::string('streetLine1',    'street'),
                        Column::string('streetLine2',    'number'),
                        Column::string('city',         'city'),
                        Column::string('province',        'state'),
                        Column::string('postalCode',     'postcode'),
                        Column::string('countryCode',      'country', 'BR'),
                    )
                ),
                // PAYMENTS
                Resource::mapping(
                    Resource::local('payments', true),
                    Resource::remote(null, false),
                    Resource::columns(
                        Column::string('method',             'method'),
                        Column::string('method',             'method_title'),
                        Column::double('transactionId',      'transaction_id'),
                        Column::date('updatedAt',            'issued_date', null, 'Y-m-d\\TH:i:s'),
                    ),
                ),
                // SHIPMENTS
                Resource::mapping(
                    Resource::local('shipments', true),
                    Resource::remote('shippingLines', true),
                    Resource::columns(
                        Column::string('shippingMethod.name',          'carrier'),
                        Column::string('shippingMethod.code',          'method'),
                        Column::double('priceWithTax',                 'total_price'),
                    ),
                ),
            ),
        );
    }
}
