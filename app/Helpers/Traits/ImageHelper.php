<?php

namespace App\Helpers\Traits;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

trait ImageHelper
{
    protected function uploadImage($file, $arg = [])
    {
        $arg += [
            'dir' => 'images',
            'width' => 250,
            'height' => 66,
        ];
        $path = implode('/', [
            date('d-M-Y'),
            $arg['dir'],
            time(),
        ]).'-'.preg_replace('/\s+/', '-', $file->getClientOriginalName());

        $image = Image::make($file)->resize($arg['width'], $arg['height']);
        Storage::disk('public')->put($path, (string) $image->encode());

        return Storage::url($path);
    }
}
