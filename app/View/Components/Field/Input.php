<?php

namespace App\View\Components\Field;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $name,
        public string $type = 'text',
        public string $value = '',
        public string $label = '',
        public bool $readonly = false,
        public bool $required = false,
        public string $width = 'full',
    ) {
        $this->type = trim(strtolower($type));
        if (!in_array($this->type, ['text', 'password', 'number', 'email', 'date', 'time', 'datetime-local', 'month', 'week', 'range', 'color', 'file'], true)) {
            $this->type = 'text';
        }
        $this->width = trim(strtolower($width));
        if (!in_array($this->width, ['full', 'xs', 'sm', 'md', 'lg', 'xl', '1/3', '2/3', '1/4', '2/4', '3/4', '1/5', '2/5', '3/5', '4/5'], true)) {
            $this->width = 'full';
        }
        $this->label = trim($label) ?: $name;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.field.input');
    }
}
