<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Ad;
use App\Models\Image;
use App\Models\Slider;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Ads extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $perPage = 10;
    public $keyword;
    public $sortField = 'name';
    public $sortAsc = true;
    public $del_id;
    public $createMode = true;

    public function sortBy($field)
    {
        if ($this->sortField == $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortField = true;
        }
        $this->sortField = $field;
    }

    public function delItem($id)
    {
        $ad = Ad::find($id);

        Storage::disk('public')->delete($ad->image->path);

        $ad->image->delete();

        $ad->delete();

        session()->flash('success', 'The ads has been deleted.');
    }

    public function render()
    {
        return view('livewire.dashboard.ads', [
            'ads' => Ad::where('name', 'like', "%$this->keyword%")->paginate($this->perPage)
        ])->layout('layouts.dashboard.master', ['title' => 'All Ads', 'addNew' => '/dashboard/ads/create']);
    }
}
