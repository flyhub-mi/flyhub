<?php

namespace App\Providers;

use RuntimeException;
use Psr\Log\LoggerInterface;
use LogicException;
use InvalidArgumentException;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Blade;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Contracts\Container\BindingResolutionException;
use App\Observers\ProductObserver;
use App\Observers\ProductInventoryObserver;
use App\Observers\OrderObserver;
use App\Observers\OrderItemObserver;
use App\Observers\CustomerObserver;
use App\Models\Tenant\ProductInventory;
use App\Models\Tenant\Product;
use App\Models\Tenant\OrderItem;
use App\Models\Tenant\Order;
use App\Models\Tenant\Customer;
use Illuminate\Support\Facades\Event;
use Laravel\Passport\Passport;
use Route;
use Stancl\Tenancy\Events\TenancyBootstrapped;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @return void
     * @throws LogicException
     * @throws BindingResolutionException
     */
    public function register()
    {
        $this->app->alias('bugsnag.multi', Log::class);
        $this->app->alias('bugsnag.multi', LoggerInterface::class);

        if (method_exists($this->app, 'isLocal') && $this->app?->isLocal()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }

        Passport::ignoreMigrations();

        Route::group([
            'as' => 'passport.',
            'middleware' => [
                'universal',
                InitializeTenancyByDomain::class
            ],
            'prefix' => config('passport.path', 'oauth'),
            'namespace' => 'Laravel\Passport\Http\Controllers',
        ], function () {
            $this->loadRoutesFrom(__DIR__ . "/../../vendor/laravel/passport/src/../routes/web.php");
        });
    }

    /**
     * @param UrlGenerator $url
     * @return void
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function boot(UrlGenerator $url)
    {
        $this->setPassport();
        $this->setLocale();
        $this->setRedirectHttps($url);
        $this->setDirectives();
        $this->setObservers();
        $this->setTenancy();
    }

    /** @return void  */
    private function setPassport()
    {
        Passport::loadKeysFrom(base_path(config('passport.key_path')));
    }

    /** @return void  */
    private function setLocale()
    {
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        setlocale(LC_MONETARY, 'pt_BR');
    }

    /**
     * @param UrlGenerator $url
     * @return void
     * @throws InvalidArgumentException
     */
    private function setRedirectHttps(UrlGenerator $url)
    {
        if (env('REDIRECT_HTTPS')) {
            $url->forceScheme('https');
        }
    }

    /**
     * @return void
     * @throws InvalidArgumentException
     */
    private function setDirectives()
    {
        Blade::directive('money', function ($amount) {
            return "<?php echo 'R$ ' . ($amount > 0 ? number_format($amount, 2, ',', '.') : '0,00'); ?>";
        });
    }

    /**
     * @return void
     * @throws RuntimeException
     */
    private function setObservers()
    {
        Customer::observe(CustomerObserver::class);
        Order::observe(OrderObserver::class);
        OrderItem::observe(OrderItemObserver::class);
        Product::observe(ProductObserver::class);
        ProductInventory::observe(ProductInventoryObserver::class);
    }

    /** @return void  */
    private function setTenancy()
    {
        Event::listen(TenancyBootstrapped::class, function (TenancyBootstrapped $event) {
            \Spatie\Permission\PermissionRegistrar::$cacheKey =
                'spatie.permission.cache.tenant.' . $event->tenancy->tenant->id;
        });
    }
}
