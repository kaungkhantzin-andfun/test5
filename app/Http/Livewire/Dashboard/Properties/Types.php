<?php

namespace App\Http\Livewire\Dashboard\Properties;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use App\Models\Categorizable;
use Illuminate\Support\Facades\Request;

class Types extends Component
{
    use WithPagination;

    public $of;
    public $addNew;
    public $perPage = 10;
    public $keyword;
    public $sortField = 'name';
    public $sortAsc = true;
    public $del_id;

    public function mount()
    {
        if (Request::is('*dashboard/types/blog*')) {
            $this->of = 'blog';
            $this->addNew = '/dashboard/types/blog/create';
        } elseif (Request::is('*dashboard/types/property*')) {
            $this->of = 'property';
            $this->addNew = '/dashboard/types/property/create';
        }
    }

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
        $cat = Category::findOrFail($this->del_id);

        // del sub cats
        Category::where('parent_id', $cat->id)->delete();

        // del parent cat
        $cat->delete();

        $this->dispatchBrowserEvent('notice', ['type' => 'success', 'text' => 'The item has been deleted!']);
    }

    public function render()
    {
        return view('livewire.dashboard.properties.types', [
            'types' => Category::where('of', $this->of)
                ->where('name', 'like', '%' . $this->keyword . '%')
                ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                ->whereNull('parent_id')
                ->paginate($this->perPage)
        ])->layout('layouts.dashboard.master', ['title' => 'All Types', 'addNew' => $this->addNew]);
    }
}
