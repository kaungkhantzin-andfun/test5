<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Property;
use App\Models\Booking;
use App\Helpers\MyHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Single extends Component
{
    public $property;
    public $facilities;
    public $similarProperties;
    public $seoImages;
    public $check_in_date;
    public $check_out_date;
    public $number_of_guests;

    protected $rules = [
        'check_in_date' => 'required|date|after_or_equal:today',
        'check_out_date' => 'required|date|after:check_in_date',
        'number_of_guests' => 'required|integer|min:1',
    ];

    public function mount($id)
    {
        $propertyBuilder = Property::with(['images', 'location', 'type', 'purpose', 'detail', 'user'])->where('id', $id);
        MyHelper::increaseViewCount($propertyBuilder);
        $this->property = $propertyBuilder->firstOrFail();


        if (count($this->property->images) > 0) {
            foreach ($this->property->images as $img) {
                $this->seoImages[] = config('app.url') . Storage::url($img->path);
            }
        }

        // Get respective facilities
        $this->facilities = $this->property->categories()->whereNotNull('parent_id')->get();

        // similar properties
        $this->similarProperties = $this->getSimilar()->get();

        // SEO Optimizations
        MyHelper::setGlobalSEOData($this->property?->translation?->title, $this->property?->shortDetail, $this->seoImages);
    }

    public function save()
    {
        if (Auth::check()) {
            $this->property->reactions()->attach($this->property->id, ['user_id' => Auth::user()->id]);
        } else {
            session()->flash('error', 'You need to login to save the propery.');
            return redirect()->to('/login');
        }
    }

    public function unsave()
    {
        $this->property->reactions()->where('property_id', $this->property->id)->detach();
    }

    public function compare($id)
    {
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

        session()->put('compare', $ids);
        $this->emit('compareUpdated');
    }

    public function getSimilar()
    {
        $price = $this->property->price;
        $tencents = $this->property->price * 0.1;
        $townships = $this->property->location()->whereNotNull('parent_id')->pluck('locations.id')->all();
        $region = $this->property->location()->whereNull('parent_id')->pluck('locations.id')->all();
        // priortizing the townships first
        $location = array_merge([$townships, $region]);

        $properties = Property::where('id', '<>', $this->property->id) // exclude current property
            ->whereBetween('price', [$price - $tencents, $price + $tencents])
            ->when($this->property->type_id != null, function ($query) {
                $query->where('type_id', $this->property->type_id);
            })
            ->when($this->property->property_purpose_id != null, function ($query) {
                $query->where('property_purpose_id', $this->property->property_purpose_id);
            })
            ->when(!empty($location), function ($query) use ($location) {
                $query->whereHas('location', function ($query) use ($location) {
                    $query->whereIn('locations.id', $location);
                });
            })
            ->whereNull('soldout')
            ->with(['images', 'location', 'type', 'purpose', 'detail'])
            ->take(8);

        MyHelper::increaseViewCount($properties);

        return $properties;
    }

    public function booking()
    {
        $this->validate();

        if (Auth::check()) {
            $booking = new Booking();
            $booking->user_id = Auth::user()->id;
            $booking->property_id = $this->property->id;
            $booking->check_in_date = $this->check_in_date;
            $booking->check_out_date = $this->check_out_date;
            $booking->number_of_guests = $this->number_of_guests;
            $booking->total_price = $this->property->price; // This is a placeholder. You should calculate the actual price.
            $booking->save();

            session()->flash('success', 'Property booked successfully.');
            session()->flash('booking_details', [
                'check_in_date' => $this->check_in_date,
                'check_out_date' => $this->check_out_date,
                'number_of_guests' => $this->number_of_guests,
            ]);

            $this->check_in_date = '';
            $this->check_out_date = '';
            $this->number_of_guests = '';
        } else {
            session()->flash('error', 'You need to login to book the property.');
            return redirect()->to('/login');
        }
    }

    public function render()
    {
        return view('livewire.single');
    }
}
