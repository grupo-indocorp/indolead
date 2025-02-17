<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileViewController extends Controller
{
    /**
     * Muestra la lista de archivos para visualización.
     */
    public function index()
    {
        // Obtener todos los archivos con la relación 'uploadedBy'
        $files = File::with('uploadedBy')->get();

        // Retornar la vista con los archivos
        return view('sistema.archivos.view', compact('files'));
    }

    /**
     * Descarga un archivo específico.
     */
    public function download($id)
    {
        $file = File::findOrFail($id);

        if (!Storage::disk('local')->exists($file->path)) {
            abort(404, "Archivo no encontrado");
        }

        return Storage::disk('local')->download($file->path, $file->name);
    }
}