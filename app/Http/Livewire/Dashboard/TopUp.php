<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Package;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class TopUp extends Component
{
    public $packages;
    public $singlePackage;

    public function mount()
    {
        $this->packages = Package::all();
    }

    public function setPackage($pkg)
    {
        session()->put('singlePackage', $pkg);
        $this->singlePackage = $pkg;
    }

    public function render()
    {
        return view('livewire.dashboard.top-up')->layout(
            Auth::user()->role === 'remwdstate20' ? 'layouts.dashboard.master' : 'layouts.app',
            ['title' => __('Top Up Points')]
        );
    }
}
