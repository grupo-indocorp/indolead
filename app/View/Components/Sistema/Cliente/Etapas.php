<?php

namespace App\View\Components\Sistema\Cliente;

use App\Models\Etapa;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Etapas extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $etapas = Etapa::where('estado', 1)->get();

        return view('components.sistema.cliente.etapas', compact('etapas'));
    }
}
