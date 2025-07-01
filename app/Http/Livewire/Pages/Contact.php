<?php

namespace App\Http\Livewire\Pages;

use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use Artesaos\SEOTools\Facades\SEOTools;

class Contact extends Component
{
    public function mount()
    {
        // SEO Optimizations
        SEOTools::setTitle('Contact Us');
    }

    public function render()
    {
        return view('livewire.pages.contact', ['title' => 'Contact Us']);
    }
}
