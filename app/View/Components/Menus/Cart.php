<?php

namespace App\View\Components\Menus;

use Illuminate\View\Component;

class Cart extends Component
{
    public $items;

    public function __construct($items = [])
    {
        $this->items = $items;
    }

    public function render()
    {
        return view('components.menus.cart');
    }
}
