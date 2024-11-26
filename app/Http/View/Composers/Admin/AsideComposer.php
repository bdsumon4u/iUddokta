<?php

namespace App\Http\View\Composers\Admin;

use Illuminate\View\View;

class AsideComposer
{
    /**
     * Aside Tab
     */
    public $asideTab = [
        [
            'title' => 'BaseSetting',
            'id' => 'base-setting',
            'view' => 'admin.aside.base-setting',
        ],
    ];

    /**
     * Bind data to the view.
     *
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('asideTab', $this->asideTab);
    }
}
