<?php

namespace App\View\Components;

use Illuminate\View\Component;

class NavItem extends Component
{

    public $label, $permissions, $type, $link;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label, $link="#", $permissions=null, $type=false)
    {
        $this->label = $label;
        $this->permissions = $permissions;
        $this->type = $type;
        $this->link = $link;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.nav-item');
    }
}
