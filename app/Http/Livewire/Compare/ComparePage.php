<?php

namespace App\Http\Livewire\Compare;

use Livewire\Component;
use App\Models\Property;

class ComparePage extends Component
{
    public $properties = [];
    public $categories;
    public $location;
    public $purpose;
    public $type;

    public function mount()
    {
        $ids = session()->get('compare');
        if (!empty($ids)) {

            $this->properties = Property::whereIn('id', $ids)->get();
        }
    }

    public function removeCompare($id)
    {
        $ids = session()->get('compare');
        $position = array_search($id, $ids);

        if ($position !== false) {
            unset($ids[$position]);
        }

        session()->put('compare', $ids);

        // for compare page
        $this->properties = Property::whereIn('id', $ids)->get();

        // for sidebar compare box
        $this->emit('compareUpdated');
    }

    protected $listeners = ['updatedFromCompareBox'];

    public function updatedFromCompareBox()
    {
        $this->compareIds = session()->get('compare');

        if (empty($this->compareIds)) {
            // Then we need to remove the last remaining compare property 
            $this->properties = [];
        } else {
            $this->properties = Property::whereIn('id', $this->compareIds)->get();
        }
    }


    public function render()
    {
        return view('livewire.compare.compare-page');
    }
}
