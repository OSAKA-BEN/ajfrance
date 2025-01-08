<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;

class Error500 extends Component
{
    public function render()
    {
        return view('errors.500');
    }
}
