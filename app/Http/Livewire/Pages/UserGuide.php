<?php

namespace App\Http\Livewire\Pages;

use Livewire\Component;

class UserGuide extends Component
{
    public function render()
    {
        return view('livewire.pages.user-guide', ['title' => 'Website Usage Guide']);
    }
}
