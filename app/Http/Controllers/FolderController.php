<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use Illuminate\Http\Request;

class FolderController extends Controller
{
    /**
     * Almacena una nueva carpeta.
     */
    public function index()
    {
        // Cargar carpetas con sus archivos
        $folders = Folder::with('files')->get();
        return view('sistema.archivos.view', compact('folders'));
        return view('sistema.archivos.view', compact('files', 'folders'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:255'
        ]);

        Folder::create($request->all());

        return response()->json(['success' => 'Carpeta creada correctamente']);
    }

    /**
     * Actualiza una carpeta existente.
     */
    public function update(Request $request, Folder $folder)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:255'
        ]);

        $folder->update($request->all());

        return response()->json(['success' => 'Carpeta actualizada']);
    }

    /**
     * Elimina una carpeta.
     */
    public function destroy(Folder $folder)
    {
        $folder->delete();
        return response()->json(['success' => 'Carpeta eliminada']);
    }
}
