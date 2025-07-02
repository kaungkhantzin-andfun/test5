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
    public $selectedRegion = 'all-regions';

    public $adults = 1;
    public $children = 0;
    public $selectedDate;


    public $url;
    public $searchTerm = '';
    
    protected $queryString = [
        'searchTerm' => ['except' => ''],
        'selectedRegion' => ['except' => 'all-regions'],
        'selectedDate' => ['except' => ''],
        'adults' => ['except' => 1],
        'children' => ['except' => 0],
    ];
    public $filteredRegions = [];

    public $isHome;
    public $isDrawer;
    public $mainClass;
    public $searchWrapperClass;
    public $inputClass;
    public $class;
    public $class2;
    public $page = '';

    public function updatedSearchTerm($value)
    {
        $this->filteredRegions = $this->getFilteredRegions($value);
    }

    public function selectRegion($regionSlug)
    {
        $this->selectedRegion = $regionSlug;
        $region = Location::where('slug', $regionSlug)->first();
        if ($region) {
            $this->searchTerm = $region->name;
        }
        $this->filteredRegions = [];
    }

    protected function getFilteredRegions($searchTerm = '')
    {
        $query = Location::query();
        
        if (!empty($searchTerm)) {
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }
        
        return $query->limit(10)->get();
    }

    public function mount($selectedRegion = 'all-regions', $searchTerm = '', $selectedDate = null, $adults = 1, $children = 0)
    {
        // Set initial values from session or parameters
        $this->selectedRegion = $selectedRegion;
        $this->searchTerm = $searchTerm;
        $this->selectedDate = $selectedDate;
        $this->adults = $adults;
        $this->children = $children;
        
        $this->filteredRegions = $this->getFilteredRegions($searchTerm);
    }

    // customer wants to reload the page
    public function search()
    {
        $queryParams = [
            'location' => $this->selectedRegion,
            'date' => $this->selectedDate,
            'adults' => $this->adults,
            'children' => $this->children,
        ];

        return redirect()->to('/search?' . http_build_query($queryParams));
    }

    public function render()
    {
        return view('livewire.search-form');
    }
}
