<?php

namespace App\Livewire;

use Illuminate\Support\Facades\File;
use Livewire\Component;

class Frases extends Component
{
    public $frase;

    public function mount()
    {
        $this->actualizarFrase();
    }

    public function actualizarFrase()
    {
        $frasesJson = File::get(resource_path('Halloween.json'));
        $frasesArray = json_decode($frasesJson, true)['frases'];
        $this->frase = $frasesArray[array_rand($frasesArray)];
    }

    public function render()
    {
        return view('livewire.frases');
    }
}
