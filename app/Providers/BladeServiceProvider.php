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
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        Blade::directive('iverified', fn($exp): string => '<?php if(request()->user()->verified_at !== NULL): ?>');

        Blade::directive('endiverified', fn($exp): string => '<?php endif; ?>');
    }
}
