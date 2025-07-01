<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Property;
use App\Helpers\MyHelper;
use Illuminate\Support\Facades\Auth;

class PropertyCard extends Component
{
    public $class;
    public $footerClass;
    public $imgWrapperClass;
    public $imgClass;
    public $bodyClass;
    public $property;
    public $layout;
    public $showUploader = false;
    public $enquiryModal = false;

    // These two are coming from app service provider
    public $savedPropertyIds = [];
    public $compareIds = [];

    public function mount($property, $layout = null)
    {
        $this->layout = $layout;
        $this->property = $property;
    }

    protected $listeners = ['updatedFromCompareBox'];

    public function save($id)
    {
        if (Auth::check()) {
            $this->property->reactions()->attach($id, ['user_id' => Auth::user()->id]);

            // adding to local data
            array_push($this->savedPropertyIds, $id);
        } else {
            session()->flash('error', 'You need to login to save the propery.');
            return redirect()->to('/login');
        }
    }

    public function unsave($id)
    {
        $this->property->reactions()->where('property_id', $id)->detach();

        // removing from local data
        $position = array_search($id, $this->savedPropertyIds);

        if ($position !== false) {
            unset($this->savedPropertyIds[$position]);
        }
    }

    public function compare($id)
    {
        // updating local data
        array_push($this->compareIds, $id);

        // updating session data
        if (!session()->exists('compare')) {
            $ids = [];
        } else {
            $ids = session()->get('compare');
        }

        array_push($ids, $id);
        session()->put('compare', $ids);

        $this->emit('compareUpdated');
    }

    public function removeCompare($id)
    {
        $ids = session()->get('compare');
        $position = array_search($id, $ids);

        if ($position !== false) {
            unset($ids[$position]);
        }

        // updating local data
        $this->compareIds = $ids;

        session()->put('compare', $ids);
        $this->emit('compareUpdated');
    }

    public function updatedFromCompareBox()
    {
        $this->compareIds = session()->get('compare');

        if (empty($this->compareIds)) {
            // Then we need to remove the last remaining compare property
            $property = [];
        } else {
            $property = Property::whereIn('id', $this->compareIds)->get();
        }
    }

    public function render()
    {
        return view('livewire.property-card');
    }
}
