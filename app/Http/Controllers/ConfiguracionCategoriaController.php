<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class ConfiguracionCategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = Categoria::all();

        return view('sistema.configuracion.categoria.index', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $view = request('view');
        if ($view === 'create-categoria') {
            return view('sistema.configuracion.categoria.create');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $view = request('view');
        if ($view === 'store-categoria') {
            $request->validate(
                [
                    'nombre' => 'required|unique:categorias,nombre|bail',
                ],
                [
                    'nombre.required' => 'El "Nombre" es obligatorio.',
                    'nombre.unique' => 'El "Nombre" ya se encuentra registrado.',
                ]
            );
            $categoria = new Categoria;
            $categoria->nombre = request('nombre');
            $categoria->estado = request('estado') === 'false' ? false : true;
            $categoria->save();
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
        if ($view === 'edit-categoria') {
            $categoria = Categoria::find($id);

            return view('sistema.configuracion.categoria.edit', compact('categoria'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $view = request('view');
        if ($view === 'update-categoria') {
            $request->validate(
                [
                    'nombre' => 'required|unique:categorias,nombre,'.$id.'|bail',
                ],
                [
                    'nombre.required' => 'El "Nombre" es obligatorio.',
                    'nombre.unique' => 'El "Nombre" ya se encuentra registrado.',
                ]
            );
            $categoria = Categoria::find($id);
            $categoria->nombre = request('nombre');
            $categoria->estado = request('estado') === 'false' ? false : true;
            $categoria->save();
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
