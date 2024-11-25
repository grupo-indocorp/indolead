<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use Illuminate\Http\Request;

class EvaporacionGestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notificacions = Notificacion::with(['notificaciontipo'])
            ->whereNotNull('comentario_gestion')
            ->orderBy('comentario_gestion_estado')
            ->paginate(20);

        return view('sistema.evaporacion.gestion.index', compact('notificacions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $view = request('view');
        if ($view === 'detalle') {
            $notificacion = Notificacion::find($id);

            return view('sistema.evaporacion.gestion.detalle', compact('notificacion'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $id)
    {
        $view = request('view');
        if ($view === 'update-confirmar') {
            $notificacion = Notificacion::find($id);
            $notificacion->comentario_gestion_estado = true;
            $notificacion->save();

            // Establecer el mensaje de éxito en la sesión
            session()->flash('success', 'Gestión de evaporación creado correctamente');

            return response()->json(['redirect' => true]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
