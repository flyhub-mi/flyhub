<?php

namespace App\Integration\Channels\Vendure;

use App\Integration\ChannelApi;
use GraphQL\Client;

use function _\first;

class Api extends ChannelApi
{
    protected $client;

    /**
     * Api constructor.
     * @param array $url
     */
    function __construct($configs)
    {
        $response = $this->login($configs['url'], $configs['username'], $configs['password']);
        $responseObject = $response->getResponseObject();

        $authorizationHeaders = [
            'channel-token' => first($response->getData()['login']['channels'])['token'],
            'Cookie' => implode('; ', $responseObject->getHeader('Set-Cookie')),
        ];

        $this->client = new Client($configs['url'], $authorizationHeaders);
    }

    /**
     * @param string $url
     * @param string $username
     * @param string $password
     * @param boolean $rememberMe
     * @return void
     */
    public function login($url, $username, $password, $rememberMe = false)
    {
        $gql = '
            mutation AttemptLogin($username: String!, $password: String!, $rememberMe: Boolean!) {
                login(username: $username, password: $password, rememberMe: $rememberMe) {
                    ...CurrentUser
                    ...ErrorResult
                    __typename
                }
            }

            fragment CurrentUser on CurrentUser {
                id
                identifier
                channels {
                    id
                    code
                    token
                    permissions
                    __typename
                }
                __typename
            }

            fragment ErrorResult on ErrorResult {
                errorCode
                message
                __typename
            }
        ';

        return (new Client($url))->runRawQuery($gql, true, [
            'username' => $username,
            'password' => $password,
            'rememberMe' => false,
        ]);
    }

    /**
     * @return array
     */
    public function paginationInfo()
    {
        return 1;
    }

    /**
     * @param int $pg
     * @return array
     */
    public function getCollection($pg)
    {
        $gql = '
            query GetCollectionList($options: CollectionListOptions) {
                    collections(options: $options) {
                    items {
                        ...CollectionForList
                        __typename
                    }
                    totalItems
                    __typename
                }
            }

            fragment CollectionForList on Collection {
                id
                name
                slug
                position
                isPrivate
                parentId
                children {
                    id
                    name
                    slug
                    position
                    isPrivate
                    parentId
                    __typename
                }
                __typename
            }
        ';

        return $this->client->runRawQuery($gql, true, [
            'options' => [
                'filter' => [
                    'name' => [
                        'contains' => ''
                    ]
                ],
                'skip' => $this->calculateSkip($pg),
                'sort' => [
                    'position' => 'ASC'
                ],
                'take' => 10,
                'topLevelOnly' => true
            ]
        ])->getData()['collections']['items'];
    }

    /**
     * @param [type] $pg
     * @param [type] $lastReceivedAt
     * @return array
     */
    public function getProducts($pg, $lastReceivedAt)
    {
        $gql = '
            query ProductListQuery($options: ProductListOptions) {
                products(options: $options) {
                    items {
                        ...ProductListQueryProductFragment
                        __typename
                    }
                    totalItems
                    __typename
                }
            }

            fragment ProductListQueryProductFragment on Product {
                id
                updatedAt
                name
                slug
                description
                enabled
                assets {
                    id
                    source
                    type
                    __typename
                }
                variants {
                    id
                    updatedAt
                    sku
                    name
                    enabled
                    stockOnHand
                    assets {
                        id
                        source
                        type
                        __typename
                    }
                    __typename
                }
                customFields {
                    weight
                    length
                    height
                    width
                    massUnit
                    distanceUnit
                    __typename
                }
                collections {
                    id
                    name
                    parentId
                    __typename
                }
                __typename
            }
        ';

        $variables = [
            'options' => [
                'filterOperator' => 'AND',
                'skip' => $this->calculateSkip($pg),
                'sort' => [
                    'createdAt' => 'DESC'
                ],
                'take' => 10
            ]
        ];

        if (!is_null($lastReceivedAt)) {
            $variables['options']['filter'] = [
                'updatedAt' => [
                    'after' => $lastReceivedAt
                ]
            ];
        }

        return $this->client->runRawQuery($gql, true, $variables)->getData()['products']['items'];
    }

    /**
     * @param array $product
     * @return array
     */
    public function createProduct($product)
    {
        $gql = '
            mutation CreateProduct($input: CreateProductInput!, $variantListOptions: ProductVariantListOptions) {
                createProduct(input: $input) {
                    ...ProductDetail
                    variantList(options: $variantListOptions) {
                        items {
                            ...ProductVariant
                            __typename
                        }
                        totalItems
                        __typename
                    }
                    __typename
                }
            }

            fragment ProductDetail on Product {
                id
                createdAt
                updatedAt
                enabled
                languageCode
                name
                slug
                description
                featuredAsset {
                    ...Asset
                    __typename
                }
                assets {
                    ...Asset
                    __typename
                }
                translations {
                    id
                    languageCode
                    name
                    slug
                    description
                    __typename
                }
                optionGroups {
                    ...ProductOptionGroup
                    __typename
                }
                facetValues {
                    id
                    code
                    name
                    facet {
                    id
                    name
                    __typename
                    }
                    __typename
                }
                channels {
                    id
                    code
                    __typename
                }
                customFields {
                    weight
                    length
                    height
                    width
                    massUnit
                    distanceUnit
                    __typename
                }
                __typename
            }

            fragment ProductOptionGroup on ProductOptionGroup {
                id
                createdAt
                updatedAt
                code
                languageCode
                name
                translations {
                    id
                    languageCode
                    name
                    __typename
                }
                __typename
            }

            fragment Asset on Asset {
                id
                createdAt
                updatedAt
                name
                fileSize
                mimeType
                type
                preview
                source
                width
                height
                focalPoint {
                    x
                    y
                    __typename
                }
                __typename
            }

            fragment ProductVariant on ProductVariant {
                id
                createdAt
                updatedAt
                enabled
                languageCode
                name
                price
                currencyCode
                priceWithTax
                stockOnHand
                stockAllocated
                trackInventory
                outOfStockThreshold
                useGlobalOutOfStockThreshold
                taxRateApplied {
                    id
                    name
                    value
                    __typename
                }
                taxCategory {
                    id
                    name
                    __typename
                }
                sku
                options {
                    ...ProductOption
                    __typename
                }
                facetValues {
                    id
                    code
                    name
                    facet {
                    id
                    name
                    __typename
                    }
                    __typename
                }
                featuredAsset {
                    ...Asset
                    __typename
                }
                assets {
                    ...Asset
                    __typename
                }
                translations {
                    id
                    languageCode
                    name
                    __typename
                }
                channels {
                    id
                    code
                    __typename
                }
                __typename
            }

            fragment ProductOption on ProductOption {
                id
                createdAt
                updatedAt
                code
                languageCode
                name
                groupId
                translations {
                    id
                    languageCode
                    name
                    __typename
                }
                __typename
            }
        ';

        $variables = [
            "input" => [
                "customFields" => [
                    "distanceUnit" => "cm",
                    "height" => 1,
                    "length" => 1,
                    "massUnit" => "kg",
                    "weight" => 1,
                    "width" => 1
                ],
                "enabled" => true,
                "facetValueIds" => [],
                "translations" => [
                    [
                        "description" => "",
                        "languageCode" => "pt_BR",
                        "name" => "Teste",
                        "slug" => "teste"
                    ]
                ]
            ]
        ];

        return $this->client->runRawQuery($gql, true, $variables)->getData()['createProduct'];
    }

    /**
     * @param array $product
     * @return array
     */
    public function createProductVariant($product)
    {
        $gql = '
            mutation CreateProductVariants($input: [CreateProductVariantInput!]!) {
                createProductVariants(input: $input) {
                    ...ProductVariant
                    __typename
                }
            }

            fragment ProductVariant on ProductVariant {
                id
                createdAt
                updatedAt
                enabled
                languageCode
                name
                price
                currencyCode
                priceWithTax
                stockOnHand
                stockAllocated
                trackInventory
                outOfStockThreshold
                useGlobalOutOfStockThreshold
                taxRateApplied {
                    id
                    name
                    value
                    __typename
                }
                taxCategory {
                    id
                    name
                    __typename
                }
                sku
                options {
                    ...ProductOption
                    __typename
                }
                facetValues {
                    id
                    code
                    name
                    facet {
                    id
                    name
                    __typename
                    }
                    __typename
                }
                featuredAsset {
                    ...Asset
                    __typename
                }
                assets {
                    ...Asset
                    __typename
                }
                translations {
                    id
                    languageCode
                    name
                    __typename
                }
                channels {
                    id
                    code
                    __typename
                }
                __typename
            }

            fragment ProductOption on ProductOption {
                id
                createdAt
                updatedAt
                code
                languageCode
                name
                groupId
                translations {
                    id
                    languageCode
                    name
                    __typename
                }
                __typename
            }

            fragment Asset on Asset {
                id
                createdAt
                updatedAt
                name
                fileSize
                mimeType
                type
                preview
                source
                width
                height
                focalPoint {
                    x
                    y
                    __typename
                }
                __typename
            }
        ';

        $variables = [
            "input" => [
                [
                    "optionIds" => [],
                    "price" => 2000,
                    "productId" => "9",
                    "sku" => "teste-m",
                    "stockLevels" => [
                        [
                            "stockLocationId" => "1",
                            "stockOnHand" => 55
                        ]
                    ],
                    "translations" => [
                        [
                            "languageCode" => "pt_BR",
                            "name" => "Teste"
                        ]
                    ]
                ]
            ]
        ];

        return $this->client->runRawQuery($gql, true, $variables)->getData()['createProduct'];
    }

    /**
     * @param array $product
     * @return array
     */
    public function updateProduct($product)
    {
        $gql = '
            mutation UpdateProduct($input: UpdateProductInput!, $variantListOptions: ProductVariantListOptions) {
                updateProduct(input: $input) {
                    ...ProductDetail
                    variantList(options: $variantListOptions) {
                    items {
                        ...ProductVariant
                        __typename
                    }
                    totalItems
                    __typename
                    }
                    __typename
                }
            }

            fragment ProductDetail on Product {
                id
                createdAt
                updatedAt
                enabled
                languageCode
                name
                slug
                description
                featuredAsset {
                    ...Asset
                    __typename
                }
                assets {
                    ...Asset
                    __typename
                }
                translations {
                    id
                    languageCode
                    name
                    slug
                    description
                    __typename
                }
                optionGroups {
                    ...ProductOptionGroup
                    __typename
                }
                facetValues {
                    id
                    code
                    name
                    facet {
                    id
                    name
                    __typename
                    }
                    __typename
                }
                channels {
                    id
                    code
                    __typename
                }
                customFields {
                    weight
                    length
                    height
                    width
                    massUnit
                    distanceUnit
                    __typename
                }
                __typename
            }

            fragment ProductOptionGroup on ProductOptionGroup {
                id
                createdAt
                updatedAt
                code
                languageCode
                name
                translations {
                    id
                    languageCode
                    name
                    __typename
                }
                __typename
            }

            fragment Asset on Asset {
                id
                createdAt
                updatedAt
                name
                fileSize
                mimeType
                type
                preview
                source
                width
                height
                focalPoint {
                    x
                    y
                    __typename
                }
                __typename
            }

            fragment ProductVariant on ProductVariant {
                id
                createdAt
                updatedAt
                enabled
                languageCode
                name
                price
                currencyCode
                priceWithTax
                stockOnHand
                stockAllocated
                trackInventory
                outOfStockThreshold
                useGlobalOutOfStockThreshold
                taxRateApplied {
                    id
                    name
                    value
                    __typename
                }
                taxCategory {
                    id
                    name
                    __typename
                }
                sku
                options {
                    ...ProductOption
                    __typename
                }
                facetValues {
                    id
                    code
                    name
                    facet {
                    id
                    name
                    __typename
                    }
                    __typename
                }
                featuredAsset {
                    ...Asset
                    __typename
                }
                assets {
                    ...Asset
                    __typename
                }
                translations {
                    id
                    languageCode
                    name
                    __typename
                }
                channels {
                    id
                    code
                    __typename
                }
                __typename
            }

            fragment ProductOption on ProductOption {
                id
                createdAt
                updatedAt
                code
                languageCode
                name
                groupId
                translations {
                    id
                    languageCode
                    name
                    __typename
                }
                __typename
            }
        ';

        $variables = [
            "input" => [
                "assetIds" => [
                    "15"
                ],
                "customFields" => [
                    "distanceUnit" => "cm",
                    "height" => 10,
                    "length" => 10,
                    "massUnit" => "kg",
                    "weight" => 1,
                    "width" => 10
                ],
                "enabled" => true,
                "facetValueIds" => [],
                "featuredAssetId" => "15",
                "id" => "9",
                "translations" => [
                    [
                        "customFields" => [],
                        "description" => "<p>Teste</p>",
                        "id" => "9",
                        "languageCode" => "pt_BR",
                        "name" => "Teste",
                        "slug" => "Teste"
                    ]
                ]
            ]
        ];

        return $this->client->runRawQuery($gql, true, $variables)->getData()['createProduct'];
    }

    /**
     * @param array $product
     * @return array
     */
    public function updateProductVariant($product)
    {
        $gql = '
            mutation ProductVariantUpdateMutation($input: [UpdateProductVariantInput!]!) {
                updateProductVariants(input: $input) {
                    ...ProductVariantDetailQueryProductVariantFragment
                    __typename
                }
            }

            fragment ProductOption on ProductOption {
                id
                createdAt
                updatedAt
                code
                languageCode
                name
                groupId
                translations {
                    id
                    languageCode
                    name
                    __typename
                }
                __typename
            }

            fragment Asset on Asset {
                id
                createdAt
                updatedAt
                name
                fileSize
                mimeType
                type
                preview
                source
                width
                height
                focalPoint {
                    x
                    y
                    __typename
                }
                __typename
            }

            fragment ProductVariantDetailQueryProductVariantFragment on ProductVariant {
                id
                createdAt
                updatedAt
                enabled
                languageCode
                name
                price
                currencyCode
                prices {
                    price
                    currencyCode
                    __typename
                }
                priceWithTax
                stockOnHand
                stockAllocated
                trackInventory
                outOfStockThreshold
                useGlobalOutOfStockThreshold
                taxRateApplied {
                    id
                    name
                    value
                    __typename
                }
                taxCategory {
                    id
                    name
                    __typename
                }
                sku
                options {
                    ...ProductOption
                    __typename
                }
                stockLevels {
                    id
                    createdAt
                    updatedAt
                    stockOnHand
                    stockAllocated
                    stockLocationId
                    stockLocation {
                    id
                    createdAt
                    updatedAt
                    name
                    __typename
                    }
                    __typename
                }
                facetValues {
                    id
                    code
                    name
                    facet {
                    id
                    name
                    __typename
                    }
                    __typename
                }
                featuredAsset {
                    ...Asset
                    __typename
                }
                assets {
                    ...Asset
                    __typename
                }
                translations {
                    id
                    languageCode
                    name
                    __typename
                }
                channels {
                    id
                    code
                    __typename
                }
                product {
                    id
                    name
                    optionGroups {
                    id
                    name
                    code
                    translations {
                        id
                        languageCode
                        name
                        __typename
                    }
                    __typename
                    }
                    __typename
                }
                __typename
            }
        ';

        $variables = [
            "input" => [
                [
                    "assetIds" => [
                        "15"
                    ],
                    "customFields" => [],
                    "enabled" => true,
                    "facetValueIds" => [],
                    "featuredAssetId" => "15",
                    "id" => "19",
                    "outOfStockThreshold" => 0,
                    "sku" => "teste-m",
                    "stockLevels" => [
                        [
                            "stockLocationId" => "1",
                            "stockOnHand" => 56
                        ]
                    ],
                    "taxCategoryId" => "1",
                    "trackInventory" => "INHERIT",
                    "translations" => [
                        [
                            "customFields" => [],
                            "id" => "19",
                            "languageCode" => "pt_BR",
                            "name" => "Teste"
                        ]
                    ],
                    "useGlobalOutOfStockThreshold" => true
                ]
            ]
        ];

        return $this->client->runRawQuery($gql, true, $variables)->getData()['createProduct'];
    }

    /**
     * @param array $asset
     * @return void
     */
    public function createAssets($asset)
    {
        $gql = '
            mutation CreateAssets($input: [CreateAssetInput!]!) {
                createAssets(input: $input) {
                    ...Asset
                    ... on Asset {
                    tags {
                        ...Tag
                        __typename
                    }
                    __typename
                    }
                    ... on ErrorResult {
                    message
                    __typename
                    }
                    __typename
                }
            }

            fragment Asset on Asset {
                id
                createdAt
                updatedAt
                name
                fileSize
                mimeType
                type
                preview
                source
                width
                height
                focalPoint {
                    x
                    y
                    __typename
                }
                __typename
            }

            fragment Tag on Tag {
                id
                value
                __typename
            }

        ';

        $variables = [
            "input" => [
                "file" => ""
            ]
        ];

        return $this->client->runRawQuery($gql, true, $variables)->getData()['createAssets'];
    }


    /**
     * @param [type] $pg
     * @param [type] $lastReceivedAt
     * @return array
     */
    public function getOrders($pg, $lastReceivedAt)
    {
        $gql = '
           query GetOrderList($options: OrderListOptions) {
                orders(options: $options) {
                    items {
                    ...Order
                    __typename
                    }
                    totalItems
                    __typename
                }
            }

            fragment OrderAddress on OrderAddress {
                fullName
                company
                streetLine1
                streetLine2
                city
                province
                postalCode
                country
                countryCode
                phoneNumber
                __typename
            }

            fragment PaymentWithRefunds on Payment {
                id
                createdAt
                updatedAt
                transactionId
                amount
                method
                state
                nextStates
                errorMessage
                metadata
                refunds {
                    id
                    createdAt
                    state
                    items
                    adjustment
                    total
                    paymentId
                    reason
                    transactionId
                    method
                    metadata
                    lines {
                    orderLineId
                    quantity
                    __typename
                    }
                    __typename
                }
                __typename
            }

            fragment Order on Order {
                id
                createdAt
                updatedAt
                type
                orderPlacedAt
                code
                state
                nextStates
                active
                total
                totalWithTax
                currencyCode
                customer {
                    id
                    firstName
                    lastName
                    emailAddress
                    __typename
                }
                lines {
                    ...OrderLine
                    __typename
                }
                shippingLines {
                    shippingMethod {
                    name
                    __typename
                    }
                    __typename
                }
                shippingAddress {
                    ...OrderAddress
                    __typename
                }
                billingAddress {
                    ...OrderAddress
                    __typename
                }
                payments {
                    ...PaymentWithRefunds
                    __typename
                }
                __typename
            }
        ';

        $variables = [
            'options' => [
                'filterOperator' => 'AND',
                'skip' => $this->calculateSkip($pg),
                'sort' => [
                    'updatedAt' => 'DESC'
                ],
                'take' => 10
            ]
        ];

        if (!is_null($lastReceivedAt)) {
            $variables['options']['filter'] = [
                'updatedAt' => [
                    'after' => $lastReceivedAt
                ]
            ];
        }

        return $this->client->runRawQuery($gql, true, $variables)->getData()['products']['items'];
    }

    /**
     * @param array $order
     * @return array
     */
    public function createOrders($order)
    {
        $gql = '
            mutation CreateDraftOrder {
                createDraftOrder {
                    ...OrderDetail
                    __typename
                }
            }

            fragment OrderDetail on Order {
                id
                createdAt
                updatedAt
                type
                aggregateOrder {
                    id
                    code
                    __typename
                }
                sellerOrders {
                    id
                    code
                    channels {
                    id
                    code
                    __typename
                    }
                    __typename
                }
                code
                state
                nextStates
                active
                couponCodes
                customer {
                    id
                    firstName
                    lastName
                    __typename
                }
                lines {
                    ...OrderLine
                    __typename
                }
                surcharges {
                    id
                    sku
                    description
                    price
                    priceWithTax
                    taxRate
                    __typename
                }
                discounts {
                    ...Discount
                    __typename
                }
                promotions {
                    id
                    couponCode
                    __typename
                }
                subTotal
                subTotalWithTax
                total
                totalWithTax
                currencyCode
                shipping
                shippingWithTax
                shippingLines {
                    id
                    discountedPriceWithTax
                    shippingMethod {
                        id
                        code
                        name
                        fulfillmentHandlerCode
                        description
                        __typename
                    }
                    __typename
                }
                taxSummary {
                    description
                    taxBase
                    taxRate
                    taxTotal
                    __typename
                }
                shippingAddress {
                    ...OrderAddress
                    __typename
                }
                billingAddress {
                    ...OrderAddress
                    __typename
                }
                payments {
                    ...PaymentWithRefunds
                    __typename
                }
                fulfillments {
                    ...Fulfillment
                    __typename
                }
                modifications {
                    id
                    createdAt
                    isSettled
                    priceChange
                    note
                    payment {
                        id
                        amount
                        __typename
                    }
                    lines {
                        orderLineId
                        quantity
                        __typename
                    }
                    refund {
                        id
                        paymentId
                        total
                        __typename
                    }
                    surcharges {
                        id
                        __typename
                    }
                    __typename
                }
                __typename
            }

            fragment Discount on Discount {
                adjustmentSource
                amount
                amountWithTax
                description
                type
                __typename
            }

            fragment OrderAddress on OrderAddress {
                fullName
                company
                streetLine1
                streetLine2
                city
                province
                postalCode
                country
                countryCode
                phoneNumber
                __typename
            }

            fragment Fulfillment on Fulfillment {
                id
                state
                nextStates
                createdAt
                updatedAt
                method
                lines {
                    orderLineId
                    quantity
                    __typename
                }
                trackingCode
                __typename
            }

            fragment OrderLine on OrderLine {
                id
                createdAt
                updatedAt
                featuredAsset {
                    preview
                    __typename
                }
                productVariant {
                    id
                    name
                    sku
                    trackInventory
                    stockOnHand
                    __typename
                }
                discounts {
                    ...Discount
                    __typename
                }
                fulfillmentLines {
                    fulfillmentId
                    quantity
                    __typename
                }
                unitPrice
                unitPriceWithTax
                proratedUnitPrice
                proratedUnitPriceWithTax
                quantity
                orderPlacedQuantity
                linePrice
                lineTax
                linePriceWithTax
                discountedLinePrice
                discountedLinePriceWithTax
                __typename
            }

            fragment PaymentWithRefunds on Payment {
                id
                createdAt
                transactionId
                amount
                method
                state
                nextStates
                errorMessage
                metadata
                refunds {
                    id
                    createdAt
                    state
                    items
                    adjustment
                    total
                    paymentId
                    reason
                    transactionId
                    method
                    metadata
                    lines {
                    orderLineId
                    quantity
                    __typename
                    }
                    __typename
                }
                __typename
            }
        ';

        $variables = [
            "input" => [
                "customFields" => [
                    "distanceUnit" => "cm",
                    "height" => 1,
                    "length" => 1,
                    "massUnit" => "kg",
                    "weight" => 1,
                    "width" => 1
                ],
                "enabled" => true,
                "facetValueIds" => [],
                "translations" => [
                    [
                        "description" => "",
                        "languageCode" => "pt_BR",
                        "name" => "Teste",
                        "slug" => "teste"
                    ]
                ]
            ]
        ];

        return $this->client->runRawQuery($gql, true, $variables)->getData()['createProduct'];
    }

    /**
     * @param int $pg
     * @return void
     */
    private function calculateSkip($pg)
    {
        return $pg > 1 ? ($pg - 1) * 10 : 0;
    }
}
