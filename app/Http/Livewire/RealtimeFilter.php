<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Location;
use App\Models\Property;
use App\Helpers\MyHelper;
use Livewire\WithPagination;
use App\Models\PropertyPurpose;

class RealtimeFilter extends Component
{
    use WithPagination;
    // all values
    public $user;
    public $townships = []; //to loop through
    public $purposes; //to loop through

    // This component is used for 3 pages (home, directory » agent profile and user's saved properties)
    public $isHome;
    public $isSavedPage = false;

    // Selected values, also the variables from requested url
    public $perPage = 20;
    public $selectedType =  'properties';
    public $selectedPurpose = 'all-purposes';
    public $selectedRegion = 'all-regions';
    public $selectedTownship = 'all-townships';

    public $price = [
        'min' => '',
        'max' => '',
        'all_min' => '',
        'all_max' => '',
    ];

    public $keyword;
    public $sorting = 'price-asc';
    public $sortField = 'price';
    public $order = 'asc';

    public function mount()
    {
        // Getting min and max prices
        if ($this->isSavedPage) {
            $this->price['min'] = $this->price['all_min'] = $this->user->reactions()->min('price');
            $this->price['max'] = $this->price['all_max'] = $this->user->reactions()->max('price');
        } else {
            $this->price['min'] = $this->price['all_min'] = Property::where('user_id', $this->user->id)->min('price');
            $this->price['max'] = $this->price['all_max'] = Property::where('user_id', $this->user->id)->max('price');
        }

        // Get property purposes
        $this->purposes = PropertyPurpose::all();
    }

    public function resetFilter()
    {
        $this->selectedType = null;
        $this->selectedPurpose = null;
        $this->selectedLocation = [
            'region' => '',
            'township' => '',
        ];
    }

    public function updatedSorting()
    {
        $sort_array = explode('-', $this->sorting);
        $this->sortField = $sort_array[0];
        $this->order = $sort_array[1];
    }

    public function updateTownships()
    {
        if ($this->selectedRegion != null && $this->selectedRegion != 'all-regions') {
            $parent_id = Location::whereSlug($this->selectedRegion)->first()->id;
            $this->townships = Location::where('parent_id', $parent_id)->get();
        } else {
            $this->townships = [];
        }
    }

    public function getProperties()
    {
        if ($this->isSavedPage) {
            $properties = $this->user->reactions()
                ->whereBetween('price', [floatval($this->price['min']), floatval($this->price['max'])])
                ->when($this->selectedType != 'properties', function ($query) {
                    $query->whereHas('type', function ($query) {
                        $query->where('slug', $this->selectedType);
                    });
                })
                ->when($this->selectedPurpose != 'all-purposes', function ($query) {
                    $query->whereHas('purpose', function ($query) {
                        $query->where('slug', $this->selectedPurpose);
                    });
                })

                ->when($this->selectedRegion != 'all-regions', function ($query) {
                    $query->whereHas('location', function ($query) {
                        $query->where('locations.slug', $this->selectedRegion);
                    });
                })
                ->when($this->selectedTownship != 'all-townships', function ($query) {
                    $query->whereHas('location', function ($query) {
                        $query->where('locations.slug', $this->selectedTownship);
                    });
                })
                ->when($this->keyword != null, function ($query) {
                    $query->whereHas('detail', function ($query) {
                        $query->where('title', 'like', "%$this->keyword%")
                            ->orWhere('detail', 'like', "%$this->keyword%");
                    });
                })
                ->whereNull('soldout')
                ->with(['images', 'location', 'type', 'purpose', 'detail', 'user'])
                ->orderBy($this->sortField, $this->order);
        } else {
            // user must not empty in directory » agent profile page
            $properties = Property::when(!empty($this->user), function ($query) {
                $query->where('user_id', $this->user->id);
            })
                ->whereBetween('price', [floatval($this->price['min']), floatval($this->price['max'])])
                ->when($this->selectedType != 'properties', function ($query) {
                    $query->whereHas('type', function ($query) {
                        $query->where('slug', $this->selectedType);
                    });
                })
                ->when($this->selectedPurpose != 'all-purposes', function ($query) {
                    $query->whereHas('purpose', function ($query) {
                        $query->where('slug', $this->selectedPurpose);
                    });
                })
                ->when($this->selectedRegion != 'all-regions', function ($query) {
                    $query->whereHas('location', function ($query) {
                        $query->where('locations.slug', $this->selectedRegion);
                    });
                })
                ->when($this->selectedTownship != 'all-townships', function ($query) {
                    $query->whereHas('location', function ($query) {
                        $query->where('locations.slug', $this->selectedTownship);
                    });
                })
                ->when($this->keyword != null, function ($query) {
                    $query->whereHas('detail', function ($query) {
                        $query->where('title', 'like', "%$this->keyword%")
                            ->orWhere('detail', 'like', "%$this->keyword%");
                    });
                })
                ->whereNull('soldout')
                ->with(['images', 'location', 'type', 'purpose', 'detail', 'user'])
                ->orderBy($this->sortField, $this->order);
        }

        MyHelper::increaseViewCount($properties);

        return $properties;
    }

    public function render()
    {
        return view('livewire.realtime-filter', ['properties' => $this->getProperties()->paginate($this->perPage)]);
    }
}
