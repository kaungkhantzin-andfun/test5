<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Helpers\MyHelper;
use Livewire\WithPagination;
use App\Models\PropertyPurpose;
use Artesaos\SEOTools\Facades\SEOTools;

class Directory extends Component
{
    use WithPagination;

    public $keyword;

    public function mount()
    {
        MyHelper::setGlobalSEOData(__('seo.directory.title'), __('seo.directory.description'));
    }

    public function getUsers()
    {
        $users = User::where('role', 'real-estate-agent')
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->keyword . '%')
                    ->orWhere('phone', 'like', '%' . $this->keyword . '%')
                    ->orWhere('role', 'like', '%' . $this->keyword . '%')
                    ->orWhere('email', 'like', '%' . $this->keyword . '%')
                    ->orWhere('address', 'like', '%' . $this->keyword . '%')
                    ->orWhereHas('location', function ($query) {
                        $query->where('name', 'like', '%' . $this->keyword . '%');
                    });
            })
            ->withCount('properties')
            ->latest()
            ->paginate(20);

        return $users;
    }

    public function render()
    {
        return view('livewire.directory', [
            'users' => $this->getUsers(),
        ]);
    }
}
