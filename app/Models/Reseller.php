<?php

namespace App\Models;

use App\Notifications\Reseller\ResetPassword;
use App\Notifications\Reseller\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
        'name', 'email', 'phone', 'password', 'inside_dhaka', 'outside_dhaka', 'payment', 'documents', 'verified_at',
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
     */
    protected function password(): Attribute
    {
        return Attribute::make(set: fn ($password): array => ['password' => Hash::needsRehash($password)
                                        ? Hash::make($password)
                                        : $password]);
    }

    /**
     * Set Payment Attribute
     *
     * @param  array  $payment
     */
    protected function payment(): Attribute
    {
        return Attribute::make(set: fn ($payment): array => ['payment' => json_encode($payment)]);
    }

    /**
     * Send the email verification notification.
     */
    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new VerifyEmail);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
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

    protected function paid(): Attribute
    {
        return Attribute::make(get: fn () => $this->transactions->where('status', 'PAID')->sum(fn ($transaction) => $transaction->amount));
    }

    /**
     * Orders
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    protected function pendingOrders(): Attribute
    {
        return Attribute::make(get: fn () => $this->orders->where('status', 'PENDING'));
    }

    protected function nonPendingOrders(): Attribute
    {
        return Attribute::make(get: fn () => $this->orders->where('status', '!=', 'PENDING'));
    }

    protected function processingOrders(): Attribute
    {
        return Attribute::make(get: fn () => $this->orders->where('status', 'PROCESSING'));
    }

    protected function shippingOrders(): Attribute
    {
        return Attribute::make(get: fn () => $this->orders->where('status', 'SHIPPING'));
    }

    protected function completedOrders(): Attribute
    {
        return Attribute::make(get: fn () => $this->orders->where('status', 'DELIVERED'));
    }

    protected function returnedOrders(): Attribute
    {
        return Attribute::make(get: fn () => $this->orders->where('status', 'FAILED'));
    }

    protected function totalSell(): Attribute
    {
        return Attribute::make(get: fn () => $this->orders->sum(fn ($order) => $order->data['sell']));
    }

    protected function pendingSell(): Attribute
    {
        return Attribute::make(get: fn () => $this->pending_orders->sum(fn ($order) => $order->data['sell']));
    }

    protected function processingSell(): Attribute
    {
        return Attribute::make(get: fn () => $this->processing_orders->sum(fn ($order) => $order->data['sell']));
    }

    protected function shippingSell(): Attribute
    {
        return Attribute::make(get: fn () => $this->shipping_orders->sum(fn ($order) => $order->data['sell']));
    }

    protected function completedSell(): Attribute
    {
        return Attribute::make(get: fn () => $this->completed_orders->sum(fn ($order) => $order->data['sell']));
    }

    protected function returnedSell(): Attribute
    {
        return Attribute::make(get: fn () => $this->returned_orders->sum(fn ($order) => $order->data['sell']));
    }

    /**
     * Balance
     */
    protected function balance(): Attribute
    {
        return Attribute::get(fn () => $this->orders()->where('status', 'DELIVERED')->whereDoesntHave('transactions')->get()->sum(fn ($item): int|float => ($item->data['profit'] ?? 0) - ($item->data['advanced'] ?? 0) - ($item->data['discount'] ?? 0)));
    }

    /**
     * Get Payment Methods Attribute
     */
    protected function paymentMethods(): Attribute
    {
        return Attribute::make(get: function () {
            $payment_methods = [];
            $methods = $this->payment ?? [];
            foreach ($methods as $method) {
                $payment_methods[$method->method] ??= $method;
            }

            return $payment_methods;
        });
    }

    protected function lastPaid(): Attribute
    {
        return Attribute::make(get: fn () => $this->transactions->last() ?? new Transaction);
    }

    /**
     * The attributes that should be cast to native types.
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
