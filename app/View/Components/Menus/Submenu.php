<?php
// app/View/Components/Menus/Submenu.php

namespace App\View\Components\Menus;

use Illuminate\View\Component;

class Submenu extends Component
{
    public $items;

    public function __construct($items)
    {
        $this->items = $items;
    }

    public function render()
    {
        return view('components.menus.submenu');
    }
}
