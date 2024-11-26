<?php

namespace App\View\Components\Layouts;

use Illuminate\View\Component;

class Aside extends Component
{
    public $asideTab;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($asideTab)
    {
        $this->asideTab = $asideTab;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.layouts.aside');
    }
}
