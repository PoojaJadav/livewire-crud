<?php

namespace Poojajadav\LivewireCrud\View\Components;

use Illuminate\View\Component;

class Sort extends Component
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('livewire-crud::components.sort');
    }
}
