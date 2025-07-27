# Mapping System - Practical Examples

This file contains practical examples of how to use the Mapping system for real-world scenarios. You can copy and adapt these examples for your own integrations.

## Quick Start Example

```php
<?php

use App\Integration\Mapping\Resource;
use App\Integration\Mapping\Column;
use App\Integration\Mapping\ResourceMapper;

// Simple product mapping
$simpleProductMapping = Resource::mapping(
    Resource::local('products'),
    Resource::remote('products'),
    Resource::columns(
        Column::integer('id', 'external_id', 0),
        Column::string('name', 'title', ''),
        Column::string('description', 'description', ''),
        Column::double('price', 'price', 0.0),
        Column::integer('stock', 'stock_quantity', 0),
        Column::string('status', 'status', 'draft')
    )
);

// Usage
$mapper = new ResourceMapper('woocommerce', $simpleProductMapping);

// API data to local
$apiData = [
    'id' => 123,
    'name' => 'Sample Product',
    'price' => '29.99',
    'stock' => 50
];

$localData = $mapper->toLocal($apiData);
// Result: ['external_id' => 123, 'title' => 'Sample Product', 'price' => 29.99, 'stock_quantity' => 50, ...]

// Local data to API
$localData = [
    'title' => 'Local Product',
    'price' => 39.99,
    'stock_quantity' => 25
];

$apiData = $mapper->toRemote($localData);
// Result: ['name' => 'Local Product', 'price' => 39.99, 'stock' => 25, ...]
```

## WooCommerce Integration Examples

### Product Mapping (Complete)

```php
<?php

use App\Integration\Mapping\Resource;
use App\Integration\Mapping\Column;

$wooProductMapping = Resource::mapping(
    Resource::local('products'),
    Resource::remote('products'),
    Resource::columns(
        // Basic Information
        Column::integer('id', 'woo_id', 0),
        Column::string('name', 'title', ''),
        Column::string('description', 'description', ''),
        Column::string('short_description', 'short_description', ''),
        Column::string('slug', 'slug', ''),
        
        // Pricing
        Column::double('price', 'sale_price', 0.0),
        Column::double('regular_price', 'regular_price', 0.0),
        Column::double('sale_price', 'sale_price', 0.0),
        
        // Inventory
        Column::integer('stock_quantity', 'stock_quantity', 0),
        Column::string('stock_status', 'stock_status', 'instock'),
        Column::boolean('manage_stock', 'manage_stock', false),
        Column::integer('low_stock_amount', 'low_stock_threshold', 0),
        
        // Status
        Column::string('status', 'status', 'draft'),
        Column::boolean('catalog_visibility', 'is_visible', true),
        Column::boolean('featured', 'is_featured', false),
        
        // Categories and Tags
        Column::array('categories', 'category_ids', []),
        Column::array('tags', 'tag_ids', []),
        
        // Images
        Column::string('images.0.src', 'featured_image', ''),
        Column::array('images', 'gallery_images', []),
        
        // Meta Fields (common WooCommerce meta)
        Column::string('meta_data.0.value', 'sku', ''),
        Column::string('meta_data.1.value', 'weight', ''),
        Column::string('meta_data.2.value', 'length', ''),
        Column::string('meta_data.3.value', 'width', ''),
        Column::string('meta_data.4.value', 'height', ''),
        
        // Dates
        Column::date('date_created', 'created_at', '', 'Y-m-d H:i:s'),
        Column::date('date_modified', 'updated_at', '', 'Y-m-d H:i:s'),
        
        // Generated Fields
        Column::concat(['name', 'sku'], 'display_name', '', ' - '),
        Column::sku(['name', 'id'], 'generated_sku')
    ),
    Resource::relations(
        // Category mapping
        Resource::mapping(
            Resource::local('categories'),
            Resource::remote('categories'),
            Resource::columns(
                Column::integer('id', 'woo_category_id', 0),
                Column::string('name', 'name', ''),
                Column::string('slug', 'slug', ''),
                Column::string('description', 'description', ''),
                Column::integer('parent', 'parent_id', 0),
                Column::string('image.src', 'image_url', '')
            )
        )
    )
);
```

### Order Mapping (Complete)

```php
<?php

$wooOrderMapping = Resource::mapping(
    Resource::local('orders'),
    Resource::remote('orders'),
    Resource::columns(
        // Order Information
        Column::integer('id', 'woo_order_id', 0),
        Column::string('number', 'order_number', ''),
        Column::string('status', 'status', 'pending'),
        Column::string('currency', 'currency', 'USD'),
        
        // Totals
        Column::double('total', 'total', 0.0),
        Column::double('subtotal', 'subtotal', 0.0),
        Column::double('total_tax', 'tax_total', 0.0),
        Column::double('shipping_total', 'shipping_total', 0.0),
        Column::double('discount_total', 'discount_total', 0.0),
        
        // Customer Information
        Column::integer('customer_id', 'customer_id', 0),
        Column::string('billing.first_name', 'billing_first_name', ''),
        Column::string('billing.last_name', 'billing_last_name', ''),
        Column::string('billing.email', 'billing_email', ''),
        Column::string('billing.phone', 'billing_phone', ''),
        Column::string('billing.company', 'billing_company', ''),
        Column::string('billing.address_1', 'billing_address_1', ''),
        Column::string('billing.address_2', 'billing_address_2', ''),
        Column::string('billing.city', 'billing_city', ''),
        Column::string('billing.state', 'billing_state', ''),
        Column::string('billing.postcode', 'billing_postcode', ''),
        Column::string('billing.country', 'billing_country', ''),
        
        // Shipping Information
        Column::string('shipping.first_name', 'shipping_first_name', ''),
        Column::string('shipping.last_name', 'shipping_last_name', ''),
        Column::string('shipping.company', 'shipping_company', ''),
        Column::string('shipping.address_1', 'shipping_address_1', ''),
        Column::string('shipping.address_2', 'shipping_address_2', ''),
        Column::string('shipping.city', 'shipping_city', ''),
        Column::string('shipping.state', 'shipping_state', ''),
        Column::string('shipping.postcode', 'shipping_postcode', ''),
        Column::string('shipping.country', 'shipping_country', ''),
        
        // Payment Information
        Column::string('payment_method', 'payment_method', ''),
        Column::string('payment_method_title', 'payment_method_title', ''),
        Column::string('transaction_id', 'transaction_id', ''),
        
        // Dates
        Column::date('date_created', 'created_at', '', 'Y-m-d H:i:s'),
        Column::date('date_modified', 'updated_at', '', 'Y-m-d H:i:s'),
        Column::date('date_completed', 'completed_at', '', 'Y-m-d H:i:s'),
        Column::date('date_paid', 'paid_at', '', 'Y-m-d H:i:s'),
        
        // Notes
        Column::string('customer_note', 'customer_note', ''),
        Column::array('customer_note', 'order_notes', []),
        
        // Generated Fields
        Column::concat(['billing.first_name', 'billing.last_name'], 'customer_name', '', ' '),
        Column::concat(['billing.address_1', 'billing.city', 'billing.state'], 'billing_address', '', ', '),
        Column::concat(['shipping.address_1', 'shipping.city', 'shipping.state'], 'shipping_address', '', ', ')
    ),
    Resource::relations(
        // Order Items
        Resource::mapping(
            Resource::local('order_items'),
            Resource::remote('line_items'),
            Resource::columns(
                Column::integer('id', 'woo_item_id', 0),
                Column::integer('product_id', 'product_id', 0),
                Column::string('name', 'product_name', ''),
                Column::integer('quantity', 'quantity', 1),
                Column::double('price', 'price', 0.0),
                Column::double('total', 'total', 0.0),
                Column::double('subtotal', 'subtotal', 0.0),
                Column::double('total_tax', 'tax_total', 0.0),
                Column::string('sku', 'sku', ''),
                Column::array('meta_data', 'meta_data', [])
            )
        )
    )
);
```

## MercadoLivre Integration Examples

### Product Mapping

```php
<?php

$meliProductMapping = Resource::mapping(
    Resource::local('products'),
    Resource::remote('items'),
    Resource::columns(
        // Basic Information
        Column::string('id', 'meli_id', ''),
        Column::string('title', 'title', ''),
        Column::string('subtitle', 'subtitle', ''),
        Column::string('category_id', 'category_id', ''),
        
        // Pricing
        Column::double('price', 'price', 0.0),
        Column::double('original_price', 'original_price', 0.0),
        Column::string('currency_id', 'currency', 'BRL'),
        
        // Inventory
        Column::integer('available_quantity', 'stock_quantity', 0),
        Column::string('condition', 'condition', 'new'),
        Column::boolean('accepts_mercadopago', 'accepts_mercadopago', true),
        
        // Shipping
        Column::boolean('shipping.free_shipping', 'free_shipping', false),
        Column::string('shipping.mode', 'shipping_mode', ''),
        Column::array('shipping.tags', 'shipping_tags', []),
        
        // Images
        Column::string('pictures.0.url', 'featured_image', ''),
        Column::array('pictures', 'images', []),
        
        // Attributes
        Column::array('attributes', 'attributes', []),
        
        // Seller Information
        Column::string('seller_id', 'seller_id', ''),
        Column::string('seller.nickname', 'seller_nickname', ''),
        
        // Status
        Column::string('status', 'status', 'active'),
        Column::string('listing_type_id', 'listing_type', ''),
        
        // Dates
        Column::date('date_created', 'created_at', '', 'Y-m-d H:i:s'),
        Column::date('last_updated', 'updated_at', '', 'Y-m-d H:i:s'),
        
        // Additional Information
        Column::string('permalink', 'permalink', ''),
        Column::string('video_id', 'video_id', ''),
        Column::string('warranty', 'warranty', ''),
        
        // Generated Fields
        Column::concat(['title', 'subtitle'], 'full_title', '', ' - '),
        Column::sku(['title', 'id'], 'generated_sku')
    )
);
```

### Order Mapping

```php
<?php

$meliOrderMapping = Resource::mapping(
    Resource::local('orders'),
    Resource::remote('orders'),
    Resource::columns(
        // Order Information
        Column::string('id', 'meli_order_id', ''),
        Column::string('order_number', 'order_number', ''),
        Column::string('status', 'status', 'pending'),
        Column::string('currency_id', 'currency', 'BRL'),
        
        // Totals
        Column::double('total_amount', 'total', 0.0),
        Column::double('paid_amount', 'paid_amount', 0.0),
        Column::double('shipping_cost', 'shipping_cost', 0.0),
        
        // Buyer Information
        Column::string('buyer.id', 'buyer_id', ''),
        Column::string('buyer.nickname', 'buyer_nickname', ''),
        Column::string('buyer.email', 'buyer_email', ''),
        
        // Shipping Information
        Column::string('shipping.receiver_address.name', 'shipping_name', ''),
        Column::string('shipping.receiver_address.street_name', 'shipping_street', ''),
        Column::string('shipping.receiver_address.street_number', 'shipping_number', ''),
        Column::string('shipping.receiver_address.comment', 'shipping_comment', ''),
        Column::string('shipping.receiver_address.zip_code', 'shipping_zipcode', ''),
        Column::string('shipping.receiver_address.city.name', 'shipping_city', ''),
        Column::string('shipping.receiver_address.state.name', 'shipping_state', ''),
        Column::string('shipping.receiver_address.country.name', 'shipping_country', ''),
        
        // Payment Information
        Column::string('payments.0.payment_method.id', 'payment_method', ''),
        Column::string('payments.0.payment_type', 'payment_type', ''),
        Column::string('payments.0.status', 'payment_status', ''),
        
        // Dates
        Column::date('date_created', 'created_at', '', 'Y-m-d H:i:s'),
        Column::date('last_updated', 'updated_at', '', 'Y-m-d H:i:s'),
        Column::date('date_closed', 'closed_at', '', 'Y-m-d H:i:s'),
        
        // Generated Fields
        Column::concat(['shipping.receiver_address.street_name', 'shipping.receiver_address.street_number'], 'shipping_address', '', ' '),
        Column::concat(['shipping.receiver_address.city.name', 'shipping.receiver_address.state.name'], 'shipping_location', '', ', ')
    ),
    Resource::relations(
        // Order Items
        Resource::mapping(
            Resource::local('order_items'),
            Resource::remote('order_items'),
            Resource::columns(
                Column::string('item.id', 'product_id', ''),
                Column::string('item.title', 'product_name', ''),
                Column::integer('quantity', 'quantity', 1),
                Column::double('unit_price', 'unit_price', 0.0),
                Column::double('full_unit_price', 'full_unit_price', 0.0),
                Column::string('item.seller_custom_field', 'seller_sku', '')
            )
        )
    )
);
```

## Magento Integration Examples

### Product Mapping

```php
<?php

$magentoProductMapping = Resource::mapping(
    Resource::local('products'),
    Resource::remote('products'),
    Resource::columns(
        // Basic Information
        Column::integer('id', 'magento_id', 0),
        Column::string('name', 'title', ''),
        Column::string('description', 'description', ''),
        Column::string('short_description', 'short_description', ''),
        Column::string('sku', 'sku', ''),
        
        // Pricing
        Column::double('price', 'price', 0.0),
        Column::double('special_price', 'special_price', 0.0),
        Column::double('cost', 'cost', 0.0),
        
        // Inventory
        Column::integer('qty', 'stock_quantity', 0),
        Column::string('stock_status', 'stock_status', '1'),
        Column::boolean('manage_stock', 'manage_stock', true),
        Column::integer('min_qty', 'min_stock', 0),
        Column::integer('max_qty', 'max_stock', 0),
        
        // Status
        Column::string('status', 'status', '1'),
        Column::string('visibility', 'visibility', '4'),
        Column::boolean('is_active', 'is_active', true),
        
        // Categories
        Column::array('category_ids', 'category_ids', []),
        
        // Images
        Column::string('media_gallery_entries.0.file', 'featured_image', ''),
        Column::array('media_gallery_entries', 'gallery_images', []),
        
        // Attributes
        Column::string('custom_attributes.0.value', 'weight', ''),
        Column::string('custom_attributes.1.value', 'brand', ''),
        Column::string('custom_attributes.2.value', 'color', ''),
        
        // Dates
        Column::date('created_at', 'created_at', '', 'Y-m-d H:i:s'),
        Column::date('updated_at', 'updated_at', '', 'Y-m-d H:i:s'),
        
        // Generated Fields
        Column::concat(['name', 'sku'], 'display_name', '', ' - '),
        Column::sku(['name', 'id'], 'generated_sku')
    )
);
```

## Shopify Integration Examples

### Product Mapping

```php
<?php

$shopifyProductMapping = Resource::mapping(
    Resource::local('products'),
    Resource::remote('products'),
    Resource::columns(
        // Basic Information
        Column::integer('id', 'shopify_id', 0),
        Column::string('title', 'title', ''),
        Column::string('body_html', 'description', ''),
        Column::string('handle', 'handle', ''),
        Column::string('product_type', 'product_type', ''),
        Column::string('vendor', 'vendor', ''),
        
        // Status
        Column::string('status', 'status', 'draft'),
        Column::boolean('published', 'is_published', false),
        
        // Images
        Column::string('image.src', 'featured_image', ''),
        Column::array('images', 'gallery_images', []),
        
        // Variants
        Column::array('variants', 'variants', []),
        
        // Tags
        Column::string('tags', 'tags', ''),
        
        // SEO
        Column::string('seo_title', 'seo_title', ''),
        Column::string('seo_description', 'seo_description', ''),
        
        // Dates
        Column::date('created_at', 'created_at', '', 'Y-m-d H:i:s'),
        Column::date('updated_at', 'updated_at', '', 'Y-m-d H:i:s'),
        Column::date('published_at', 'published_at', '', 'Y-m-d H:i:s'),
        
        // Generated Fields
        Column::concat(['title', 'vendor'], 'display_name', '', ' by '),
        Column::sku(['title', 'id'], 'generated_sku')
    ),
    Resource::relations(
        // Variants mapping
        Resource::mapping(
            Resource::local('product_variants'),
            Resource::remote('variants'),
            Resource::columns(
                Column::integer('id', 'shopify_variant_id', 0),
                Column::string('title', 'title', ''),
                Column::string('sku', 'sku', ''),
                Column::double('price', 'price', 0.0),
                Column::double('compare_at_price', 'compare_at_price', 0.0),
                Column::integer('inventory_quantity', 'stock_quantity', 0),
                Column::string('inventory_management', 'inventory_management', ''),
                Column::string('inventory_policy', 'inventory_policy', ''),
                Column::double('weight', 'weight', 0.0),
                Column::string('weight_unit', 'weight_unit', ''),
                Column::boolean('taxable', 'taxable', true),
                Column::array('option1', 'option1', ''),
                Column::array('option2', 'option2', ''),
                Column::array('option3', 'option3', '')
            )
        )
    )
);
```

## Usage Patterns

### Basic Usage

```php
<?php

// Create mapper
$mapper = new ResourceMapper('woocommerce', $productMapping);

// API to Local
$localData = $mapper->toLocal($apiData);

// Local to API
$apiData = $mapper->toRemote($localData);
```

### Batch Processing

```php
<?php

// Process multiple items
$localItems = [];
foreach ($apiItems as $apiItem) {
    $localItems[] = $mapper->toLocal($apiItem);
}

// Or use array_map
$localItems = array_map(function($apiItem) use ($mapper) {
    return $mapper->toLocal($apiItem);
}, $apiItems);
```

### Error Handling

```php
<?php

try {
    $localData = $mapper->toLocal($apiData);
} catch (Exception $e) {
    Log::error('Mapping failed: ' . $e->getMessage(), [
        'api_data' => $apiData,
        'mapping' => $productMapping
    ]);
    
    // Use default values or skip the item
    $localData = [];
}
```

### Caching Mappings

```php
<?php

// Cache mapping definitions for better performance
$mappingKey = 'woocommerce_product_mapping';
$productMapping = Cache::remember($mappingKey, 3600, function() {
    return Resource::mapping(/* your mapping definition */);
});

$mapper = new ResourceMapper('woocommerce', $productMapping);
```

### Validation

```php
<?php

// Validate mapped data before saving
$localData = $mapper->toLocal($apiData);

// Check required fields
if (empty($localData['title']) || empty($localData['price'])) {
    throw new ValidationException('Required fields missing after mapping');
}

// Validate data types
if (!is_numeric($localData['price']) || $localData['price'] < 0) {
    throw new ValidationException('Invalid price value');
}
```

These examples provide a solid foundation for integrating with various e-commerce platforms. You can adapt and extend them based on your specific requirements. 
