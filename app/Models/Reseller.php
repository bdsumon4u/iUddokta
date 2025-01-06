<?php

namespace App\Models;

use App\Notifications\Reseller\ResetPassword;
use App\Notifications\Reseller\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Reseller extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone', 'password', 'payment', 'documents', 'verified_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    /**
     * Set Hashed Password Attribute
     *
     * @param  string  $password
     * @return void
     */
    protected function password(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(set: fn($password): array => ['password' => Hash::needsRehash($password)
                                        ? Hash::make($password)
                                        : $password]);
    }
    /**
     * Set Payment Attribute
     *
     * @param  array  $payment
     * @return void
     */
    protected function payment(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(set: fn($payment): array => ['payment' => json_encode($payment)]);
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new VerifyEmail);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPassword($token));
    }

    /**
     * Shops
     */
    public function shops()
    {
        return $this->hasMany(Shop::class, 'reseller_id', 'id');
    }

    public function shop()
    {
        return $this->hasOne(Shop::class, 'reseller_id', 'id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    protected function paid(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(get: fn() => $this->transactions->where('status', 'paid')->sum(fn($transaction) => $transaction->amount));
    }

    /**
     * Orders
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    protected function pendingOrders(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(get: fn() => $this->orders->where('status', 'PENDING'));
    }
    protected function nonPendingOrders(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(get: fn() => $this->orders->where('status', '!=', 'PENDING'));
    }
    protected function processingOrders(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(get: fn() => $this->orders->where('status', 'PROCESSING'));
    }
    protected function shippingOrders(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(get: fn() => $this->orders->where('status', 'SHIPPING'));
    }
    protected function completedOrders(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(get: fn() => $this->orders->where('status', 'DELIVERED'));
    }
    protected function returnedOrders(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(get: fn() => $this->orders->where('status', 'FAILED'));
    }
    protected function totalSell(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(get: fn() => $this->orders->sum(fn($order) => $order->data['sell']));
    }
    protected function pendingSell(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(get: fn() => $this->pending_orders->sum(fn($order) => $order->data['sell']));
    }
    protected function processingSell(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(get: fn() => $this->processing_orders->sum(fn($order) => $order->data['sell']));
    }
    protected function shippingSell(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(get: fn() => $this->shipping_orders->sum(fn($order) => $order->data['sell']));
    }
    protected function completedSell(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(get: fn() => $this->completed_orders->sum(fn($order) => $order->data['sell']));
    }
    protected function returnedSell(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(get: fn() => $this->returned_orders->sum(fn($order) => $order->data['sell']));
    }
    /**
     * Balance
     */
    protected function balance(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(get: function () {
            $non_pending = $this->non_pending_orders;
            $completed = $this->completed_orders;
            $returned = $this->returned_orders;
            $completed_advanced = $completed->sum(fn($order) => $order->data['advanced']);
            $completed_shipping = $completed->sum(fn($order) => $order->data['shipping']);
            $completed_buy = $completed->sum(fn($order) => $order->data['buy_price'] ?? $order->data['price']);
            // $non_pending_charges = $non_pending->sum(function($order){ return $order->data['delivery_charge'] + $order->data['packaging'] + $order->data['cod_charge']; });
            $completed_charges = $completed->sum(fn($order): float|int|array => $order->data['delivery_charge'] + $order->data['packaging'] + $order->data['cod_charge']);
            $returned_charges = $returned->sum(fn($order): float|int|array => $order->data['delivery_charge'] + $order->data['packaging'] + $order->data['cod_charge']);
            // $balance = $this->completed_sell - $completed_advanced - $completed_buy - $non_pending_charges + $completed_shipping - ($this->paid);
            $balance = $this->completed_sell - $completed_advanced - $completed_buy - $completed_charges - $returned_charges + $completed_shipping - ($this->paid);
            return $balance;
        });
    }
    /**
     * Get Payment Methods Attribute
     */
    protected function paymentMethods(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(get: function () {
            $payment_methods = [];
            $methods = $this->payment ?? [];
            foreach ($methods as $method) {
                $payment_methods[$method->method] ??= $method;
            }
            return $payment_methods;
        });
    }
    protected function lastPaid(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(get: fn() => $this->transactions->last() ?? new Transaction);
    }
    /**
     * The attributes that should be cast to native types.
     *
     * @return array
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'payment' => 'object',
            'documents' => 'object',
        ];
    }
}
