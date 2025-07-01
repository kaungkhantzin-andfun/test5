<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Package;
use Livewire\Component;
use Livewire\WithPagination;

class Packages extends Component
{
    use WithPagination;

    public $perPage = 5;
    public $keyword;
    public $sortField = 'name';
    public $sortAsc = true;

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
        Package::find($id)->delete();
    }

    public function render()
    {
        return view('livewire.dashboard.packages', [
            'packages' => Package::where(function ($query) {
                $query->where('name', 'like', '%' . $this->keyword . '%')
                    ->orWhere('credit', 'like', '%' . $this->keyword . '%')
                    ->orWhere('price', 'like', '%' . $this->keyword . '%')
                    ->orWhere('discount', 'like', '%' . $this->keyword . '%');
            })
                ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                ->paginate($this->perPage)
        ])->layout('layouts.dashboard.master', ['title' => 'All Packages', 'addNew' => '/dashboard/packages/create']);
    }
}
