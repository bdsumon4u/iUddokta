<?php

namespace App\Http\View\Composers;

use App\Models\Setting;
use Illuminate\View\View;

class SettingComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $settings = cache('settings', function () {
            $settings = Setting::all()->groupBy('name')->map(fn ($item) => $item->last()->value)->toArray();
            cache(['settings' => $settings]);

            return $settings;
        });
        // dd($settings);
        foreach ($settings as $key => $val) {
            $view->with($key, $val);
        }
    }
}
