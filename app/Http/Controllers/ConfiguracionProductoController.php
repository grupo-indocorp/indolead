<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;

class ConfiguracionProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::all();

        return view('sistema.configuracion.producto.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $view = request('view');
        if ($view === 'create-producto') {
            $categorias = Categoria::where('estado', true)->get();

            return view('sistema.configuracion.producto.create', compact('categorias'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $view = request('view');
        if ($view === 'store-producto') {
            $request->validate(
                [
                    'nombre' => 'required|unique:productos,nombre|bail',
                    'categoria_id' => 'required|bail',
                ],
                [
                    'nombre.required' => 'El "Nombre" es obligatorio.',
                    'nombre.unique' => 'El "Nombre" ya se encuentra registrado.',
                    'categoria_id.required' => 'La "Categoría" es obligatorio.',
                ]
            );
            $producto = new Producto;
            $producto->nombre = request('nombre');
            $producto->categoria_id = request('categoria_id');
            $producto->save();
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
        if ($view === 'edit-producto') {
            $producto = Producto::find($id);
            $categorias = Categoria::all();

            return view('sistema.configuracion.producto.edit', compact('producto', 'categorias'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $view = request('view');
        if ($view === 'update-producto') {
            $request->validate(
                [
                    'nombre' => 'required|unique:productos,nombre,'.$id.'|bail',
                    'categoria_id' => 'required|unique:productos,nombre|bail',
                ],
                [
                    'nombre.required' => 'El "Nombre" es obligatorio.',
                    'nombre.unique' => 'El "Nombre" ya se encuentra registrado.',
                    'categoria_id.required' => 'El "Categoría" es obligatorio.',
                ]
            );
            $producto = Producto::find($id);
            $producto->nombre = request('nombre');
            $producto->categoria_id = request('categoria_id');
            $producto->save();
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
