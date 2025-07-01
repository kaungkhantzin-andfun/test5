<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Ad;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EditAds extends Component
{
    use WithFileUploads;

    public $ad;
    public $img;
    public $oldImg;
    public $createMode = false;
    public $acceptedDimension;

    public function mount(Ad $ad)
    {
        if ($ad->id) { // if editing the ad
            $this->oldImg = $this->ad->image->path;
        } else {
            $this->ad = new Ad;
            $this->createMode = true;
        }
    }

    protected $rules = [
        'ad.name' => 'required',
        'ad.placement' => 'required',
        'ad.link' => 'string',
        'ad.expiry' => 'required|date',
    ];

    protected $messages = [
        'img.required' => 'Ad image is required.',
        'img.image' => 'Your image format is not accepted.',
        'img.max' => 'Ad image cannot be larger than 1MB.',
        'img.dimensions' => 'The image dimesions is not suitable for this placement.',

        'ad.name.required' => 'Ad name is required',
        'ad.placement.required' => 'Ad placement is required',
        'ad.expiry.required' => 'Ad expiry date is required',
    ];

    public function updated()
    {
        $this->updateValidationRules();
        $this->validate();
    }

    public function updateValidationRules()
    {
        // image is not required in edit mode
        if (!empty($this->ad->placement)) {
            switch ($this->ad->placement) {
                case 'header':
                    $this->acceptedDimension = '700px by 90px';
                    $this->rules['img'] = 'required|image|max:1024|dimensions:width=700,height=90';
                    break;

                case 'companies':
                    $this->acceptedDimension = '250px by 120px';
                    $this->rules['img'] = 'required|image|max:1024|dimensions:width=250,height=120';
                    break;

                case 'sidebar':
                    $this->acceptedDimension = '300px by 120px';
                    $this->rules['img'] = 'required|image|max:1024|dimensions:width=300,height=120';
                    break;

                case ('under_featured' || 'single'):
                    $this->acceptedDimension = '1550px by 250px';
                    $this->rules['img'] = 'required|image|max:1024|dimensions:width=1550,height=250';
                    break;
            }
        }
    }

    public function createItem()
    {
        $this->updateValidationRules();
        $this->validate();

        // Creating ad entry
        $ad = Ad::create([
            'name' => $this->ad->name,
            'placement' => $this->ad->placement,
            'link' => $this->ad->link,
            'expiry' => $this->ad->expiry,
        ]);

        // Storing image
        $img_path = $this->img->store('', 'public');

        // Creating image entry
        $ad->image()->create([
            'user_id' => Auth::user()->id,
            'path' => $img_path,
        ]);

        session()->flash('success', 'The ad has been created successfully.');

        return redirect()->to('/dashboard/ads');
    }

    public function saveItem()
    {
        $this->updateValidationRules();
        $this->validate();

        $this->ad->update([
            'name' => $this->ad->name,
            'placement' => $this->ad->placement,
            'link' => $this->ad->link,
            'expiry' => $this->ad->expiry,
        ]);

        if ($this->img != null) {
            // Delete old image
            Storage::disk('public')->delete($this->oldImg);

            // Store the new image
            $img_path = $this->img->store('', 'public');

            // Creating image entry
            $this->ad->image()->first()->update([
                'path' => $img_path,
            ]);
        }

        session()->flash('success', 'The ad has been updated successfully.');

        return redirect()->to('/dashboard/ads');
    }

    public function render()
    {
        return view('livewire.dashboard.edit-ads')->layout('layouts.dashboard.master', ['title' => $this->createMode ? 'Create Ad' : 'Edit Ad']);
    }
}
