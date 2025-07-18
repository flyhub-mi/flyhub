<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('api')->get('/user', 'Tenant\API\UserAPIController@AuthRouteAPI');

Route::group(['prefix' => 'api/v1', 'namespace' => 'Tenant\\API'], function () {
    Route::get('test', function () {
        return 'Hello World';
    });

    Route::resource('attributes', 'AttributeAPIController');
    Route::resource('attribute-sets', 'AttributeSetAPIController');
    Route::resource('categories', 'CategoryAPIController');
    Route::resource('channels', 'ChannelAPIController');
    Route::resource('channel-sync-logs', 'ChannelSyncLogAPIController');
    Route::resource('sync-logs.results', 'ChannelSyncLogResultAPIController')->only(['index']);
    Route::resource('channels.products', 'ChannelProductAPIController');
    Route::resource('channels.categories', 'ChannelCategoryAPIController');
    Route::resource('channels.categories.attributes', 'ChannelCategoryAttributeAPIController');
    Route::resource('configs', 'ConfigAPIController');
    Route::resource('countries', 'CountryAPIController');
    Route::resource('country-states', 'CountryStateAPIController');
    Route::resource('customers', 'CustomerAPIController');
    Route::resource('inventory-sources', 'InventorySourceAPIController');
    Route::resource('invoices', 'InvoiceAPIController');
    Route::resource('integration-models', 'IntegrationModelAPIController');
    Route::resource('integrations', 'IntegrationAPIController');
    Route::resource('orders', 'OrderAPIController');
    Route::resource('notifications', 'NotificationAPIController');
    Route::resource('products', 'ProductAPIController');
    Route::resource('products.images', 'ProductImageAPIController');
    Route::resource('products.channels', 'ProductChannelAPIController');
    Route::resource('refunds', 'RefundAPIController');
    Route::resource('shipments', 'ShipmentAPIController');
    Route::resource('subscribers', 'SubscriberAPIController');
    Route::resource('tax-groups', 'TaxGroupAPIController');
    Route::resource('taxes', 'TaxAPIController');
    Route::resource('tenants', 'TenantAPIController');
    Route::resource('users', 'UserAPIController');
});
