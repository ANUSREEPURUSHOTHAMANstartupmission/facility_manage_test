<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormCard extends Component
{
    public $action, $back, $link, $multipart;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($action, $back=null, $link=null, $multipart=false)
    {
        $this->action = $action;
        $this->back = $back;
        $this->link = $link;
        $this->multipart = $multipart;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.form-card');
    }
}
