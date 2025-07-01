<?php

namespace App\Http\Livewire\Dashboard\Locations;

use App\Models\Image;
use Livewire\Component;
use App\Models\Location;
use App\Helpers\MyHelper;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as InterventionImage;

class EditLocation extends Component
{
    use WithFileUploads;

    public $location;
    public $townships;
    public $new_townships = [];
    public $del_id;
    public $img;
    public $firstImg;
    public $oldImg;
    public $createMode;

    public function mount(Location $location)
    {
        if ($location->id) {
            $this->townships = Location::where('parent_id', $location->id)->orderBy('name')->get();
            $this->firstImg = $location->image()->first();
            $this->oldImg = !empty($this->firstImg) ? $this->firstImg->path : null;
        } else {
            $this->townships = [];
            $this->createMode = true;
        }
    }

    protected $rules = [
        'location.name' => 'required|string',
        'img' => 'required|image',
        'location.description' => 'required',
        'location.postal_code' => 'integer',
        'townships.*.id' => 'required',
        'townships.*.name' => 'required',
    ];

    protected $messages = [
        'location.name.required' => 'Location name is required.',
        'img.required' => 'Image is required.',
        'img.image' => 'Image must be a valid image.',
        'location.description.required' => 'Description is required.',
        'townships.*.id.required' => 'Something went wrong.',
        'townships.*.name.required' => 'Township name is required.',
    ];

    public function updated()
    {
        $this->validate();
    }

    public function updateValidationRules()
    {
        if (!$this->createMode && !empty($this->oldImg)) {
            unset($this->rules['img']);
        }
    }

    public function confirmDel($index)
    {
        $this->del_id = $index;
    }

    public function deleteTownship($index, $id)
    {
        $this->townships->forget($index);
        Location::find($id)->delete();
        $this->del_id = null;
    }

    public function deleteNewTownship($index)
    {
        array_splice($this->new_townships, $index, 1);
        $this->del_id = null;
    }

    public function addTownship()
    {
        $this->new_townships[] = [
            'parent_id' => $this->createMode ? '' : $this->location->id,
            'name' => '',
            'slug' => '',
        ];
    }

    public function createLocation()
    {
        $this->validate();

        $location = Location::create([
            'name' => $this->location['name'],
            'slug' => Str::slug($this->location['name']),
            'postal_code' => $this->location['postal_code'],
            'description' => $this->location['description'],
        ]);

        // Creating image entry
        $location->image()->create([
            'user_id' => Auth::user()->id,
            'path' => $this->storeImage(),
        ]);

        // There will only be newly added townships, it is in create mode
        $this->loopTsp($this->new_townships, $location->id);

        session()->flash('success', 'The location has been created!');

        redirect()->to('/dashboard/locations');
    }

    public function saveLocation()
    {
        $this->updateValidationRules();
        $this->validate();

        // update slug
        $this->location->slug = Str::slug($this->location['name']);
        $this->location->save();

        if (!empty($this->img)) {

            if ($this->oldImg != null) {
                // Delete old image
                Storage::disk('public')->delete($this->oldImg);
            }

            if (empty($this->firstImg)) {
                // Creating image entry
                $this->location->image()->create([
                    'user_id' => Auth::user()->id,
                    'path' => $this->storeImage(),
                ]);
            } else {
                $this->location->image()->update([
                    'path' => $this->storeImage(),
                ]);
            }
        }

        foreach ($this->townships as $tsp) {
            $slug = Str::slug($tsp->name);

            if (Location::where('slug', $slug)->exists()) {
                // if the slug is already exists, add unique id
                $slug = $slug . '-' . uniqid();
            }

            $tsp->slug = $slug;
            $tsp->save();
        }

        // creating newly added townships
        $this->loopTsp($this->new_townships, $this->location->id);

        session()->flash('success', 'The location has been updated!');
        redirect()->to('/dashboard/locations');
    }

    public function storeImage()
    {
        $path = MyHelper::storeImage(
            image: $this->img,
            options: [
                ['cropWidth' => 400, 'cropHeight' => 267],
            ],
        );

        return $path;
    }

    public function loopTsp($tsp, $parent_id)
    {
        foreach ($tsp as $township) {
            Location::create([
                'parent_id' => $parent_id,
                'name' => $township['name'],
                'slug' => Str::slug($township['name']),
            ]);
        }
    }

    public function render()
    {
        return view('livewire.dashboard.locations.edit-location')->layout('layouts.dashboard.master', ['title' => $this->createMode ? 'Create Location' : 'Edit Location']);
    }
}
