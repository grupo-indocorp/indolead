<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Support\Facades\Storage;
use App\Models\Folder;

class FileViewController extends Controller
{
    /**
     * Muestra la lista de archivos para visualización.
     */
    public function index()
    {
        $folders = Folder::with(['files' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])->get();

        // Depuración: Verificar el orden de los archivos
        foreach ($folders as $folder) {
            \Log::info("Carpeta: {$folder->name}");
            foreach ($folder->files as $file) {
                \Log::info("Archivo ID: {$file->id}, Fecha: {$file->created_at}");
            }
        }

        return view('sistema.archivos.view', compact('folders'));
    }

    /**
     * Descarga un archivo específico.
     */
    public function download($id)
    {
        $file = File::findOrFail($id);

        if (! Storage::disk('local')->exists($file->path)) {
            abort(404, 'Archivo no encontrado');
        }

        return Storage::disk('local')->download($file->path, $file->name);
    }
}
