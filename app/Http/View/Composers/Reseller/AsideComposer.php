<?php

namespace App\Http\View\Composers\Reseller;

use Illuminate\View\View;

class AsideComposer
{
    /**
     * Aside Tab
     */
    public $asideTab = [
        [
            'title' => 'Account',
            'id' => 'account',
            'view' => 'reseller.aside.account',
        ],
        [
            'title' => 'Earnings',
            'id' => 'earnings',
            'view' => 'reseller.aside.earnings',
        ],
    ];

    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $view->with('asideTab', $this->asideTab);
    }
}
