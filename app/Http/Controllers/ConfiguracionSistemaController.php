<?php

namespace App\Http\Controllers;

use App\Models\Sistema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ConfiguracionSistemaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sistema = Sistema::first();

        return view('sistema.configuracion.sistema.index', compact('sistema'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $view = request('view');
        if ($view === 'create-sistema') {
            return view('sistema.configuracion.sistema.create');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $view = request('view');
        if ($view === 'store-sistema') {
            $logoPath = '';
            $iconoPath = '';
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('images', 'public');
            }
            if ($request->hasFile('icono')) {
                $iconoPath = $request->file('icono')->store('images', 'public');
            }
            $sistema = new Sistema;
            $sistema->nombre = request('nombre');
            $sistema->logo = $logoPath;
            $sistema->icono = $iconoPath;
            $sistema->save();

            return back()->with('success', 'Sistema creado correctamente');
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
        if ($view === 'edit-sistema') {
            $sistema = Sistema::first();

            return view('sistema.configuracion.sistema.edit', compact('sistema'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $view = request('view');
        if ($view === 'update-sistema') {
            $sistema = Sistema::find($id);
            if (Storage::disk('public')->exists($sistema->logo)) {
                Storage::disk('public')->delete($sistema->logo);
            }
            if (Storage::disk('public')->exists($sistema->icono)) {
                Storage::disk('public')->delete($sistema->icono);
            }
            $logoPath = '';
            $iconoPath = '';
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('images', 'public');
            }
            if ($request->hasFile('icono')) {
                $iconoPath = $request->file('icono')->store('images', 'public');
            }
            $sistema->nombre = request('nombre');
            $sistema->logo = $logoPath;
            $sistema->icono = $iconoPath;
            $sistema->save();

            return back()->with('success', 'Sistema actualizado correctamente.');
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
