<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;

class Error404 extends Component
{
    public function render()
    {
        return view('errors.404');
    }
}
