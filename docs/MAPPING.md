# Mapping System Documentation

The Mapping system provides a powerful and flexible way to transform data between external APIs (like WooCommerce, MercadoLivre, etc.) and your local database models. It handles complex data transformations, type conversions, formatting, and nested relationships.

## Table of Contents

- [Overview](#overview)
- [Basic Concepts](#basic-concepts)
- [Column Types](#column-types)
- [Data Transformation](#data-transformation)
- [Examples](#examples)
  - [WooCommerce Product Mapping](#woocommerce-product-mapping)
  - [WooCommerce Order Mapping](#woocommerce-order-mapping)
  - [MercadoLivre Product Mapping](#mercadolivre-product-mapping)
- [Advanced Features](#advanced-features)
- [Best Practices](#best-practices)

## Overview

The Mapping system consists of several key components:

- **Resource**: Defines the overall mapping structure
- **Column**: Defines individual field mappings with types and transformations
- **DataMapper**: Handles the actual data transformation
- **ResourceMapper**: High-level interface for mapping operations
- **Utils**: Helper functions for data manipulation

## Basic Concepts

### Mapping Structure

A mapping consists of:
- **local**: Local database field configuration
- **remote**: External API field configuration
- **columns**: Field-by-field mapping definitions
- **relations**: Nested object/array mappings
- **configs**: Additional configuration options

### Direction

Mappings work in two directions:
- **remote → local**: Transform external API data to local format
- **local → remote**: Transform local data to external API format

## Column Types

### Basic Types

```php
use App\Integration\Mapping\Column;

// String field
Column::string('remote_field', 'local_field', 'default_value', 'format');

// Integer field
Column::integer('remote_id', 'local_id', 0);

// Double/Decimal field
Column::double('remote_price', 'local_price', 0.0);

// Boolean field
Column::boolean('remote_active', 'local_active', true);

// Date field
Column::date('remote_created_at', 'local_created_at', '', 'Y-m-d H:i:s');

// Array field
Column::array('remote_tags', 'local_tags', []);
```

### Special Types

```php
// Remote-only field (read-only from API)
Column::remote('api_only_field', 'default_value', 'string');

// Local-only field (write-only to API)
Column::local('local_only_field', 'default_value', 'string');

// Concatenated fields
Column::concat(['first_name', 'last_name'], 'full_name', '', ' ');

// SKU generation
Column::sku(['brand', 'model', 'color'], 'generated_sku');
```

## Data Transformation

### Formatting Options

```php
// String formatting
Column::string('raw_text', 'formatted_text', '', 'trim');
Column::string('mixed_text', 'letters_only', '', 'letters');
Column::string('mixed_text', 'numbers_only', '', 'numbers');
Column::string('mixed_text', 'alphanumeric', '', 'letters_numbers');

// Brazilian document formatting
Column::string('raw_cpf', 'formatted_cpf', '', 'cpf');
Column::string('raw_cnpj', 'formatted_cnpj', '', 'cnpj');
Column::string('raw_cep', 'formatted_cep', '', 'cep');

// HTML handling
Column::string('html_content', 'plain_text', '', 'html_remove');
Column::string('plain_text', 'html_content', '', 'html_encode');
Column::string('encoded_html', 'plain_text', '', 'html_decode');
```

## Examples

### WooCommerce Product Mapping

```php
use App\Integration\Mapping\Resource;
use App\Integration\Mapping\Column;

// Define the mapping
$productMapping = Resource::mapping(
    Resource::local('products'),
    Resource::remote('products'),
    Resource::columns(
        // Basic product information
        Column::integer('id', 'woo_id', 0),
        Column::string('name', 'title', ''),
        Column::string('description', 'description', ''),
        Column::string('short_description', 'short_description', ''),
        Column::string('slug', 'slug', ''),
        
        // Pricing
        Column::double('price', 'price', 0.0),
        Column::double('regular_price', 'regular_price', 0.0),
        Column::double('sale_price', 'sale_price', 0.0),
        
        // Status and visibility
        Column::string('status', 'status', 'draft'),
        Column::boolean('catalog_visibility', 'is_visible', true),
        
        // Inventory
        Column::integer('stock_quantity', 'stock_quantity', 0),
        Column::string('stock_status', 'stock_status', 'instock'),
        Column::boolean('manage_stock', 'manage_stock', false),
        
        // Categories and tags
        Column::array('categories', 'category_ids', []),
        Column::array('tags', 'tag_ids', []),
        
        // Images
        Column::string('images.0.src', 'featured_image', ''),
        Column::array('images', 'gallery_images', []),
        
        // Meta fields
        Column::string('meta_data.0.value', 'sku', ''),
        Column::string('meta_data.1.value', 'weight', ''),
        Column::string('meta_data.2.value', 'dimensions', ''),
        
        // Dates
        Column::date('date_created', 'created_at', '', 'Y-m-d H:i:s'),
        Column::date('date_modified', 'updated_at', '', 'Y-m-d H:i:s'),
        
        // Concatenated fields
        Column::concat(['name', 'sku'], 'display_name', '', ' - '),
        
        // Generated SKU
        Column::sku(['name', 'id'], 'generated_sku')
    ),
    Resource::relations(
        // Nested category mapping
        Resource::mapping(
            Resource::local('categories'),
            Resource::remote('categories'),
            Resource::columns(
                Column::integer('id', 'woo_category_id', 0),
                Column::string('name', 'name', ''),
                Column::string('slug', 'slug', ''),
                Column::string('description', 'description', '')
            )
        )
    )
);

// Usage
use App\Integration\Mapping\ResourceMapper;

$mapper = new ResourceMapper('woocommerce', $productMapping);

// Transform WooCommerce data to local format
$wooProductData = [
    'id' => 123,
    'name' => 'Sample Product',
    'description' => 'Product description',
    'price' => '29.99',
    'stock_quantity' => 50,
    'images' => [
        ['src' => 'https://example.com/image1.jpg'],
        ['src' => 'https://example.com/image2.jpg']
    ],
    'categories' => [
        ['id' => 1, 'name' => 'Electronics'],
        ['id' => 2, 'name' => 'Gadgets']
    ]
];

$localData = $mapper->toLocal($wooProductData);

// Transform local data to WooCommerce format
$localProductData = [
    'title' => 'Local Product',
    'price' => 39.99,
    'stock_quantity' => 25,
    'category_ids' => [1, 2]
];

$wooData = $mapper->toRemote($localProductData);
```

### WooCommerce Order Mapping

```php
$orderMapping = Resource::mapping(
    Resource::local('orders'),
    Resource::remote('orders'),
    Resource::columns(
        // Order basic info
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
        
        // Customer info
        Column::string('billing.first_name', 'billing_first_name', ''),
        Column::string('billing.last_name', 'billing_last_name', ''),
        Column::string('billing.email', 'billing_email', ''),
        Column::string('billing.phone', 'billing_phone', ''),
        Column::string('billing.address_1', 'billing_address_1', ''),
        Column::string('billing.city', 'billing_city', ''),
        Column::string('billing.state', 'billing_state', ''),
        Column::string('billing.postcode', 'billing_postcode', ''),
        Column::string('billing.country', 'billing_country', ''),
        
        // Shipping info
        Column::string('shipping.first_name', 'shipping_first_name', ''),
        Column::string('shipping.last_name', 'shipping_last_name', ''),
        Column::string('shipping.address_1', 'shipping_address_1', ''),
        Column::string('shipping.city', 'shipping_city', ''),
        Column::string('shipping.state', 'shipping_state', ''),
        Column::string('shipping.postcode', 'shipping_postcode', ''),
        Column::string('shipping.country', 'shipping_country', ''),
        
        // Dates
        Column::date('date_created', 'created_at', '', 'Y-m-d H:i:s'),
        Column::date('date_modified', 'updated_at', '', 'Y-m-d H:i:s'),
        Column::date('date_completed', 'completed_at', '', 'Y-m-d H:i:s'),
        
        // Payment
        Column::string('payment_method', 'payment_method', ''),
        Column::string('payment_method_title', 'payment_method_title', ''),
        Column::string('transaction_id', 'transaction_id', ''),
        
        // Notes
        Column::string('customer_note', 'customer_note', ''),
        
        // Concatenated fields
        Column::concat(['billing.first_name', 'billing.last_name'], 'customer_name', '', ' '),
        Column::concat(['billing.address_1', 'billing.city', 'billing.state'], 'billing_address', '', ', ')
    ),
    Resource::relations(
        // Order items mapping
        Resource::mapping(
            Resource::local('order_items'),
            Resource::remote('line_items'),
            Resource::columns(
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

### MercadoLivre Product Mapping

```php
$meliProductMapping = Resource::mapping(
    Resource::local('products'),
    Resource::remote('items'),
    Resource::columns(
        // Basic info
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
        
        // Seller info
        Column::string('seller_id', 'seller_id', ''),
        Column::string('seller.nickname', 'seller_nickname', ''),
        
        // Status
        Column::string('status', 'status', 'active'),
        Column::string('listing_type_id', 'listing_type', ''),
        
        // Dates
        Column::date('date_created', 'created_at', '', 'Y-m-d H:i:s'),
        Column::date('last_updated', 'updated_at', '', 'Y-m-d H:i:s'),
        
        // Permalink
        Column::string('permalink', 'permalink', ''),
        
        // Video
        Column::string('video_id', 'video_id', ''),
        
        // Warranty
        Column::string('warranty', 'warranty', ''),
        
        // Generated fields
        Column::concat(['title', 'subtitle'], 'full_title', '', ' - '),
        Column::sku(['title', 'id'], 'generated_sku')
    ),
    Resource::relations(
        // Category mapping
        Resource::mapping(
            Resource::local('categories'),
            Resource::remote('category'),
            Resource::columns(
                Column::string('id', 'meli_category_id', ''),
                Column::string('name', 'name', ''),
                Column::string('picture', 'picture', '')
            )
        )
    )
);
```

## Advanced Features

### Nested Data Access

```php
// Access nested properties using dot notation
Column::string('user.profile.first_name', 'first_name', '');
Column::string('order.items.0.product.name', 'first_product_name', '');
Column::array('order.items.*.product.id', 'product_ids', []);
```

### Conditional Mapping

```php
// Use different fields based on conditions
$conditionalMapping = Resource::mapping(
    Resource::columns(
        Column::string('type', 'product_type', 'simple'),
        Column::string('simple_price', 'price', ''),
        Column::string('variable_price', 'price', ''),
        // The DataMapper will use the appropriate field based on 'type'
    )
);
```

### Array Transformations

```php
// Transform arrays
Column::array('tags', 'tag_names', []),
Column::array('categories.*.name', 'category_names', []),
Column::array('images.*.url', 'image_urls', [])
```

### Custom Formatting

```php
// Multiple formatting options
Column::string('raw_text', 'formatted_text', '', ['trim', 'uppercase', 'html_remove']);

// Custom date formats
Column::date('api_date', 'local_date', '', 'd/m/Y H:i:s');
```

## Best Practices

### 1. Use Descriptive Field Names

```php
// Good
Column::string('woo_product_name', 'local_product_title', '');

// Avoid
Column::string('name', 'title', '');
```

### 2. Provide Default Values

```php
// Always provide sensible defaults
Column::string('description', 'description', 'No description available');
Column::integer('stock', 'stock_quantity', 0);
Column::boolean('active', 'is_active', true);
```

### 3. Handle Missing Data

```php
// Use the 'get' helper for safe data access
Column::string('optional_field', 'local_field', 'default_value');
```

### 4. Use Appropriate Types

```php
// Use the correct type for data validation
Column::integer('id', 'product_id', 0);
Column::double('price', 'price', 0.0);
Column::boolean('active', 'is_active', false);
```

### 5. Document Complex Mappings

```php
// Add comments for complex transformations
$productMapping = Resource::mapping(
    Resource::columns(
        // WooCommerce uses 'price' for sale price, 'regular_price' for MSRP
        Column::double('price', 'sale_price', 0.0),
        Column::double('regular_price', 'regular_price', 0.0),
        
        // Generate SKU from product name and ID
        Column::sku(['name', 'id'], 'generated_sku'),
        
        // Concatenate first and last name
        Column::concat(['first_name', 'last_name'], 'full_name', '', ' ')
    )
);
```

### 6. Test Your Mappings

```php
// Test with sample data
$testData = [
    'id' => 123,
    'name' => 'Test Product',
    'price' => '29.99'
];

$mapper = new ResourceMapper('test', $productMapping);
$result = $mapper->toLocal($testData);

// Verify the transformation
assert($result['local_product_id'] === 123);
assert($result['local_product_title'] === 'Test Product');
assert($result['local_price'] === 29.99);
```

## Error Handling

The mapping system includes built-in error handling:

```php
// Missing fields return default values
$data = ['name' => 'Product'];
$result = $mapper->toLocal($data);
// price will be 0.0 (default value)

// Invalid types are handled gracefully
$data = ['price' => 'invalid_price'];
$result = $mapper->toLocal($data);
// price will be 0.0 (default value for invalid double)
```

## Performance Considerations

1. **Cache Mappings**: Store mapping definitions in cache for better performance
2. **Batch Processing**: Use batch operations for large datasets
3. **Selective Mapping**: Only map fields you actually need
4. **Lazy Loading**: Load related data only when needed

This mapping system provides a robust foundation for integrating with various e-commerce platforms while maintaining clean, maintainable code. 
