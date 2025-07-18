<?php

namespace App\Integration\Channels\Magento2\Mapping;

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
                Column::string('increment_id', 'remote_id'),
                Column::string('status', 'status', 'pending'),
                // TOTALS
                Column::double('base_discount_amount', 'discount_amount'),
                Column::double('discount_amount', 'discount_amount'),
                Column::double('base_shipping_amount', 'shipping_amount'),
                Column::double('base_shipping_tax_amount', 'shipping_amount', 0),
                Column::double('base_shipping_incl_tax', 'shipping_amount'),
                Column::double('shipping_amount', 'shipping_amount'),
                Column::double('shipping_description', 'shipping_description'),
                Column::double('base_tax_amount', 'tax_amount'),
                Column::double('tax_amount', 'tax_amount'),
                Column::double('base_subtotal', 'sub_total'),
                Column::double('subtotal', 'sub_total'),
                Column::double('subtotal_incl_tax', 'sub_total'),
                Column::double('base_grand_total', 'grand_total'),
                Column::double('grand_total', 'grand_total'),
                // CUSTOMER
                Column::string('customer_email', 'customer_email'),
                Column::concat('customer_firstname', 'customer_firstname'),
                Column::concat('customer_lastname', 'customer_lastname'),
                Column::concat('customer_id', 'customer.remote_id'),
                Column::remote('customer_is_guest', 0),
                Column::remote('customer_note_notify', 0),
                Column::remote('email_sent', 0),
                Column::remote('is_virtual', 0),
                // FILL
                Column::remote('state', 'new'),
                Column::remote('order_currency_code', 'BRL'),
                Column::remote('base_currency_code', 'BRL'),
                Column::remote('store_currency_code', 'BRL'),
                Column::remote('is_virtual', 0),
                Column::remote('total_qty_ordered', 1),
                Column::remote('extension_attributes.shipping_assignments.shipping.method', 'flatrate_flatrate'),
            ),
            Resource::relations(
                // CUSTOMER
                Resource::mapping(
                    Resource::local('customer'),
                    Resource::remote('customer'),
                    Resource::columns(
                        Column::string('lastname', 'last_name', 'NULL'),
                        Column::string('firstname', 'first_name'),
                        Column::string('email', 'email'),
                        Column::string('taxvat', 'cpf_cnpj'),
                        Column::date('dob', 'birthdate', null,),
                        /* ----------------------------------- */
                        Column::remote('store_id', 1),
                        Column::remote('website_id', 1),
                    )
                ),
                // ITEMS
                Resource::mapping(
                    Resource::local('items', true),
                    Resource::remote('items', true),
                    Resource::columns(
                        Column::integer('product_id', 'remote_id', 35478),
                        Column::string('product_type', 'type', 'simple'),
                        Column::string('sku', 'sku'),
                        Column::string('name', 'name'),
                        Column::double('base_original_price', 'price'),
                        Column::double('base_price', 'price'),
                        Column::double('base_price_incl_tax', 'price'),
                        Column::double('base_row_total', 'total'),
                        Column::double('base_row_total_incl_tax', 'total'),
                        Column::double('base_tax_amount', 'tax_amount'),
                        Column::double('original_price', 'price'),
                        Column::double('price', 'price'),
                        Column::double('price_incl_tax', 'price'),
                        Column::integer('qty_ordered', 'qty_ordered'),
                        Column::double('base_discount_amount', 'discount_amount'),
                        Column::double('discount_amount', 'discount_amount'),
                        Column::double('row_total', 'total'),
                        Column::double('row_total_incl_tax', 'total'),
                        Column::double('tax_amount', 'tax_amount'),
                        Column::remote('store_id', 1),
                    )
                ),
                // BILLING ADDRESS
                Resource::mapping(
                    Resource::local('billingAddress'),
                    Resource::remote('billing_address'),
                    Resource::columns(
                        Column::string('firstname', 'name'),
                        Column::string('lastname', 'name'),
                        //Column::string('company', 'first_name'),
                        Column::string('street', 'street'),
                        Column::string('city', 'city'),
                        Column::string('region', 'state'),
                        Column::string('country_id', 'country', 'BR'),
                        Column::string('telephone', 'phone'),
                        Column::string('postcode', 'postcode'),
                        Column::string('email', 'email'),
                        /* --------------------------------------------- */
                        Column::remote('address_type', 'billing'),
                    )
                ),
                // SHIPPING ADDRESS
                Resource::mapping(
                    Resource::local('shippingAddress'),
                    Resource::remote('extension_attributes.shipping_assignments.shipping.address'),
                    Resource::columns(
                        Column::string('firstname', 'name'),
                        Column::string('lastname', 'name'),
                        //Column::string('company', 'first_name'),
                        Column::string('street', 'street'),
                        Column::string('city', 'city'),
                        Column::string('region', 'state'),
                        Column::string('country_id', 'country', 'BR'),
                        Column::string('telephone', 'phone'),
                        Column::string('postcode', 'postcode'),
                        Column::string('email', 'email'),
                        /* --------------------------------------------- */
                        Column::remote('address_type', 'shipping'),
                    )
                ),
                // PAYMENT
                Resource::mapping(
                    Resource::local('payments', true),
                    Resource::remote('payment', false),
                    Resource::columns(
                        Column::double('amount_ordered', 'total_paid'),
                        Column::double('amount_paid', 'total_paid'),
                        Column::double('base_amount_ordered', 'total_paid'),
                        Column::double('base_amount_paid', 'total_paid'),
                        Column::double('shipping_amount', 'total_paid'),
                        Column::string('method', 'method', 'checkmo'),
                    )
                ),
            ),
        );
    }
}
