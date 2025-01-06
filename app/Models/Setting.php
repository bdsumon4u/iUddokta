<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['name', 'value'];
    protected function value(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(get: fn($data) => json_decode((string) $data), set: fn($data) => ['value' => json_encode($data)]);
    }
    protected function casts(): array
    {
        return [
            // 'value' => 'array',
        ];
    }
}
