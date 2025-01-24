<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SearchSelect extends Component
{
    public $label, $name, $required, $route, $selected;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label, $name, $route, $required=true,  $selected=null)
    {
        $this->label = $label;
        $this->name = $name;
        $this->required = $required;
        $this->route = $route;
        $this->selected = $selected;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.search-select');
    }
}
