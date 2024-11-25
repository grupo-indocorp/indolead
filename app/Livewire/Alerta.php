<?php

namespace App\Livewire;

use Livewire\Component;

class Alerta extends Component
{
    public $mensaje;

    public function render()
    {
        return view('livewire.alerta');
    }
}
