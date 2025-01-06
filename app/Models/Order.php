<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reseller_id', 'data', 'status', 'created_at', 'updated_at',
    ];
    protected function data(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(get: fn($data): mixed =>
            // return unserialize($data);
            json_decode((string) $data, true), set: fn($data): array => ['data' => json_encode(array_merge($this->data ?? [], $data))]);
    }
    protected function shop(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(get: fn() => Shop::find($this->data['shop']));
    }
    protected function barcode(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(get: function () {
            $pad = str_pad($this->id, 10, '0', STR_PAD_LEFT);
            return substr($pad, 0, 3).'-'.substr($pad, 3, 3).'-'.substr($pad, 6, 4);
        });
    }

    /**
     * Scope Status
     */
    public function scopeStatus($query, $status)
    {
        return is_null($status) ? $query : $query->where('status', $status);
    }

    /**
     * Scope Completed Within
     */
    public function scopeCompletedWT($query, $timezone)
    {
        return $query->whereBetween('data->completed_at', $timezone);
    }

    /**
     * Scope Returned Within
     */
    public function scopeReturnedWT($query, $timezone)
    {
        return $query->whereBetween('data->returned_at', $timezone);
    }

    public function current_price()
    {
        $products = Product::whereIn('id', array_keys($this->data['products']))->get();
        $sum = $products->sum(fn($product): int|float => $product->wholesale * $this->data['products'][$product->id]['quantity']);

        return $sum;
    }

    /**
     * Reseller
     */
    public function reseller()
    {
        return $this->belongsTo(Reseller::class);
    }

    public function transactions()
    {
        return $this->belongsToMany(Transaction::class);
    }
}
