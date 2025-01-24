<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PageHeader extends Component
{
    public $heading, $subhead;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($heading, $subhead)
    {
        $this->heading = $heading;
        $this->subhead = $subhead;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.page-header');
    }
}
