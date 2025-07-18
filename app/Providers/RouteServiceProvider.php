<?php

namespace App\Providers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as BaseRouteServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends BaseRouteServiceProvider
{
    /**
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    public const HOME = '/';

    /**
     *
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     *
     */
    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
        $this->centralDomains();
    }

    /**
     *
     */
    protected function mapWebRoutes()
    {
        foreach ($this->centralDomains() as $domain) {
            Route::middleware('web')
                ->domain($domain)
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        }
    }

    /**
     *
     */
    protected function mapApiRoutes()
    {
        foreach ($this->centralDomains() as $domain) {
            Route::prefix('api')
                ->domain($domain)
                ->middleware('api')
                ->as('api.')
                ->namespace($this->namespace . '\\API')
                ->group(base_path('routes/api.php'));
        }
    }

    /**
     * @return array
     * @throws BindingResolutionException
     */
    protected function centralDomains(): array
    {
        return config('tenancy.central_domains');
    }
}
