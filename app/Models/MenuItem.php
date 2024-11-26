<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $fillable = ['menu_id', 'parent_id', 'title', 'url', 'order'];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
