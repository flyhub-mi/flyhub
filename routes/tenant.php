<?php

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware(['api', InitializeTenancyByDomain::class, PreventAccessFromCentralDomains::class])
    ->as('api.')
    ->group(base_path('routes/tenant/api.php'));

Route::middleware(['web', InitializeTenancyByDomain::class, PreventAccessFromCentralDomains::class])->group(
    base_path('routes/tenant/web.php'),
);
