<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    protected $fillable = ['filename', 'disk', 'path', 'extension', 'mime', 'size'];

    /**
     * Get the file's path.
     *
     * @param  string  $path
     * @return string|null
     */
    // public function getPathAttribute($path)
    // {
    //     if (! is_null($path)) {
    //         return Storage::disk($this->disk)->url($path);
    //     }
    // }

    public function products()
    {
        return $this->morphedByMany(Product::class, 'imageable');
    }
}
