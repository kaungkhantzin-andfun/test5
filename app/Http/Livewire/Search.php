<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Location;
use App\Models\Property;
use App\Helpers\MyHelper;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use App\Models\PropertyPurpose;
use Illuminate\Support\Facades\Route;

class Search extends Component
{
    use WithPagination;

    // All values to loop through
    public $townships = []; //to loop through
    public $purposes; //to loop through

    // Selected values, also the variables from requested url
    public $perPage = 20;
    public $selectedType;
    public $selectedPurpose;
    public $selectedRegion;
    public $selectedTownship;
    public $url;
    public $pageTitle;
    public $pageDescription;

    public $price = [
        'min' => '',
        'max' => '',
        'all_min' => '',
        'all_max' => '',
    ];

    public $keyword;
    public $sorting = 'created_at-desc';
    public $sortField = 'created_at';
    public $order = 'asc';
    public $seoTitle;
    public $seoDescription;

    public function mount($type = 'properties', $purpose = 'all-purposes', $region = 'all-regions', $township = 'all-townships', $min = '', $max = '', $keyword = '')
    {
        // Search with property ID
        if (!empty($keyword) && (Str::contains(Str::lower($keyword), ['mhs-', 'mhr-', 'mh-']))) {
            $this->searchWithId($keyword);
        }

        $this->selectedType = $type;

        // for sale & for rent pages
        // we prefer short url for these pages
        if (Route::is('for-sale')) {
            $this->selectedPurpose = 'for-sale';
            $this->selectedRegion = 'all-regions';
            $this->selectedTownship = 'all-townships';
        } else if (Route::is('for-rent')) {
            $this->selectedPurpose = 'for-rent';
            $this->selectedRegion = 'all-regions';
            $this->selectedTownship = 'all-townships';
        } else {
            $this->selectedPurpose = $purpose;
        }

        if ($region == 'myanmar') {
            $this->selectedRegion = 'all-regions';
            $this->selectedTownship = 'all-townships';
        } else {
            $this->selectedRegion = $region;
            $this->updateTownships();
            $this->selectedTownship = $township;
        }

        // Getting overall min and max prices
        $this->price['all_min'] = Property::min('price');
        $this->price['all_max'] = Property::max('price');

        // user selected min and max prices
        $this->price['min'] = $min ?: $this->price['all_min'];
        $this->price['max'] = $max ?: $this->price['all_max'];

        $this->keyword = $keyword;

        $this->purposes = PropertyPurpose::all();

        $this->doSorting();

        // SEO Optimizations
        $this->prepareTitleDescription();
        $this->setSEOTitle();
        MyHelper::setGlobalSEOData($this->seoTitle, $this->seoDescription);
    }

    public function setSEOTitle()
    {
        $this->seoTitle = $this->pageTitle . ' - Myanmar House';
        $this->seoDescription = $this->pageDescription;

        // we want to set manual title & description for these pages
        if (Route::is('all-properties')) {
            $this->seoTitle = __('seo.all-properties.title');
            $this->seoDescription = __('seo.all-properties.description');
        } else if (Route::is('for-sale')) {
            $this->seoTitle = __('seo.for-sale.title');
            $this->seoDescription = __('seo.for-sale.description');
        } else if (Route::is('for-rent')) {
            $this->seoTitle = __('seo.for-rent.title');
            $this->seoDescription = __('seo.for-rent.description');
        }
    }

    public function searchWithId($keyword)
    {
        $propertyID = (int) filter_var($keyword, FILTER_SANITIZE_NUMBER_INT);
        $propertyID = str_replace('-', '', $propertyID);

        if (!empty($propertyID)) {
            $property = Property::findOrFail($propertyID);

            return redirect()->to("/properties/$property->id/$property->slug");
        }
    }

    public function prepareTitleDescription()
    {
        $type = Str::of($this->selectedType)->singular()->plural()->ucfirst()->replace('-', ' ');
        $purpose = $this->selectedPurpose != 'all-purposes' ? Str::of($this->selectedPurpose)->title()->replace('-', ' ') : null;
        $region = $this->selectedRegion != 'all-regions' ? Str::of($this->selectedRegion)->title()->replace('-', ' ') : null;
        $township = $this->selectedTownship != 'all-townships' ? Str::of($this->selectedTownship)->title()->replace('-', ' ') : null;

        // split the text "Region" and region name (i.e Yangon, Mandalay, ..)
        if (!empty($region)) {
            // split string by last space
            // Str::of returns Illuminate\Support\Stringable object
            // so type casting it to string
            $reg = preg_split("/\s+(?=\S*+$)/", (string) $region);
        }

        if (empty($region) && empty($township)) {
            $location = trans('Myanmar');
        } else if (!empty($region) && empty($township)) {
            // $location = trans($reg[0] ?? '') . ' ' . trans($reg[1] ?? '');
            $location = trans($reg[0] ?? '');
            // } else if (empty($region) && !empty($township)) {
        } else if (!empty($township)) {
            $location = app()->getLocale() == 'my' ? trans((string) $township) . 'မြို့နယ်' : trans((string) $township) . ' Township';
            // } else {
            //     $location = trans((string) $township) . ', ' . trans($reg[0] ?? '');
        }

        if (app()->getLocale() == 'my') {
            $this->pageTitle = $location . " ရှိ " . ($purpose ? trans((string) $purpose) . ' ' : '') . trans((string) $type);
            $this->pageDescription = $this->pageTitle . ' - ' . $location . ' ရှိ အကောင်းတကာ့ အကောင်းဆုံး ' . ($purpose ? trans((string) $purpose) . ' ' : '') . trans((string) $type) . ' ကို ' . __(config('app.name')) . ' ဝဘ်ဆိုက်မှာ ရှာဖွေလိုက်ပါ။';
        } else {
            $this->pageTitle = $type . ' ' . ($purpose ? $purpose . ' ' : '') . "in " . $location;
            $this->pageDescription = $this->pageTitle . '. Find the best ' . $type . ' ' . $purpose . ' in ' . $location . ' on ' . config('app.name') . '.';
        }
    }

    public function resetSearch()
    {
        // this function won't work for price range slider (took a lot of time getting it to work smoothly),
        // so not using and not removing so that we don't spend time on this again in future
        // $this->price = [];
        // $this->price['min'] = Property::all()->min('price');
        // $this->price['max'] = Property::all()->max('price');
        // $this->price['all_min'] = $this->price['min'];
        // $this->price['all_max'] = $this->price['max'];
        // $this->selectedType = 'properties';
        // $this->selectedPurpose = 'all-purposes';
        // $this->selectedRegion = 'all-regions';
        // $this->selectedTownship = 'all-townships';
    }

    protected $queryString = [
        'sorting' => ['except' => 'created_at-desc'],
    ];

    public function updated()
    {
        if ($this->selectedRegion == 'all-regions') {
            $this->selectedTownship = 'all-townships';
        }

        // reset page number to 1 so that user won't see empty result on page 3 or so while the result is not empty
        $this->resetPage();

        // Search with property ID
        if (!empty($this->keyword) && (Str::contains(Str::lower($this->keyword), ['mhs-', 'mhr-', 'mh-']))) {
            $this->searchWithId($this->keyword);
        }

        $this->doSorting();
        $this->setUrl();
    }

    public function doSorting()
    {
        if (!empty($this->sorting)) {
            $sort_array = explode('-', $this->sorting);
            $this->sortField = $sort_array[0];
            $this->order = $sort_array[1];
        }
    }

    public function setUrl()
    {
        $sorting = $this->sorting != 'price-asc' ? "sorting=$this->sorting" : null;
        // $page = (!empty($this->paginators) && array_key_exists('page', $this->paginators) && $this->paginators['page'] != 1) ? 'page=' . $this->paginators['page'] : null;

        $this->url =
            config('app.url') .
            (app()->getLocale() == 'en' ? '/en' : '') .
            "/search" .
            "/$this->selectedType" .
            "/$this->selectedPurpose" .
            "/$this->selectedRegion" .
            "/$this->selectedTownship" .
            "/" . $this->price['min'] .
            "/" . $this->price['max'] .
            ($this->keyword ? "/$this->keyword" : '') .
            // (!empty($sorting) || !empty($page) ? '?' : '') .
            // (!empty($sorting) ? $sorting : '') .
            // (!empty($sorting) && !empty($page) ? '&' : '') .
            // (!empty($page) ? $page : '');
            (!empty($sorting) ? "?$sorting" : '');

        // getting page title according to search
        $this->prepareTitleDescription();

        $this->dispatchBrowserEvent('replace-url', ['title' => $this->pageTitle . ' - Myanmar House', 'description' => $this->pageDescription, 'url' => $this->url]);
    }

    public function updateTownships()
    {
        if ($this->selectedRegion != null && $this->selectedRegion != 'all-regions') {
            // we're using slug for h1 tag generation
            $parent = Location::whereSlug($this->selectedRegion)->firstOrFail();
            $this->townships = Location::where('parent_id', $parent?->id)->select(['id', 'slug', 'name'])->get();
        } else {
            $this->townships = [];
        }
    }

    public function getProperties()
    {
        $properties = Property::whereBetween('price', [floatval($this->price['min']), floatval($this->price['max'])])
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

        // increase view count for each property
        MyHelper::increaseViewCount($properties);

        return $properties;
    }

    public function render()
    {
        return view('livewire.search', ['properties' => $this->getProperties()->paginate($this->perPage)]);
    }
}
