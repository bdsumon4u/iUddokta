<?php

namespace App\Repository;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingsRepository
{
    public function set($name, $value)
    {
        return Cache::put('settings', array_merge(cache('settings', fn () => Setting::all()->groupBy('name')->map(fn ($item) => $item->last()->value)->toArray()), [
            $name => Setting::updateOrCreate([
                'name' => $name,
            ], [
                'value' => $value,
            ])->value,
        ]));
    }

    public function setMany($data): void
    {
        foreach ($data as $name => $value) {
            $this->set($name, $value);
        }
    }

    public function get($name)
    {
        return Setting::where('name', $name)->get() ?? new Setting;
    }

    public function first($name)
    {
        return Setting::where('name', $name)->first() ?? new Setting;
    }
}
