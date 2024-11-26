<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['name', 'value'];

    public function setValueAttribute($data)
    {
        $this->attributes['value'] = json_encode($data);
    }

    public function getValueAttribute($data)
    {
        return json_decode($data);
    }

    protected $casts = [
        // 'value' => 'array',
    ];
}
