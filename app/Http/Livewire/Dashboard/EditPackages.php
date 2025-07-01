<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Image;
use App\Models\Package;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EditPackages extends Component
{
    use WithFileUploads;

    public $package;
    public $img;
    public $oldImg;
    public $createMode = false;

    public function mount(Package $package)
    {
        if (empty($package->id)) { // if editing the ad
            $this->package = new Package;
            $this->createMode = true;
        }
    }

    protected $rules = [
        'package.name' => 'required',
        'package.credit' => 'required',
        'package.price' => 'required',
        'package.discount' => 'integer',
    ];

    protected $messages = [
        'package.name.required' => 'Package name is required.',
        'package.credit.required' => 'Credit is required.',
        'package.price.required' => 'Price is required.',
        'package.discount.integer' => 'Discount must be a positive integer.',
    ];

    public function updated()
    {
        $this->validate();
    }

    public function createItem()
    {
        $this->validate();

        // Creating package entry
        Package::create([
            'name' => $this->package->name,
            'credit' => $this->package->credit,
            'price' => $this->package->price,
            'discount' => $this->package->discount,
        ]);

        session()->flash('success', 'The package has been created successfully.');

        return redirect()->to('/dashboard/packages');
    }

    public function saveItem()
    {
        $this->validate();

        $this->package->update([
            'name' => $this->package->name,
            'credit' => $this->package->credit,
            'price' => $this->package->price,
            'discount' => $this->package->discount,
        ]);

        session()->flash('success', 'The package has been updated successfully.');

        return redirect()->to('/dashboard/packages');
    }

    public function render()
    {
        return view('livewire.dashboard.edit-packages')->layout('layouts.dashboard.master', ['title' => $this->createMode ? 'Create Package' : 'Edit Package']);
    }
}
