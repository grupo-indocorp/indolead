<?php

namespace App\View\Components\Sistema\Cliente;

use App\Helpers\Helpers;
use App\Models\Agencia;
use App\Models\Clientetipo;
use App\Models\Estadodito;
use App\Models\Estadowick;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Movistars extends Component
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
        $estadowicks = Estadowick::all();
        $estadoditos = Estadodito::all();
        $clientetipos = Clientetipo::all();
        $agencias = Agencia::all();
        $config = Helpers::configuracionDatosAdicionalesJsonGet();

        return view('components.sistema.cliente.movistars', compact('estadowicks', 'estadoditos', 'clientetipos', 'agencias', 'config'));
    }
}
