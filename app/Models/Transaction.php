<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['reseller_id', 'amount', 'method', 'bank_name', 'account_name', 'branch', 'routing_no', 'account_type', 'account_number', 'transaction_number', 'status'];

    /**
     * Scope Status
     */
    public function scopeStatus($query, $status)
    {
        return is_null($status) ? $query : $query->where('status', $status);
    }

    /**
     * Reseller
     */
    public function reseller()
    {
        return $this->belongsTo(Reseller::class);
    }
}
