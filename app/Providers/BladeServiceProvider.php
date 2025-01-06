<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('iverified', fn($exp) => '<?php if(request()->user()->verified_at !== NULL): ?>');

        Blade::directive('endiverified', fn($exp) => '<?php endif; ?>');
    }
}
