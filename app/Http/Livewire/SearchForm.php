<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Location;
use App\Models\Property;
use Illuminate\Support\Str;
use App\Models\PropertyPurpose;

class SearchForm extends Component
{
    // these variable will be automatically assigned by livewire
    public $keyword;
    public $selectedType = 'properties';
    public $selectedPurpose = 'all-purposes';
    public $selectedRegion = 'all-regions';
    public $selectedTownship = 'all-townships';
    public $featured;

    public $price = [
        'min' => '',
        'max' => '',
        'all_min' => '',
        'all_max' => '',
    ];

    public $townships = [];
    public $purposes;
    public $url;

    public $isHome;
    public $isDrawer;
    public $mainClass;
    public $searchWrapperClass;
    public $inputClass;
    public $class;
    public $class2;
    public $page = '';

    public function mount($price = [])
    {
        $this->updateTownships();

        // other variables will be assigned automatically by livewire
        if (empty($price)) {
            // Getting min and max prices
            $this->price['min'] = $this->price['all_min'] = Property::min('price');
            $this->price['max'] = $this->price['all_max'] = Property::max('price');
        } else {
            $this->price = $price;
        }

        // Get property purposes
        $this->purposes = PropertyPurpose::select('id', 'slug', 'name')->get();
    }

    public function updateTownships()
    {
        if ($this->selectedRegion != null && $this->selectedRegion != 'all-regions') {
            $parent_location = Location::whereSlug($this->selectedRegion)->first();

            if (!empty($parent_location)) {
                $this->townships = Location::where('parent_id', $parent_location->id)->select('id', 'slug', 'name')->get();
            }
        } else {
            $this->townships = [];
        }
    }

    // customer wants to reload the page
    public function search()
    {
        $url =
            config('app.url') .
            '/search/' .
            $this->selectedType . '/' .
            $this->selectedPurpose . '/' .
            $this->selectedRegion . '/' .
            $this->selectedTownship . '/' .
            $this->price['min'] . '/' .
            $this->price['max'] . '/' .
            ($this->keyword ?: '');

        return redirect()->to($url);
    }

    public function render()
    {
        return view('livewire.search-form');
    }
}
