<?php

namespace App\Http\Livewire\Compare;

use App\Models\Property;
use Livewire\Component;

class CompareBox extends Component
{
    public $compareIds;
    public $compareProperties = [];

    public function mount()
    {
        $this->compareUpdated();
    }

    public function removeCompare($id)
    {
        $ids = session()->get('compare');
        $position = array_search($id, $ids);

        if ($position !== false) {
            unset($ids[$position]);
        }

        session()->put('compare', $ids);

        $this->compareProperties = Property::whereIn('id', $ids)->with('images')->get();

        // for compare page
        $this->emit('updatedFromCompareBox');
    }

    // from home page & compare page to this compare box component
    protected $listeners = ['compareUpdated'];

    public function compareUpdated()
    {
        $this->compareIds = session()->get('compare');

        if (empty($this->compareIds)) {
            // Then we need to remove the last remaining compare property 
            $this->compareProperties = [];
        } else {
            $this->compareProperties = Property::whereIn('id', $this->compareIds)->with('images')->get();
        }
    }

    public function render()
    {
        return view('livewire.compare.compare-box');
    }
}
