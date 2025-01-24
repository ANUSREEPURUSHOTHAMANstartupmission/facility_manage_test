<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SelectOption extends Component
{
    public $name, $value, $label, $selected;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $value, $label=null, $selected=false)
    {
        $this->name = $name;
        $this->value = $value;
        $this->selected = $selected;
        $this->label = $label?$label:$value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.select-option');
    }
}
