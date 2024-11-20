<?php

namespace App\View\Components\Sistema\Notificacion;

use App\Models\Notificaciontipo;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Create extends Component
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
        $notificaciontipos = Notificaciontipo::whereBetween('id', [2, 3])->get();
        $fecha = now()->format('Y-m-d');

        return view('components.sistema.notificacion.create', compact('notificaciontipos', 'fecha'));
    }
}
