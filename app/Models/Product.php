<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    /**
     * Currency
     */
    protected $currency = 'BDT';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'code', 'stock', 'description', 'wholesale', 'retail',
    ];

    /**
     * Categories
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Product Images
     */
    public function images()
    {
        return $this->morphToMany(Image::class, 'imageable')->withPivot('zone')->withTimestamps();
    }

    /**
     * Base Image
     */
    public function baseImage()
    {
        return $this->images()->whereZone('base')->first();
    }

    /**
     * Additional Images
     */
    public function additionalImages()
    {
        return $this->images()->whereZone('additionals')->get();
    }

    public function getBaseImageAttribute()
    {
        return asset(optional($this->baseImage())->path);
    }

    public function getAdditionalImagesAttribute()
    {
        return $this->additionalImages()->map(function ($item) {
            $item->path = asset($item->path);

            return $item;
        });
    }

    public function getIsAvailableAttribute()
    {
        return $this->stock !== 0;
    }

    public function getAvailabilityAttribute()
    {
        return $this->isAvailable ? (is_null($this->stock) ? 'In Stock' : "<span class=\"bg-info\">$this->stock Available</span>") : '<span class="bg-danger">Out Of Stock</span>';
    }
}
