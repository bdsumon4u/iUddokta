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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'payment' => 'object',
        'documents' => 'object',
    ];

    /**
     * Set Hashed Password Attribute
     *
     * @param  string  $password
     * @return void
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::needsRehash($password)
                                        ? Hash::make($password)
                                        : $password;
    }

    /**
     * Set Payment Attribute
     *
     * @param  array  $payment
     * @return void
     */
    public function setPaymentAttribute($payment)
    {
        $this->attributes['payment'] = json_encode($payment);
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
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

    public function getPaidAttribute()
    {
        return $this->transactions->where('status', 'paid')->sum(fn($transaction) => $transaction->amount);
    }

    /**
     * Orders
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getPendingOrdersAttribute()
    {
        return $this->orders->where('status', 'PENDING');
    }

    public function getNonPendingOrdersAttribute()
    {
        return $this->orders->where('status', '!=', 'PENDING');
    }

    public function getProcessingOrdersAttribute()
    {
        return $this->orders->where('status', 'PROCESSING');
    }

    public function getShippingOrdersAttribute()
    {
        return $this->orders->where('status', 'SHIPPING');
    }

    public function getCompletedOrdersAttribute()
    {
        return $this->orders->where('status', 'DELIVERED');
    }

    public function getReturnedOrdersAttribute()
    {
        return $this->orders->where('status', 'FAILED');
    }

    public function getTotalSellAttribute()
    {
        return $this->orders->sum(fn($order) => $order->data['sell']);
    }

    public function getPendingSellAttribute()
    {
        return $this->pending_orders->sum(fn($order) => $order->data['sell']);
    }

    public function getProcessingSellAttribute()
    {
        return $this->processing_orders->sum(fn($order) => $order->data['sell']);
    }

    public function getShippingSellAttribute()
    {
        return $this->shipping_orders->sum(fn($order) => $order->data['sell']);
    }

    public function getCompletedSellAttribute()
    {
        return $this->completed_orders->sum(fn($order) => $order->data['sell']);
    }

    public function getReturnedSellAttribute()
    {
        return $this->returned_orders->sum(fn($order) => $order->data['sell']);
    }

    /**
     * Balance
     */
    public function getBalanceAttribute()
    {
        $non_pending = $this->non_pending_orders;
        $completed = $this->completed_orders;
        $returned = $this->returned_orders;

        $completed_advanced = $completed->sum(fn($order) => $order->data['advanced']);
        $completed_shipping = $completed->sum(fn($order) => $order->data['shipping']);

        $completed_buy = $completed->sum(fn($order) => $order->data['buy_price'] ?? $order->data['price']);
        // $non_pending_charges = $non_pending->sum(function($order){ return $order->data['delivery_charge'] + $order->data['packaging'] + $order->data['cod_charge']; });
        $completed_charges = $completed->sum(fn($order) => $order->data['delivery_charge'] + $order->data['packaging'] + $order->data['cod_charge']);
        $returned_charges = $returned->sum(fn($order) => $order->data['delivery_charge'] + $order->data['packaging'] + $order->data['cod_charge']);

        // $balance = $this->completed_sell - $completed_advanced - $completed_buy - $non_pending_charges + $completed_shipping - ($this->paid);
        $balance = $this->completed_sell - $completed_advanced - $completed_buy - $completed_charges - $returned_charges + $completed_shipping - ($this->paid);

        return $balance;
    }

    /**
     * Get Payment Methods Attribute
     */
    public function getPaymentMethodsAttribute()
    {
        $payment_methods = [];
        $methods = $this->payment ?? [];
        foreach ($methods as $method) {
            $payment_methods[$method->method] ??= $method;
        }

        return $payment_methods;
    }

    public function getLastPaidAttribute()
    {
        return $this->transactions->last() ?? new Transaction;
    }
}
