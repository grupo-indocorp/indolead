<?php

namespace App\Livewire;

use Livewire\Component;

class SelectorPagina extends Component
{
    public $views = ['10', '25', '50'];

    public function render()
    {
        return view('livewire.selector-pagina');
    }
}
