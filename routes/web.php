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

Route::middleware('web')->group(function () {
    Route::get('{path}', 'HomeController@index')->where('path', '^(?!' . env('APP_ADMIN_ROUTE', 'admin') . ').*');

    Route::prefix(env('APP_ADMIN_ROUTE', 'admin'))->group(function () {
        Auth::routes();

        Route::middleware('auth')->namespace('Admin')->group(function () {
            Route::resource('/', 'DashboardController', ['names' => ['index' => 'dashboard']]);
            Route::resource('tenants', 'TenantController');
            Route::resource('users', 'UserController');
        });
    });
});
