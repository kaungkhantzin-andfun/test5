<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Blog;
use App\Models\User;
use App\Models\Enquiry;
use Livewire\Component;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $enquiries;
    public $properties;
    public $users;
    public $blogs;

    public function mount()
    {
        if (Auth::user()->role === 'remwdstate20') {
            $this->enquiries = Enquiry::count();
            $this->properties = Property::count();
            $this->users = User::count();
            $this->blogs = Blog::count();
        } else {
            $this->enquiries = Enquiry::whereHas('property', function ($query) {
                $query->where('user_id', Auth::user()->id);
            })->count();

            $this->properties = Property::where('user_id', Auth::user()->id)->count();
        }
    }

    public function render()
    {
        return view('livewire.dashboard.dashboard')->layout(
            Auth::user()->role === 'remwdstate20' ? 'layouts.dashboard.master' : 'layouts.app',
            ['title' => __('Dashboard')]
        );
    }
}
