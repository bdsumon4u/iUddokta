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
        return $this->morphToMany(Image::class, 'imageable')->withPivot('zone');
    }

    /**
     * Base Image
     */
    public function baseImage()
    {
        return $this->images()->whereZone('base');
    }

    /**
     * Additional Images
     */
    public function additionalImages()
    {
        return $this->images()->whereZone('additionals');
    }

    public function getBaseImageAttribute()
    {
        if (! $this->relationLoaded('baseImage')) {
            $this->load('baseImage');
        }
        return asset($this->getRelation('baseImage')?->first()?->path);
    }

    public function getAdditionalImagesAttribute()
    {
        if (! $this->relationLoaded('additionalImages')) {
            $this->load('additionalImages');
        }

        return $this->getRelation('additionalImages')->map(function ($item) {
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
