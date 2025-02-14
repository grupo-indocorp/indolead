<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inventarios = Inventario::all();

        return view('sistema.inventario.index', compact('inventarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sistema.inventario.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validación de los datos ingresados
    $request->validate([
        'codigo' => 'required|integer|unique:inventarios,codigo',
        'categoria' => 'required|string|max:100',
        'marca' => 'required|string|max:100',
        'serie' => 'required|string|max:100',
        'modelo' => 'required|string|max:100',
        'estado' => 'required|string|max:50',
        'procesador' => 'required|string|max:100',
        'ram' => 'required|string|max:50',
        'num_ram' => 'required|integer',
        'disco_duro' => 'required|string|max:100',
        'pantalla' => 'required|string|max:100',
        'color' => 'required|string|max:50',
        'descripcion' => 'nullable|string|max:255',
    ]);

    try {
        // Para crear un nuevo inventario
        $inventario = Inventario::create($request->all());

        // Respuesta para la creacion de dato, en el modal.
        return response()->json([
            'success' => true,
            'message' => 'Inventario creado correctamente.',
            'inventario' => $inventario
        ]);
    } catch (\Exception $e) {
        // Si ocurre un error, este mensaje se dara como respuesta.
        return response()->json([
            'success' => false,
            'message' => 'Ocurrió un error al crear el inventario. Por favor, intente nuevamente.'
        ]);
    }
}




    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventario $inventario)
    {
        return view('sistema.inventario.edit', compact('inventario'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inventario $inventario)
    {
        // Validación de los datos
        $request->validate([
            'codigo' => 'required|integer|unique:inventarios,codigo,' . $inventario->id,
            'categoria' => 'required|string|max:100',
            'marca' => 'required|string|max:100',
            'serie' => 'required|string|max:100',
            'modelo' => 'required|string|max:100',
            'estado' => 'required|string|max:50',
            'procesador' => 'required|string|max:100',
            'ram' => 'required|string|max:50',
            'num_ram' => 'required|integer',
            'disco_duro' => 'required|string|max:100',
            'pantalla' => 'required|string|max:100',
            'color' => 'required|string|max:50',    
            'descripcion' => 'nullable|string|max:255',
        ]);

        // Actualizar el inventario
        $inventario->update($request->all());

        return redirect()->route('inventarios.index')->with('success', 'Inventario actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventario $inventario)
    {
        $inventario->delete();

        return redirect()->route('inventarios.index')->with('success', 'Inventario eliminado correctamente.');
    }
}
