<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reseller_id', 'name', 'email', 'phone', 'logo', 'address', 'website',
    ];

    /**
     * Owner
     */
    public function owner()
    {
        return $this->belongsTo(Reseller::class, 'reseller_id', 'id');
    }
}
