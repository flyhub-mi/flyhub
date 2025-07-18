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

Route::middleware('auth:api')->get('/user', 'Admin\UserAPIController@AuthRouteAPI');

Route::middleware('auth:api')->group(function () {
    Route::group(['prefix' => 'v1'], function () {
        Route::resource('tenants', 'Admin\TenantAPIController');
        Route::resource('users', 'Admin\UserAPIController');
    });
});
