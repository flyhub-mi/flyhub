<?php

namespace App\Integration\Channels\Medusa\Mapping;

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
                Column::local('channel_name', 'Medusa'),
                /*******************************************************/
                Column::string('id',                    'remote_id'),
                Column::string('status',                    'status'),
                Column::string('email',            'customer_email'),
                Column::concat(['customer.first_name', 'customer.last_name'], 'customer_name'),
                Column::double('discount_total',            'discount_amount'),
                Column::double('shipping_total',            'shipping_amount'),
                Column::double('total',                     'grand_total'),
                Column::double('tax_total',                 'tax_amount'),
                /*******************************************************/
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
                        Column::concat(['first_name', 'last_name'], 'name'),
                        Column::string('company',       'name'),
                        Column::string('phone',         'phone'),
                        Column::string('email',         'email'),
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
                        Column::string('title',                 'name'),
                        Column::integer('quantity',             'qty_ordered'),
                        Column::double('unit_price',            'price'),
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
                        Column::string('province',        'state'),
                        Column::string('postal_code',     'postcode'),
                        Column::string('country_code',      'country', 'BR'),
                    )
                ),
                // BILLING ADDRESS
                Resource::mapping(
                    Resource::local('billingAddress'),
                    Resource::remote('billing'),
                    Resource::columns(
                        Column::concat(['first_name', 'last_name'], 'name'),
                        Column::string('company',       'name'),
                        Column::string('address_1',    'street'),
                        Column::string('address_2',    'complement'),
                        Column::string('city',         'city'),
                        Column::string('province',        'state'),
                        Column::string('postal_code',     'postcode'),
                        Column::string('country_code',      'country', 'BR'),
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
