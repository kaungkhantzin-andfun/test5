<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SortIcon extends Component
{
    public $sortField;
    public $field;
    public $sortAsc;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($sortField, $field = '', $sortAsc)
    {
        $this->sortField = $sortField;
        $this->field = $field;
        $this->sortAsc = $sortAsc;
        // dd($sortField);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.sort-icon');
    }
}
