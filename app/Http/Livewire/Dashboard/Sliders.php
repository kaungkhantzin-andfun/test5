<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Image;
use App\Models\Slider;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Sliders extends Component
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

    public function delItem()
    {
        $slider = Slider::find($this->del_id);

        $image = Image::where('imageable_id', $slider->id)->whereIn('imageable_type', ['slider', 'testimonial', 'youtube'])->first();

        if (!empty($image) && $image->imageable_type != 'youtube') {
            Storage::drive('public')->delete([$image->path, 'medium_' . $image->path, 'small_' . $image->path]);
        }

        $image->delete();
        $slider->delete();

        $this->dispatchBrowserEvent('notice', ['type' => 'success', 'text' => 'The slider has been deleted']);
    }

    public function render()
    {
        return view('livewire.dashboard.sliders', [
            'sliders' => Slider::where('name', 'like', "%$this->keyword%")
                ->orDoesntHave('image')
                ->orWhereHas('image', function ($query) {
                    $query->where('caption', 'like', "%$this->keyword%");
                })
                ->paginate($this->perPage)
        ])->layout('layouts.dashboard.master', ['title' => 'All Slides', 'addNew' => '/dashboard/sliders/create']);
    }
}
