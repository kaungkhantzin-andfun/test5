<?php

namespace App\Http\Livewire\Dashboard;

use App\Helpers\MyHelper;
use App\Models\Image;
use App\Models\Slider;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EditSliders extends Component
{
    use WithFileUploads;

    public $oldType;
    public $type = 'slider';
    public $name;
    public $caption;
    public $img;
    public $oldImg;
    public $youtubeLink;
    public $linkError;
    public $createMode = false;
    public $slider;
    public $sliderMedia;

    public function mount(Slider $slider)
    {
        if ($slider->id) { // if editing the slider
            $this->sliderMedia = Image::where('imageable_id', $slider->id)->whereIn('imageable_type', ['slider', 'testimonial', 'youtube'])->first();
            $this->oldType = $this->sliderMedia->imageable_type;
            $this->type = $this->sliderMedia->imageable_type;

            $this->name = $slider->name;
            $this->oldImg = $this->sliderMedia->path;
            $this->youtubeLink = $this->sliderMedia->path;
            $this->caption = $this->sliderMedia->caption;
        } else {
            $this->createMode = true;
        }
    }

    protected $rules = [
        'name' => 'required',
        'img' => 'required|image',
        'youtubeLink' => 'required',
    ];

    protected $messages = [
        'name.required' => 'Name is required',
        'img.required' => 'Image is required.',
        'img.image' => 'Image must be a valid image.',
        'youtubeLink.required' => 'YouTube link is required',
    ];

    public function updateValidationRules()
    {
        if ($this->type == 'youtube') {
            unset($this->rules['img']);
        } else {
            unset($this->rules['youtubeLink']);
        }

        // image is not required in edit mode
        if (!$this->createMode) {
            unset($this->rules['img']);
        }
    }

    public function validateYoutubeLink()
    {
        // YouTube link contains validation
        if (!Str::contains($this->youtubeLink, 'youtu.be') && !Str::contains($this->youtubeLink, 'youtube.com')) {
            $this->linkError = true;
            return false;
        }

        $this->linkError = false;
    }

    public function updated()
    {
        $this->updateValidationRules();
        $this->validate();
        $this->validateYoutubeLink();
    }

    public function createItem()
    {
        $this->updateValidationRules();
        $this->validate();
        $this->validateYoutubeLink();

        // Careting slider entry
        $slider = Slider::create([
            'name' => $this->name,
        ]);

        // Creating image entry
        Image::create([
            'user_id' => Auth::user()->id,
            'path' => $this->getImagePath(),
            'caption' => $this->caption,
            'imageable_id' => $slider->id,
            'imageable_type' => $this->type,
        ]);

        session()->flash('success', 'The slider has been created successfully.');

        return redirect()->to('/dashboard/sliders');
    }

    public function getImagePath()
    {
        if ($this->type == 'youtube') {
            // Storing youtube link
            $img_path = $this->youtubeLink;
        } else {
            if ($this->type == 'testimonial') {
                $options = [
                    ['cropWidth' => 450, 'cropHeight' => 260],
                ];
            } else {
                $options = [
                    ['cropWidth' => 1920, 'cropHeight' => 700], // large slider
                    ['cropWidth' => 1024, 'cropHeight' => 576, 'namePrefix' => 'medium_'], // medium slider
                    ['cropWidth' => 640, 'cropHeight' => 360, 'namePrefix' => 'small_'], // small slider
                ];
            }

            $img_path = MyHelper::storeImage(
                image: $this->img,
                options: $options,
            );
        }

        return $img_path;
    }

    public function saveItem()
    {
        $this->updateValidationRules();
        $this->validate();
        $this->validateYoutubeLink();

        $this->slider->update([
            'name' => $this->name,
        ]);

        if ($this->oldType != 'youtube' && !empty($this->img) && !empty($this->oldImg)) {
            // Delete old image
            Storage::drive('public')->delete([$this->oldImg, 'medium_' . $this->oldImg, 'small_' . $this->oldImg]);

            $this->sliderMedia->update([
                'path' => $this->getImagePath(),
            ]);
        }

        // Storing youtube link
        if ($this->type == 'youtube') {
            // removing old image
            if (!empty($this->oldImg) && $this->sliderMedia->imageable_type != 'youtube') {
                Storage::drive('public')->delete([$this->oldImg, 'medium_' . $this->oldImg, 'small_' . $this->oldImg]);
            }

            $this->sliderMedia->update([
                'path' => $this->youtubeLink,
            ]);
        }

        // Creating image entry
        $this->sliderMedia->update([
            'caption' => $this->caption,
            'imageable_type' => $this->type,
        ]);

        session()->flash('success', 'The slider has been updated successfully.');

        return redirect()->to('/dashboard/sliders');
    }

    public function render()
    {
        return view('livewire.dashboard.edit-sliders')->layout('layouts.dashboard.master', ['title' => $this->createMode ? 'Create Slider' : 'Edit Slider']);
    }
}
