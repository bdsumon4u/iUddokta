<?php

use App\Http\Middleware\RedirectToInstallerIfNotInstalled;
use App\Models\Faq;
use App\Models\Order;
use App\Models\Reseller;
use App\Models\Slide;
use App\Services\EarningService;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/dev', function () {
    Artisan::call('config:cache');
    Artisan::call('view:cache');
    Artisan::call('cache:clear');
    Artisan::call('storage:link');
    dd('DONE');
});

Route::get('/', function (Request $request) {
    $slides = cache()->rememberForever('slides', function () {
        return Slide::whereIsActive(1)->get();
    });

    return view('home', compact('slides'))->withFaqs(cache('faqs', function () {
        $faqs = Faq::all();
        $faqs->each(function ($faq) {
            cache(["faq.{$faq->id}" => $faq]);
        });

        return $faqs;
    }));
})->middleware([RedirectToInstallerIfNotInstalled::class, 'guest:reseller']);

Route::get('/faqs', function (Request $request) {
    return view('faqs')->withFaqs(cache('faqs', function () {
        $faqs = Faq::all();
        $faqs->each(function ($faq) {
            cache(["faq.{$faq->id}" => $faq]);
        });

        return $faqs;
    }));
})->name('faqs');

Route::get('derning', function () {
    foreach (Reseller::whereNotNull('verified_at')->get() as $reseller) {
        dump($reseller->created_at->format('d-M-Y'));
        $service = new EarningService($reseller);
        dump($service->periods);
    }
});

// Installation Routes
Route::controller(\App\Http\Controllers\InstallController::class)->group(function () {
    Route::get('install/pre-installation', 'preInstallation');
    Route::get('install/configuration', 'getConfiguration');
    Route::post('install/configuration', 'postConfiguration');
    Route::get('install/complete', 'complete');
});

// Product Routes
Route::controller(\App\Http\Controllers\Reseller\ProductController::class)->group(function () {
    Route::get('/products', 'products')->name('products');
});

// Checkout Route
Route::get('checkout', fn () => [])->name('checkout');

// Authentication Routes
Route::controller(\App\Http\Controllers\Auth\LoginController::class)->group(function () {
    Route::get('getpass', 'showLoginForm')->name('login');
    Route::post('getpass', 'login')->name('login');
});
Auth::routes(['register' => false]);

// Fallback Login Route
Route::match(['get', /*'post'*/], '/login', fn () => abort(404));

// Dashboard Route
Route::get('/dashboard', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Reseller Routes
Route::group(['prefix' => 'reseller', 'as' => 'reseller.'], function () {
    Route::group(['namespace' => 'App\Http\Controllers\Reseller'], function () {
        Auth::routes(['verify' => true]);
    });
    Route::get('/dashboard', [\App\Http\Controllers\Reseller\HomeController::class, 'index'])->name('home');
});

// Admin Routes Group with Middleware and Prefix
Route::group(['middleware' => 'auth', 'prefix' => 'admin', 'as' => 'admin.'], function () {

    // Slide and Category Resources
    Route::resource('slides', \App\Http\Controllers\SlideController::class);
    Route::resource('categories', \App\Http\Controllers\CategoryController::class);

    // Product Routes
    Route::controller(\App\Http\Controllers\ProductController::class)->group(function () {
        Route::get('/products/trashed', 'trashed')->name('products.trashed');
        Route::post('/products/{product}/restore', 'restore')->name('products.restore');
        Route::resource('/products', \App\Http\Controllers\ProductController::class);
    });

    // Image Resource
    Route::resource('images', \App\Http\Controllers\ImageController::class);

    // Order Routes
    Route::controller(\App\Http\Controllers\OrderController::class)->group(function () {
        Route::view('orders', 'admin.orders.list')->name('order.index');
        Route::post('order/status', 'status')->name('order.status');
        Route::get('order/{order}', 'show')->name('order.show');
        Route::post('order/{order}/update', 'update')->name('order.update');
        Route::get('order/{order}/invoice', 'invoice')->name('order.invoice');
        Route::get('order/{order}/cancel', 'cancel')->name('order.cancel');
    });

    // Transaction Routes
    Route::view('/transactions/history', 'admin.transactions.index')->name('transactions.index');
    Route::view('/transactions/requests', 'admin.transactions.requests')->name('transactions.requests');
    Route::controller(\App\Http\Controllers\TransactionController::class)->group(function () {
        // Route::get('/transactions/pay', 'pay')->name('transactions.pay');
        Route::get('/transactions/pay/{reseller}', 'payToReseller')->name('transactions.pay-to-reseller');
        Route::post('/transactions/pay/store', 'store')->name('transactions.pay.store');
        Route::get('/transactions/{transaction}', 'show')->name('transactions.show');
        Route::get('/transactions/{transaction}/delete', 'destroy')->name('transactions.destroy');
    });

    // Notification Routes
    Route::controller(\App\Http\Controllers\NotificationController::class)->group(function () {
        Route::get('/notifications', 'index')->name('notifications.index');
        Route::patch('/notifications/read/{notification?}', 'update')->name('notifications.update');
        Route::delete('/notifications/destroy/{notification?}', 'destroy')->name('notifications.destroy');
    });

    // Reseller Resource
    Route::resource('/resellers', \App\Http\Controllers\ResellerController::class);

    // Page Routes
    Route::controller(\App\Http\Controllers\PageController::class)->group(function () {
        Route::get('/pages', 'index')->name('pages.index');
        Route::get('/pages/create', 'create')->name('pages.create');
        Route::post('/pages/create', 'store')->name('pages.store');
        Route::get('/pages/{page}/edit', 'edit')->name('pages.edit');
        Route::patch('/pages/{page}/edit', 'update')->name('pages.update');
        Route::delete('/pages/{page}/delete', 'destroy')->name('pages.destroy');
    });

    // Menu Routes
    Route::resource('hmenus', \App\Http\Controllers\MenuController::class);
    Route::controller(\App\Http\Controllers\MenuItemController::class)->group(function () {
        Route::resource('/menuItems', \App\Http\Controllers\MenuItemController::class);
        Route::post('menuItems/{menu}/sort', 'sort')->name('menuItems.sort');
    });

    // Setting Routes
    Route::controller(\App\Http\Controllers\SettingController::class)->group(function () {
        Route::get('/settings', 'edit')->name('settings.edit');
        Route::patch('/settings', 'update')->name('settings.update');
    });

    // Password Change Route
    Route::patch('/password', [\App\Http\Controllers\PasswordController::class])->name('password.update');

    // FAQ Resource
    Route::resource('/faqs', \App\Http\Controllers\FaqController::class);

    // Admin Routes
    Route::controller(\App\Http\Controllers\AdminController::class)->group(function () {
        Route::get('/admins', 'index')->name('admins.index');
        Route::get('/admins/create', 'create')->name('admins.create');
        Route::post('/admins/create', 'store')->name('admins.store');
        Route::get('/admins/{user}/edit', 'edit')->name('admins.edit');
        Route::patch('/admins/{user}/edit', 'update')->name('admins.update');
        Route::delete('/admins/{user}/destroy', 'destroy')->name('admins.destroy');
    });
});

Route::get('/page/{page:slug}', [\App\Http\Controllers\PageController::class, 'show'])
    ->middleware(\App\Http\Middleware\ShortKodeMiddleware::class)
    ->name('page.show');
// ->middleware(['auth:reseller', \App\Http\Middleware\PageMiddleware::class]);

Route::post('/contact', \App\Http\Controllers\ContactController::class)->name('contact');

Route::group(['middleware' => 'auth:reseller'], function () {
    Route::controller(\App\Http\Controllers\CartController::class)->group(function () {
        Route::get('/cart', 'index')->name('cart.index');
        Route::get('/cart/clear', 'clear')->name('cart.clear');
        Route::post('/cart/add/{product}', 'add')->name('cart.add');
        Route::delete('/cart/remove/{product}', 'remove')->name('cart.remove');
        Route::get('/checkout', 'checkout')->name('cart.checkout');
    });
});

Route::get('/earnings', \App\Http\Controllers\EarningController::class)->name('earnings');

Route::group([
    'middleware' => 'auth:reseller',
    'prefix' => 'reseller',
    'as' => 'reseller.',
], function () {
    Route::resource('shops', \App\Http\Controllers\Reseller\ShopController::class);

    Route::controller(\App\Http\Controllers\Reseller\ProductController::class)->group(function () {
        Route::get('/products/category/{slug}/id/{category}', 'index')->name('product.by-category');
        Route::get('/products', 'index')->name('product.index')->middleware(\App\Http\Middleware\IsVerified::class);
        Route::get('/product/{product:slug}', 'show')->name('product.show');
    });

    Route::view('/orders', 'reseller.orders.list')->name('order.index');
    Route::controller(\App\Http\Controllers\Reseller\OrderController::class)->group(function () {
        Route::post('/order/store', 'store')->name('order.store');
        Route::get('/order/{order}', 'show')->name('order.show');
        Route::get('/order/{order}/invoice', 'invoice')->name('order.invoice');
        Route::delete('/order/{order}/delete', 'destroy')->name('order.destroy');
        Route::get('/order/{order}/cancel', 'cancel')->name('order.cancel');
    });

    Route::view('/transactions/history', 'reseller.transactions.index')->name('transactions.index');
    Route::controller(\App\Http\Controllers\Reseller\TransactionController::class)->group(function () {
        Route::get('/transactions/request', 'request')->name('transactions.request');
        Route::post('/transactions/request', 'store')->name('transactions.store');
        Route::get('/transactions/{transaction}', 'show')->name('transactions.show');
    });

    Route::controller(\App\Http\Controllers\Reseller\SettingController::class)->group(function () {
        Route::get('/setting', 'edit')->name('setting.edit');
        Route::patch('/setting', 'update')->name('setting.update');
        Route::patch('/setting/profile', 'profile')->name('setting.profile');
        Route::patch('/setting/payment', 'payment')->name('setting.payment');
    });

    Route::view('/setting/profile', 'reseller.setting.profile');
    Route::view('/setting/payment', 'reseller.setting.payment');
    Route::view('/setting/password', 'reseller.setting.password');

    Route::patch('/password', \App\Http\Controllers\Reseller\PasswordController::class)->name('password.change');

    Route::get('/profile/{reseller}', \App\Http\Controllers\Reseller\ProfileController::class)->name('profile.show');

    Route::controller(\App\Http\Controllers\Reseller\NotificationController::class)->group(function () {
        Route::get('/notifications', 'index')->name('notifications.index');
        Route::patch('/notifications/read/{notification?}', 'update')->name('notifications.update');
        Route::delete('/notifications/destroy/{notification?}', 'destroy')->name('notifications.destroy');
    });
});
