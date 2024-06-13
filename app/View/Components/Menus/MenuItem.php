<?php

// app/View/Components/Menus/MenuItem.php

namespace App\View\Components\Menus;

use Illuminate\View\Component;

class MenuItem extends Component
{
    //selectable and selected
    public $selectable;
    public $selected;
    public $href;
    public $content;


    public function render()
    {
        return view('components.menus.menu-item');
    }
}
