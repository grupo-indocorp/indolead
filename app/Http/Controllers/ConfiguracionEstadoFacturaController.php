<?php

namespace App\Http\Controllers;

use App\Models\Estadofactura;
use Illuminate\Http\Request;

class ConfiguracionEstadoFacturaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $estados = Estadofactura::all();
        return view('sistema.configuracion.estado-factura.index', compact('estados'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $view = request('view');
        if ($view === 'create-etapa') {
            return view('sistema.configuracion.estado-factura.create');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $view = request('view');
        if ($view === 'store') {
            $request->validate(
                [
                    'name' => 'required|unique:estadofactura,name',
                ],
                [
                    'name.required' => 'El "Nombre" es obligatorio.',
                    'name.unique' => 'El "Nombre" ya existe.',
                ]
            );
            $id_name = strtolower(str_replace(' ', '_', request('name')));

            $dt = new Estadofactura();
            $dt->id_name = $id_name;
            $dt->name = request('name');
            $dt->save();

            session()->flash('success', 'Estado creado correctamente');
            return response()->json(['redirect' => true]);
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
        if ($view === 'edit') {
            $estadofactura = Estadofactura::find($id);
            return view('sistema.configuracion.estado-factura.edit', compact('estadofactura'));
        } elseif ($view === 'delete') {
            $estadofactura = Estadofactura::find($id);
            return view('sistema.configuracion.estado-factura.delete', compact('estadofactura'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $view = request('view');
        if ($view === 'update') {
            $request->validate(
                [
                    'name' => 'required',
                    'status' => 'required',
                ],
                [
                    'name.required' => 'El "Nombre" es obligatorio.',
                    'status.required' => 'El "Estado" es obligatorio.',
                ]
            );
            $id_name = strtolower(str_replace(' ', '_', request('name')));

            $dt = Estadofactura::find($id);
            $dt->id_name = $id_name;
            $dt->name = request('name');
            $dt->status = request('status');
            $dt->save();

            session()->flash('success', 'Estado actualizado correctamente');
            return response()->json(['redirect' => true]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (request('view') == 'destroy') {
            $etapa = Estadofactura::find($id);
            $etapa->delete();

            session()->flash('success', 'Estado eliminado correctamente');
            return response()->json(['redirect' => true]);
        }
    }
}
