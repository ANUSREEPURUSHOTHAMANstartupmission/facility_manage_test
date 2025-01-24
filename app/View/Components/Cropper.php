<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Cropper extends Component
{

    public $label, $name, $target, $width, $height, $value;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label, $name, $target, $width, $height, $value=null)
    {
        $this->label = $label;
        $this->name = $name;
        $this->target = $target;
        $this->width = $width;
        $this->height = $height;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.cropper');
    }
}
