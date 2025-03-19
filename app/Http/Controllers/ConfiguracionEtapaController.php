<?php

namespace App\Http\Controllers;

use App\Models\Etapa;
use Illuminate\Http\Request;

class ConfiguracionEtapaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $etapas = Etapa::all();

        return view('sistema.configuracion.etapa.index', compact('etapas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $view = request('view');
        if ($view === 'create-etapa') {
            return view('sistema.configuracion.etapa.create');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $view = request('view');
        if ($view === 'store-etapa') {
            $request->validate(
                [
                    'nombre' => 'required|unique:etapas,nombre|bail',
                ],
                [
                    'nombre.required' => 'El "Nombre" es obligatorio.',
                    'nombre.unique' => 'El "Nombre" ya se encuentra registrado.',
                ]
            );
            $etapa = new Etapa;
            $etapa->nombre = request('nombre');
            $etapa->save();
        }
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
        if ($view === 'edit-etapa') {
            $etapa = Etapa::find($id);

            return view('sistema.configuracion.etapa.edit', compact('etapa'));
        } elseif ($view === 'delete-etapa') {
            $etapa = Etapa::find($id);

            return view('sistema.configuracion.etapa.delete', compact('etapa'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $view = request('view');
        if ($view === 'update-etapa') {
            $request->validate(
                [
                    'nombre' => 'required|unique:etapas,nombre,'.$id.'|bail',
                    'blindaje' => 'required|integer|min:0|bail',
                    'avance' => 'required|min:0|bail',
                    'probabilidad' => 'required|bail',
                    'estado' => 'required',
                ],
                [
                    'nombre.required' => 'El "Nombre" es obligatorio.',
                    'nombre.unique' => 'El "Nombre" ya se encuentra registrado.',
                    'blindaje.required' => 'El "Blindaje" es obligatorio.',
                    'blindaje.integer' => 'El "Blindaje" deber ser un valor entero.',
                    'blindaje.min' => 'El "Blindaje" como mínimo es cero dias.',
                    'avance.required' => 'El "Avance" es obligatorio.',
                    'avance.min' => 'El "Avance" como mínimo es cero.',
                    'probabilidad.required' => 'La "Probabilidad" es obligatorio.',
                    'estado.required' => 'El "Estado" es obligatorio.',
                ]
            );
            $color = request('color');
            $etapa = Etapa::find($id);
            $etapa->nombre = request('nombre');
            $etapa->color = $color;
            $etapa->opacity = $color.'4d';
            $etapa->blindaje = request('blindaje');
            $etapa->avance = request('avance');
            $etapa->probabilidad = request('probabilidad');
            $etapa->orden = request('orden');
            $etapa->estado = request('estado');
            $etapa->save();

            // Establecer el mensaje de éxito en la sesión
            session()->flash('success', 'Etapa actualizado correctamente');
            return response()->json(['redirect' => true]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (request('view') == 'destroy-etapa') {
            $etapa = Etapa::find($id);
            $etapa->delete();
        }
    }
}
