<?php

namespace App\Providers;

use App\Http\View\Composers\Admin\AsideComposer as AdminAsideComposer;
use App\Http\View\Composers\Admin\HeaderComposer;
use App\Http\View\Composers\Admin\SidebarComposer as AdminSidebarComposer;
use App\Http\View\Composers\CartComposer;
use App\Http\View\Composers\Reseller\AsideComposer as ResellerAsideComposer;
use App\Http\View\Composers\Reseller\SidebarComposer as ResellerSidebarComposer;
use App\Http\View\Composers\SettingComposer;
use App\Models\Faq;
use App\Models\Menu;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
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
        View::composer('*', function ($view): void {
            $parameters = optional(Route::current())
                ->parameters();

            foreach ($parameters ?: [] as $key => $value) {
                if ($view->offsetExists($key)) {
                    continue;
                }
                $view->with($key, $value);
            }
        });

        $menus = [
            'Header Menu' => 'header.menu.*',
            'Footer Menu' => 'footer',
            'Quick Links' => 'footer',
        ];

        foreach ($menus as $name => $view) {
            View::composer("partials.{$view}", function ($view) use ($name): void {
                // dd(cache()->get(
                //     'menus:' . $name));
                $view->withMenuItems(cache()->rememberForever('menus:'.$name, fn() => optional(Menu::whereName($name)->first())->items ?: collect()));
            });
        }

        View::composer('faqs', function ($view): void {
            $view->with('faqs', Faq::all());
        });

        // View::composer(['layouts.*', 'reseller.shop.header'], HeaderComposer::class);
        View::composer(['admin.*', 'layouts.*'], AdminAsideComposer::class);
        View::composer(['admin.*', 'layouts.*'], AdminSidebarComposer::class);
        View::composer(['reseller.layout'], ResellerSidebarComposer::class);
        View::composer(['reseller.layout'], ResellerAsideComposer::class);
        View::composer(['reseller.products.layout', 'reseller.products.fleetcart', 'reseller.cart.*', 'reseller.checkout.*'], CartComposer::class);

        View::composer(['welcome', 'home', 'contact-form', 'layouts.*', 'partials.footer', 'admin.aside.*', 'components.layouts.header', 'components.layouts.footer', 'reseller.layout', 'reseller.products.layout', 'reseller.products.fleetcart', 'reseller.checkout.content', 'reseller.products.product', 'order.show'], SettingComposer::class);
    }
}
