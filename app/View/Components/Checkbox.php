<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Checkbox extends Component
{
    public $name, $value, $checked, $label, $type;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $value, $type, $label=null, $checked=false)
    {
        $this->name = $name;
        $this->value = $value;
        $this->checked = $checked;
        $this->label = $label?$label:$value;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.checkbox');
    }
}
