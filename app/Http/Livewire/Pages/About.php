<?php

namespace App\Http\Livewire\Pages;

use Livewire\Component;
use Artesaos\SEOTools\Facades\SEOTools;

class About extends Component
{
    public function mount()
    {
        // SEO Optimizations
        SEOTools::setTitle('About Us');
    }

    public function render()
    {
        return view('livewire.pages.about', ['title' => 'About Us']);
    }
}
