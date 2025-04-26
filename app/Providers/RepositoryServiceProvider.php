<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
        $this->app->bind(
            \App\Repositories\ProductsRepositoryInterface::class,
            \App\Repositories\ProductsRepository::class,
        );

        $this->app->bind(
            \App\Repositories\BrandsRepositoryInterface::class,
            \App\Repositories\BrandsRepository::class,
        );

        $this->app->bind(
            \App\Repositories\ImagesRepositoryInterface::class,
            \App\Repositories\ImagesRepository::class,
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
