<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Image;
use Livewire\Component;
use App\Models\Category;
use App\Models\Location;
use App\Models\Property;
use App\Helpers\MyHelper;
use App\Jobs\ProcessImage;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use App\Models\PropertyPurpose;
use App\Models\PropertyTranslation;
use Livewire\TemporaryUploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Stichoza\GoogleTranslate\GoogleTranslate;

class EditProperties extends Component
{
    use WithFileUploads;

    public $property;

    public $selectedLocation = [
        'region' => '',
        'township' => '',
    ];
    public $townships = []; //to loop through

    public $purposes; //to loop through
    public $translations = [];
    public $images = [];
    public $categories = [];
    public $selectedFacilities = [];
    public $createMode;
    public $newSlug = false;
    public $noRoom;
    // this must be in array format so that old values won't be destroyed when user changes type
    public $area = [
        'type' => 'acre',
    ];

    public function mount(Property $property)
    {
        if ($property->id) { // if editing the property
            MyHelper::checkOwner($property);

            // if duplicate & edit
            if (isset($_GET['slug'])) {
                $this->newSlug = true;
            }

            if (count($property->location) > 0) {
                $region = $property->location->whereNull('parent_id')->first();
                $this->selectedLocation['region'] = $region->id ?? 0;

                $this->updateTownships();

                $tsp = $property->location->whereNotNull('parent_id')->first();
                $this->selectedLocation['township'] = $tsp->id ?? 0;
            }

            // Otherwise, proceed as usual
            // Alpine Js only works with string, see more (https://github.com/livewire/livewire/issues/788#issuecomment-607481499)
            $this->selectedFacilities = array_map('strval', $property->categories->pluck('id')->all());

            // Update facilities list
            $this->updateFacilities();

            // preparing area field
            // read more about @ operator: https://www.php.net/manual/en/language.operators.errorcontrol.php
            $area = @unserialize($property->area);
            if ($area !== false) {
                // then area is in new format with different types
                foreach ($area as $key => $value) {
                    $this->area['type'] = $key;
                    $this->area[$key] = $value;
                }
            } else {
                // area is in old format (a string)
                $this->area['type'] = 'acre';
                $this->area['acre'] = $property->area;
            }

            // Getting uploaded images
            $this->images = Image::where('imageable_type', 'property')->where('imageable_id', $property->id)->get()->toArray();

            // Getting the translations
            foreach ($property->detail as $content) {
                $this->translations[$content->locale] = [
                    'id' => $content->id,
                    'title' => $content->title,
                    'detail' => $content->detail,
                ];
            }
        } else {
            $this->createMode = true;

            // creating a blank property object
            $this->property = new Property();

            // Remembering in session for the select boxes
            $this->property->type_id = session()->get('type_id');
            $this->property->property_purpose_id = session()->get('property_purpose_id');

            // get region
            $this->selectedLocation['region'] = session()->get('region');

            // get township list depending on region
            $this->updateTownships();

            // Update facilities list
            $this->updateFacilities();

            // get township
            $this->selectedLocation['township'] = session()->get('township');

            $this->area['type'] = session()->get('area') ?? 'acre';
        }

        // Get property purposes
        $this->purposes = PropertyPurpose::all();
    }

    protected $rules = [
        'property.type_id' => 'required|integer',
        'property.property_purpose_id' => 'required|integer',
        'selectedLocation.region' => 'required',
        'selectedLocation.township' => 'required',
        'property.price' => 'required',
        'property.installment' => '',
        'property.parking' => 'integer',
        'property.beds' => 'integer',
        'property.baths' => 'integer',
        'area.type' => 'required',

        'translations.my.title' => 'required',
        'translations.my.detail' => 'required',

        'images.*' => 'mimes:jpeg,jpg,png,gif|required',
    ];

    public function messages()
    {
        return [
            'property.type_id.required' => trans('validation.required', ['attribute' => __('Type')]),
            'property.property_purpose_id.required' => trans('validation.required', ['attribute' => __('Purpose')]),
            'selectedLocation.region.required' => trans('validation.required', ['attribute' => __('Region')]),
            'selectedLocation.township.required' => trans('validation.required', ['attribute' => __('Township')]),
            'property.price.required' => trans('validation.required', ['attribute' => __('Price')]),
            'area.required' => trans('validation.required', ['attribute' => __('Area')]),
            'area.acre.required' => trans('validation.required', ['attribute' => __('Acre')]),
            'area.square_feet.required' => trans('validation.required', ['attribute' => __('Square feet')]),
            'area.square_meters.required' => trans('validation.required', ['attribute' => __('Square meter')]),
            'area.length_width.0.required' => trans('validation.required', ['attribute' => __('Length')]),
            'area.length_width.1.required' => trans('validation.required', ['attribute' => __('Width')]),

            'translations.my.title.required' => trans('validation.required', ['attribute' => __('Title')]),
            'translations.my.detail.required' => trans('validation.required', ['attribute' => __('Detail')]),

            'images.*.image' => 'All images must be valid image type.',
        ];
    }

    public function updated()
    {
        $this->updateValidationRules();
        $this->validate();
    }

    // Making it possible for user to add image again and again without saving the property
    // Overriding livewire's finishUpload function from WithFileUploads trait to keep the uploaded images on adding images
    public function finishUpload($name, $tmpPath)
    {
        $this->cleanupOldUploads();

        $files = collect($tmpPath)->map(function ($i) {
            return TemporaryUploadedFile::createFromLivewire($i);
        })->toArray();
        $this->emitSelf('upload:finished', $name, collect($files)->map->getFilename()->toArray());

        // merge it to persist uploaded images
        $files = array_merge($this->getPropertyValue($name), $files);
        $this->syncInput($name, $files);
    }

    public function updateFacilities()
    {
        // Get respective facilities
        $this->categories = Category::where('of', 'property')->whereNotNull('parent_id')->when($this->property->type_id, function ($query) {
            $query->where('parent_id', $this->property->type_id);
        })->get();
    }

    public function updateResetFacilities()
    {
        $this->updateFacilities();
        $this->selectedFacilities = [];
    }

    public function updateTownships()
    {
        if (!empty($this->selectedLocation['region'])) {
            $this->townships = Location::where('parent_id', $this->selectedLocation['region'])->get();
        }
    }

    public function createItem()
    {
        // count and limit images upto 10
        // $this->countImages();

        // remembering the selected selects, radio buttons, etc
        $this->rememberSelections();

        $this->updateValidationRules();

        // validate to save
        $this->validate();

        // Preparing data serialization for area field
        // user could change the type and filled for multiple types, so taking the items we need only
        $area[$this->area['type']] = $this->area[$this->area['type']];

        // Creating property entry
        $this->property = Property::create([
            'user_id' => Auth::user()->id,
            'slug' => $this->decideSlug(),
            'price' => $this->property['price'],
            'type_id' => $this->property['type_id'],
            'property_purpose_id' => $this->property['property_purpose_id'],
            'parking' => $this->property['parking'] ?: 0,
            'area' => serialize($area),
            'beds' => $this->property['beds'] ?: 0,
            'baths' => $this->property['baths'] ?: 0,
            'installment' => $this->property['installment'],
            'stat' => 0,
        ]);

        // Create location property entries
        $this->property->location()->sync(array_values($this->selectedLocation));

        // Property translations entries
        foreach ($this->translations as $locale => $content) {
            if (!empty($content['title']) && !empty($content['detail'])) {
                PropertyTranslation::create([
                    'property_id' => $this->property['id'],
                    'locale' => $locale,
                    'title' => $content['title'],
                    'detail' => $this->modifyContentLinks($content['detail']),
                ]);
            }
        }

        // Syncing facilities entries
        $this->property->categories()->sync($this->selectedFacilities);

        $this->createImageRecords();

        session()->flash('success', 'Property created! Images will take some time for processing.');

        return redirect()->to('/dashboard/properties');
    }

    public function saveItem()
    {
        MyHelper::checkOwner($this->property);

        // count and limit images upto 10
        // $this->countImages();

        // remembering the selected selects, radio buttons, etc
        $this->rememberSelections();

        $this->updateValidationRules();
        $this->validate();

        // if comes from duplicate function, new slug must be saved
        if ($this->newSlug) {
            $this->property->slug = $this->decideSlug();
        }

        // user could change the type and filled for multiple types
        // so taking the items we need only
        // $area['type'] = $this->area['type'];
        $area[$this->area['type']] = $this->area[$this->area['type']];
        $this->property->area = serialize($area);

        // Saving the property
        $this->property->save();

        // Create location property entries
        $this->property->location()->sync(array_values($this->selectedLocation));

        // Saving property translations entries
        foreach ($this->translations as $locale => $content) {
            if (!empty($content['title']) || !empty($content['detail'])) {
                if (array_key_exists('id', $content)) {
                    PropertyTranslation::where('id', $content['id'])->update([
                        'title' => $content['title'],
                        'detail' => $this->modifyContentLinks($content['detail'])
                    ]);
                } else {
                    PropertyTranslation::create([
                        'property_id' => $this->property['id'],
                        'locale' => $locale,
                        'title' => array_key_exists('title', $content) ? $content['title'] : '',
                        'detail' => array_key_exists('detail', $content) ? $content['detail'] : '',
                    ]);
                }
            }
        }

        // Syncing facilities entries
        $this->property->categories()->sync(array_values($this->selectedFacilities));

        $this->createImageRecords();

        session()->flash('success', 'The property has been updated!');
        return redirect()->to('/dashboard/properties');
    }

    public function createImageRecords()
    {
        // this function is for both create and update property
        if (!empty($this->images)) {
            // Storing the files & create image db records
            $i = 0;
            foreach ($this->images as $index => $image) {
                // existing images are in array format
                if (is_array($image)) {
                    // existing images need their order to be updated if user rearranged the order
                    Image::find($image['id'])->update([
                        'order' => $index
                    ]);

                    /**
                     * The first image can be got deleted or it's order can be change
                     * so we need to check it every time and regenerate card_ version of first image if needed
                     */
                    if ($i == 0 && !Storage::disk('public')->exists('card_' . $image['path'])) {
                        ProcessImage::dispatch(
                            realPath: storage_path('app/public/' . $image['path']),
                            uniqueName: $image['path'],
                            options: [
                                ['cropWidth' => 415, 'namePrefix' => 'card_'],
                            ]
                        );
                    }
                } else {
                    // handle newly uploaded images
                    if ($i == 0) {
                        // store first image without queueing to show it as thumbnail as soon as redirect back
                        $path = MyHelper::storeImage(
                            image: $image,
                            options: [
                                // only thumb_ version is required to show immediately
                                ['cropWidth' => 150, 'cropHeight' => 70, 'namePrefix' => 'thumb_'],
                            ],
                            queue: false
                        );

                        // the rest two versions can be generated in background
                        $realPath = $image->getRealPath();
                        ProcessImage::dispatch(
                            realPath: $realPath,
                            uniqueName: $path,
                            options: [
                                // large size image
                                ['watermark' => true],
                                // card_ version
                                ['cropWidth' => 415, 'namePrefix' => 'card_'],
                            ]
                        );
                    } else {
                        $path = MyHelper::storeImage(
                            image: $image,
                            options: [
                                // card_ version is not needed for the rest images
                                ['watermark' => true], // large size image
                                ['cropWidth' => 150, 'cropHeight' => 70, 'namePrefix' => 'thumb_'], // thumb_ version
                            ]
                        );
                    }

                    // Saving the returned image path
                    $this->property->images()->create([
                        'user_id' => Auth::user()->id,
                        'path' => $path,
                        'order' => $index
                    ]);
                }

                $i++;
            }
        }
    }

    public function updateValidationRules()
    {
        if (!$this->createMode) {
            unset($this->rules['images.*']);
        }

        if (!empty($this->area['type'])) {
            if ($this->area['type'] == 'length_width') {
                $this->rules["area." . $this->area['type'] . '.0'] = 'required';
                $this->rules["area." . $this->area['type'] . '.1'] = 'required';
            } else {
                $this->rules["area." . $this->area['type']] = 'required';
            }
        }

        if (in_array($this->property->type_id, [7, 14])) {
            unset($this->rules['property.parking']);
            unset($this->rules['property.beds']);
            unset($this->rules['property.baths']);
        } else {
            $this->rules['property.parking'] = 'integer';
            $this->rules['property.beds'] = 'integer';
            $this->rules['property.baths'] = 'integer';
        }
    }

    public function rememberSelections()
    {
        session()->put('type_id', $this->property->type_id);
        session()->put('property_purpose_id', $this->property->property_purpose_id);
        session()->put('region', $this->selectedLocation['region']);
        session()->put('township', $this->selectedLocation['township']);
        session()->put('area', $this->area['type']);
        session()->put('installment', $this->property->installment);
        session()->put('selectedFacilities', $this->selectedFacilities);
    }

    public function modifyContentLinks($content)
    {
        // remove attributes first to avoid duplications
        $content = str_replace(' rel="nofollow" target="_blank"', '', $content);
        // then add attributes again
        $content = str_replace('<a', '<a rel="nofollow" target="_blank"', $content);

        return $content;
    }

    public function countImages()
    {
        $existingCount = $this->createMode ? 0 : $this->property->images()->count();

        // current upload count
        $currentUploadCount = count($this->images);

        if ($existingCount + $currentUploadCount > 10) {
            abort(403, 'Total images cannot exceed 10. Remove old ones or re-select new images.');
        }
    }

    public function updateImageOrder($orderData)
    {
        $newImgArr = [];

        foreach ($orderData as $item) {
            $newImgArr[$item['order']] = $this->images[$item['value']];
        }

        $this->images = $newImgArr;
    }


    public function delImage($index)
    {
        // if array has index
        if (array_key_exists($index, $this->images)) {
            $local_img = $this->images[$index];

            // // remove from local images array
            unset($this->images[$index]);

            // remove from db
            if (is_array($local_img) && array_key_exists('id', $local_img) && !empty($local_img['id'])) {
                $img = Image::find($local_img['id']);

                // Check if user own the image
                MyHelper::checkOwner($img);

                // deleting the image files
                Storage::drive('public')->delete([$img->path, 'card_' . $img->path, 'thumb_' . $img->path]);
                // deleting the image record
                $img->delete();
            }

            $this->dispatchBrowserEvent('notice', ['type' => 'success', 'text' => 'The image has been deleted!']);
        }
    }

    public function decideSlug()
    {
        if (array_key_exists('en', $this->translations) && $this->translations['en']['title']) {
            $temp_slug = Str::slug($this->translations['en']['title']);
        } else {
            try {
                $tr = new GoogleTranslate();
                $temp_slug = Str::slug($tr->translate($this->translations['my']['title']));
            } catch (\Throwable $th) {
                // throw $th;
                $temp_slug = Str::slug($this->translations['my']['title']);
            }
        }

        // limit slug length
        $temp_slug = Str::limit($temp_slug, 20, '');

        // deciding the slug
        //  to avoid duplicate slug, checking existing slug and adding id at the end if it does
        if (Property::where('slug', $temp_slug)->doesntExist()) {
            $slug = $temp_slug;
        } else {
            $slug = $temp_slug . '-' . uniqid();
        }

        return $slug;
    }

    public function render()
    {
        // return view('livewire.dashboard.edit-properties')->layout('layouts.dashboard.master', ['title' => $this->createMode ? __('Create Property') : __('Edit Property')]);
        return view('livewire.dashboard.edit-properties')->layout(Auth::user()->role === 'remwdstate20' ? 'layouts.dashboard.master' : 'layouts.app', ['title' => $this->createMode ? __('Create Property') : __('Edit Property')]);
    }
}
