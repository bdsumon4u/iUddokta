<?php

namespace App\Models;

use App\Helpers\Traits\CategoryModelHelper;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use CategoryModelHelper;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id', 'name', 'slug',
    ];

    /**
     * Products
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    protected function casts(): array
    {
        return [
            'id' => 'integer',
        ];
    }
}
