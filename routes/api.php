<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['as' => 'api.'], function () {
    Route::get('images', [\App\Http\Controllers\API\ImageController::class, 'index'])->name('images.index');
    Route::delete('images/destroy', [\App\Http\Controllers\API\ImageController::class, 'destroy'])->name('images.destroy');

    Route::get('admin/orders/{status?}/{reseller?}', [\App\Http\Controllers\API\OrderController::class, 'admin'])->name('orders.admin');
    Route::get('reseller/orders/{reseller?}/{status?}', [\App\Http\Controllers\API\OrderController::class, 'reseller'])->name('orders.reseller');

    Route::get('transactions/{status?}/{reseller?}', [\App\Http\Controllers\API\TransactionController::class, 'index'])->name('transactions.index');

    Route::get('resellers', [\App\Http\Controllers\API\ResellerController::class, 'index'])->name('resellers.index');
    Route::get('resellers/edit', [\App\Http\Controllers\API\ResellerController::class, 'edit'])->name('resellers.edit');
});
