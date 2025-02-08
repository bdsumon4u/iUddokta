<?php

use App\Http\Controllers\OrderController;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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

Route::middleware('auth:api')->get('/user', fn(Request $request) => $request->user());

Route::group(['as' => 'api.'], function (): void {
    Route::get('images', [\App\Http\Controllers\API\ImageController::class, 'index'])->name('images.index');
    Route::delete('images/destroy', [\App\Http\Controllers\API\ImageController::class, 'destroy'])->name('images.destroy');

    Route::get('admin/orders/{status?}/{reseller?}', [\App\Http\Controllers\API\OrderController::class, 'admin'])->name('orders.admin');
    Route::get('reseller/orders/{reseller?}/{status?}', [\App\Http\Controllers\API\OrderController::class, 'reseller'])->name('orders.reseller');

    Route::get('transactions/{status?}/{reseller?}', [\App\Http\Controllers\API\TransactionController::class, 'index'])->name('transactions.index');

    Route::get('resellers', [\App\Http\Controllers\API\ResellerController::class, 'index'])->name('resellers.index');
    Route::get('resellers/edit', [\App\Http\Controllers\API\ResellerController::class, 'edit'])->name('resellers.edit');
});

Route::get('/pathao', function (): void {
    Order::where('status', 'INVOICED')->get()->each(function (Order $order): void {
        $description = implode('\n', array_map(fn($item): string => $item['quantity'].' x '.$item['name'], $order->data['products']));

        $phone = $order->data['customer_phone'] ?? '';
        $phone = preg_replace('/[^0-9]/', '', $phone);
        $phone = preg_replace('/^88/', '', $phone);
    
        $data = [
            'store_id' => config('pathao.store_id'), // Find in store list,
            'merchant_order_id' => $order->id, // Unique order id
            'recipient_name' => $order->data['customer_name'] ?? 'N/A', // Customer name
            'recipient_phone' => $phone, // Customer phone
            'recipient_address' => $order->data['customer_address'] ?? 'N/A', // Customer address
            'recipient_city' => $order->data['city_id'], // Find in city method
            'recipient_zone' => $order->data['area_id'], // Find in zone method
            // "recipient_area"      => "", // Find in Area method
            'delivery_type' => 48, // 48 for normal delivery or 12 for on demand delivery
            'item_type' => 2, // 1 for document, 2 for parcel
            // "special_instruction" => $order->note,
            'item_quantity' => 1, // item quantity
            'item_weight' => $order->data['weight'] ?? 0.5, // parcel weight
            'amount_to_collect' => intval($order->data['payable']),
            'item_description' => $description, // product details
        ];

        try {
            $data = \App\Pathao\Facade\Pathao::order()->create($data);

            $order->update([
                'status' => 'SHIPPING',
                'status_at' => now()->toDateTimeString(),
                'data' => [
                    'booking_number' => $data->consignment_id,
                ],
            ]);
        } catch (\Exception $e) {
            dump($order, $data, $e->getMessage());
        }
    });
});

Route::post('pathao-webhook', function (Request $request) {
    // if ($request->header('X-PATHAO-Signature') != '248054') {
    //     return;
    // }

    if (! $order = Order::find($request->merchant_order_id)/*->orWhere('data->consignment_id', $request->consignment_id)->first()*/) {
        return response()->json(['message' => 'Order not found'], 402)
            ->header('X-Pathao-Merchant-Webhook-Integration-Secret', 'f3992ecc-59da-4cbe-a049-a13da2018d51');
    }

    // $courier = $request->only([
    //     'consignment_id',
    //     'order_status',
    //     'reason',
    //     'invoice_id',
    //     'payment_status',
    //     'collected_amount',
    // ]);
    // $order->forceFill(['courier' => ['booking' => 'Pathao'] + $courier]);

    $status = $order->status;
    if ($request->order_status_slug == 'Pickup_Cancelled') {
        $status = 'CANCELLED';
    } elseif ($request->order_status_slug == 'Delivered') {
        $status = 'COMPLETED';
    } elseif ($request->order_status_slug == 'Payment_Invoice') {

    } elseif ($request->order_status_slug == 'Return') {
        $status = 'FAILED';
        // TODO: add to stock
    }

    (new OrderController)->status($request->merge(['status' => $status, 'order_id' => [$order->id]]));

    return response()->json(['message' => 'Webhook processed'], 202)
        ->header('X-Pathao-Merchant-Webhook-Integration-Secret', 'f3992ecc-59da-4cbe-a049-a13da2018d51');
});