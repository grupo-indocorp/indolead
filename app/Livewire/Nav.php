<?php

namespace App\Livewire;

use Livewire\Component;

class Nav extends Component
{
    public function render()
    {
        $user = auth()->user();

        return view('livewire.nav', compact('user'));
    }
}
