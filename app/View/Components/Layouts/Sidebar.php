<?php

namespace App\View\Components\Layouts;

use Illuminate\View\Component;

class Sidebar extends Component
{
    /**
     * Menu
     */
    public $menu;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($menu)
    {
        $this->menu = $menu ?: [];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.layouts.sidebar');
    }
}
