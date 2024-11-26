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

    public function setDataAttribute($data)
    {
        // $this->attributes['data'] = serialize($data);
        $this->attributes['data'] = json_encode($data);
    }

    public function getDataAttribute($data)
    {
        // return unserialize($data);
        return json_decode($data, true);
    }

    public function getShopAttribute()
    {
        return Shop::find($this->data['shop']);
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
        $sum = $products->sum(function ($product) {
            return $product->wholesale * $this->data['products'][$product->id]['quantity'];
        });

        return $sum;
    }

    /**
     * Reseller
     */
    public function reseller()
    {
        return $this->belongsTo(Reseller::class);
    }
}
