<?php

namespace App\Http\Livewire\Dashboard\Locations;

use App\Models\Location;
use Livewire\Component;
use Livewire\WithPagination;

class Locations extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $keyword;
    public $sortField = 'updated_at';
    public $sortAsc;
    public $del_id;

    public function sortBy($field)
    {
        if ($this->sortField == $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortField = true;
        }
        $this->sortField = $field;
    }
    public function delCity($id)
    {
        Location::find($id)->delete();
    }

    public function render()
    {
        return view('livewire.dashboard.locations.locations', [
            'locations' => Location::whereNull('parent_id')
                ->where(function ($query) {
                    $query->where('name', 'like', '%' . $this->keyword . '%')
                        ->orWhere('postal_code', 'like', '%' . $this->keyword . '%');
                })
                ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                ->paginate($this->perPage)
        ])->layout('layouts.dashboard.master', ['title' => 'All Locations', 'addNew' => '/dashboard/locations/create']);
    }
}
