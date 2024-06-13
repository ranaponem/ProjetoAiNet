<?php

namespace App\View\Components\Menus;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SubMenuItem extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $content = 'Submenu Item',
        public string $href = '#',
        public bool $selectable = true,
        public bool $selected = false,
        public string $form = '',
    )
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.menus.submenu-item');
    }
}
