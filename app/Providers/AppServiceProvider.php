<?php

namespace App\Providers;

use App\Models\Products;
use App\Observers\ProductsObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Services\CartServiceInterface::class,
            \App\Services\CartService::class,
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Products::observe(ProductsObserver::class);
    }
}
