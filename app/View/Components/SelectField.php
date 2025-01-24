<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SelectField extends Component
{
    public $label, $name, $required, $model;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label, $name, $required=true, $model=null)
    {
        $this->label = $label;
        $this->name = $name;
        $this->required = $required;
        $this->model = $model;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.select-field');
    }
}
