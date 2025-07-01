<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Category;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\PropertyPurpose;
use Illuminate\Support\Facades\Request;

class Purposes extends Component
{
    public $purposes;
    public $new_purposes = [
        ['name' => '']
    ];
    public $del_id;

    public function mount()
    {
        if (Request::is('dashboard/facilities')) {
            $this->purposes = Category::all();
        } else {
            $this->purposes = PropertyPurpose::all();
        }
    }

    protected $rules = [
        'purposes.*.name' => 'required|string',
        'new_purposes.*.name' => 'required|string',
    ];

    protected $messages = [
        'purposes.*.name.required' => 'Name is required.',
        'new_purposes.*.name.required' => 'Name is required.',
    ];

    public function updated()
    {
        $this->validate();
    }

    public function confirmDel($index)
    {
        $this->del_id = $index;
    }

    public function deleteItem($index, $id)
    {
        $this->purposes->forget($index);
        if (Request::is('dashboard/facilities')) {
            Category::find($id)->delete();
        } else {
            PropertyPurpose::find($id)->delete();
        }
        $this->del_id = null;
    }

    public function deleteNewItem($index)
    {
        array_splice($this->new_purposes, $index, 1);
        $this->del_id = null;
    }

    public function addItem()
    {
        array_push($this->new_purposes, ['name' => '']);
    }

    public function saveItem()
    {
        $this->validate();

        foreach ($this->purposes as $psp) {
            $psp->save();
        }

        foreach ($this->new_purposes as $purpose) {
            PropertyPurpose::create([
                'name' => $purpose['name'],
                'slug' => Str::slug($purpose['name']),
            ]);
        }

        $this->new_purposes = [];
        $this->purposes = PropertyPurpose::all();

        $this->dispatchBrowserEvent('notice', ['type' => 'success', 'text' => 'The items has been saved successfully!']);
    }

    public function render()
    {
        return view('livewire.dashboard.purposes')->layout('layouts.dashboard.master', ['title' => 'Purposes']);
    }
}
