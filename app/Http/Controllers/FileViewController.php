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

        if (!Storage::disk('local')->exists($file->path)) {
            abort(404, 'Archivo no encontrado');
        }

        // Obtener el path completo
        $filePath = Storage::disk('local')->path($file->path);

        // Determinar el Content-Type adecuado según la extensión
        $contentType = $this->getMimeType($file->format);

        // Headers adicionales para evitar caché y corrupción
        $headers = [
            'Content-Type' => $contentType,
            'Content-Description' => 'File Transfer',
            'Pragma' => 'public',
            'Expires' => '0',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-Length' => Storage::disk('local')->size($file->path)
        ];

        return Storage::disk('local')->download($file->path, $file->name, $headers);
    }

    /**
     * Obtiene el MIME type correcto según la extensión del archivo.
     */
    private function getMimeType($extension)
    {
        $mimeTypes = [
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'xlsm' => 'application/vnd.ms-excel.sheet.macroEnabled.12',
            // Agrega otros tipos MIME si es necesario
        ];

        return $mimeTypes[strtolower($extension)] ?? 'application/octet-stream';
    }
}
