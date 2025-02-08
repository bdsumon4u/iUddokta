<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrapFour();

        $this->app->bind('pathao', fn (): \App\Pathao\Manage\Manage => new \App\Pathao\Manage\Manage(
            new \App\Pathao\Apis\AreaApi,
            new \App\Pathao\Apis\StoreApi,
            new \App\Pathao\Apis\OrderApi
        ));
    }
}
