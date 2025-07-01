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
    public $searchTerm = '';
    
    protected $queryString = [
        'searchTerm' => ['except' => ''],
        'selectedType' => ['except' => 'properties'],
        'selectedPurpose' => ['except' => 'all-purposes'],
        'selectedRegion' => ['except' => 'all-regions'],
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
        $this->updateTownships();
    }

    protected function getFilteredRegions($searchTerm = '')
    {
        $query = Location::query();
        
        if (!empty($searchTerm)) {
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }
        
        return $query->get();
    }

    public function mount($price = [], $selectedType = 'properties', $selectedPurpose = 'all-purposes', $selectedRegion = 'all-regions', $searchTerm = '')
    {
        // Set initial values from session or parameters
        $this->selectedType = $selectedType;
        $this->selectedPurpose = $selectedPurpose;
        $this->selectedRegion = $selectedRegion;
        $this->searchTerm = $searchTerm;
        
        $this->updateTownships();
        $this->filteredRegions = $this->getFilteredRegions($searchTerm);

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
        // Store search parameters in session
        session([
            'search_type' => $this->selectedType,
            'search_purpose' => $this->selectedPurpose,
            'search_region' => $this->selectedRegion,
            'search_term' => $this->searchTerm
        ]);
        
        // Get the current scheme and host from the request
        $scheme = request()->getScheme();
        $host = request()->getHost();
        $port = request()->getPort();
        
        // Build the base URL
        $baseUrl = "{$scheme}://{$host}";
        if (!in_array($port, [80, 443])) {
            $baseUrl .= ":{$port}";
        }
        
        // Build the search path
        $path = '/search/' . implode('/', [
            $this->selectedType,
            $this->selectedPurpose,
            $this->selectedRegion,
            $this->selectedTownship,
            $this->price['min'],
            $this->price['max'],
            $this->keyword ?: ''
        ]);
        
        // Remove any double slashes that might occur from empty values
        $path = preg_replace('#/+#', '/', $path);
        
        // Remove trailing slashes
        $path = rtrim($path, '/');
        
        // Build the full URL
        $url = $baseUrl . $path;
        
        return redirect()->to($url);
    }

    public function render()
    {
        return view('livewire.search-form');
    }
}
