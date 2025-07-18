<?php

namespace App\Integration\Channels\Magento\Mapping;

use App\Integration\Mapping\ResourceMapper;
use App\Integration\Mapping\Resource;
use App\Integration\Mapping\Column;

class OrderMapper extends ResourceMapper
{
    /**
     * @param \App\Models\Tenant\Channel $channel
     * @param array $configs
     */
    public function __construct($channel, $configs = null)
    {
        parent::__construct($channel, $configs, $this->buildMapping());
    }

    /** @return array  */
    public static function buildMapping()
    {
        return Resource::mapping(
            Resource::columns(
                Column::string('number', 'remote_id'),
                Column::string('status', 'status'),
                Column::double('discount_total', 'discount_amount'),
                Column::double('shipping_total', 'shipping_amount'),
                Column::double('total', 'grand_total'),
                Column::double('total_tax', 'tax_amount'),
                Column::concat(['first_name', 'last_name'], 'customer_name'),
                Column::string('cliente.email', 'customer_email'),
                /* --------------------------------------------- */
                Column::remote('currency', 'BRL'),
            ),
            Resource::relations(
                Resource::mapping(
                    Resource::local('customer'),
                    Resource::remote('customer'),
                    Resource::columns(
                        Column::string('email', 'email'),
                        Column::string('taxvat', 'cpf_cnpj'),
                        Column::string('dob', 'birthdate'),
                        Column::string('firstname', 'firstname'),
                        Column::string('lastname', 'lastname'),
                        Column::remote('website_id', '1'),
                        /* ----------------------------------- */
                        Column::remote('mode', 'guest'),
                        Column::remote('store_id', '1'),
                        Column::remote('group_id', '1'),
                    )
                ),
                Resource::mapping(
                    Resource::local('items', true),
                    Resource::remote('items', true),
                    Resource::columns(
                        Column::string('sku', 'sku'),
                        Column::string('name', 'name'),
                        Column::integer('qty', 'qty_ordered'),
                        Column::double('total', 'total'),
                        Column::double('total_tax', 'tax_amount'),
                        Column::double('price', 'price'),
                    )
                ),
                Resource::mapping(
                    Resource::local('shippingAddress'),
                    Resource::remote('shipping_address'),
                    Resource::columns(
                        Column::concat(['firstname', 'lastname'], 'name'),
                        Column::string('street', 'street'),
                        Column::string('city', 'city'),
                        Column::string('region', 'state'),
                        Column::string('country_id', 'country', 'BR'),
                        Column::string('telephone', 'phone'),
                        Column::string('postcode', 'postcode'),
                        /* --------------------------------------------- */
                        Column::remote('mode', 'shipping'),
                        Column::remote('is_default_shipping', 1, 'number'),
                        Column::remote('is_default_billing', 0, 'number'),
                    )
                ),
                Resource::mapping(
                    Resource::local('billingAddress'),
                    Resource::remote('billing_address'),
                    Resource::columns(
                        Column::concat(['firstname', 'lastname'], 'name'),
                        Column::string('company', 'name'),
                        Column::string('street', 'street'),
                        Column::string('city', 'city'),
                        Column::string('region', 'state'),
                        Column::string('country_id', 'country', 'BR'),
                        Column::string('telephone', 'phone'),
                        Column::string('postcode', 'postcode'),
                        /* --------------------------------------------- */
                        Column::remote('mode', 'billing'),
                        Column::remote('is_default_shipping', 0, 'number'),
                        Column::remote('is_default_billing', 1, 'number'),
                    )
                ),
                Resource::mapping(
                    Resource::local('payments', true),
                    Resource::remote('payment', false),
                    Resource::columns(
                        Column::string('payment_method_title', 'method'),
                        Column::date('date_paid', 'issued_date'),
                        Column::double('amount_ordered', 'total_paid'),
                        Column::double('shipping_amount', 'shipping_amount'),
                    )
                ),
            ),
            Resource::metadata([
                'attributes' => [
                    'color' => [
                        'slug' => 'color',
                        'name' => 'COR'
                    ],
                    'size' => [
                        'slug' => 'tamanho',
                        'name' => 'TAMANHO'
                    ],
                    'width' => [
                        'slug' => 'volume_largura',
                        'name' => 'VOLUME_LARGURA'
                    ],
                    'height' => [
                        'slug' => 'volume_altura',
                        'name' => 'VOLUME_ALTURA'
                    ],
                    'depth' => [
                        'slug' => 'volume_comprimento',
                        'name' => 'VOLUME_COMPRIMENTO'
                    ],
                    'gross_weight' => [
                        'slug' => 'weight',
                        'name' => 'WEIGHT'
                    ]
                ]
            ])
        );
    }
}
