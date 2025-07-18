<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the 'web' middleware group. Now create something great!
|
*/

Auth::routes();

/** public channels-callback */
Route::get('channels-callback/{channelCode}/notifications', 'ChannelCallbackController@notifications')->name(
    'channels-callback.notifications',
);

/** authenticated */
Route::middleware('auth')
    ->namespace('Tenant')
    ->group(function () {
        Route::resource('/', 'DashboardController', ['names' => ['index' => 'dashboard']]);

        /** sales */
        Route::group(['prefix' => 'sales'], function () {
            Route::resource('invoices', 'InvoiceController');
            Route::resource('orders', 'OrderController');
            Route::resource('refunds', 'RefundController');
            Route::resource('shipments', 'ShipmentController');
        });

        /** catalog */
        Route::group(['prefix' => 'catalog'], function () {
            Route::resource('attributes', 'AttributeController');
            Route::resource('attribute-sets', 'AttributeSetController');
            Route::resource('attribute-groups', 'AttributeGroupController');
            Route::resource('categories', 'CategoryController');
            Route::resource('products', 'ProductController');
        });

        /** channels */
        Route::resource('channels', 'ChannelController');

        /** channels-callback */
        Route::get('channels-callback/{channelCode}/auth', 'ChannelCallbackController@auth')->name(
            'channels-callback.auth',
        );

        /** customers */
        Route::resource('customers', 'CustomerController');

        /** configurations */
        Route::group(['prefix' => 'configurations'], function () {
            Route::resource('users', 'UserController');
            Route::resource('inventory-sources', 'InventorySourceController');
            Route::resource('tax-groups', 'TaxGroupController');
            Route::resource('taxes', 'TaxesController');
            Route::resource('tokens', 'TokensController')->only(['index']);
            Route::resource('sync-logs', 'SyncLogController')->only(['index']);
        });

        Route::group(['prefix' => 'admin'], function () {
            Route::resource('configs', 'ConfigController');
            Route::resource('integrations', 'IntegrationController');
            Route::resource('integration-models', 'IntegrationModelController');
            Route::resource('roles', 'RoleController');
            Route::resource('tenants', 'TenantController')->middleware('role:admin');
        });

        /** notifications */
        Route::group(['prefix' => 'notifications'], function () {
            Route::get('index', 'NotificationController@clear')->name('notifications.index');
            Route::get('clear', 'NotificationController@clear')->name('notifications.clear');
        });

        /** for developer */
        Route::resource('/test', 'TestController');
    });
