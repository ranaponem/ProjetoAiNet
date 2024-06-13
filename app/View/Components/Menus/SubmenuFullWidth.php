<?php

namespace App\View\Components\Menus;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SubmenuFullWidth extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $uniqueName,
        public string $content = 'Submenu',
        public bool $selectable = true,
        public bool $selected = false,
    )
    {

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.menus.submenu-full-width');
    }
}
