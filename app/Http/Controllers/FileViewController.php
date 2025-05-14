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

        // Obtener el nombre original con extensión
        $originalName = $file->name;
        if (!pathinfo($originalName, PATHINFO_EXTENSION)) {
            $originalName .= '.' . $file->format;
        }

        // Headers específicos para tipos de archivo comunes
        $headers = [
            'Content-Type' => $this->getMimeType($file->format),
            'Content-Disposition' => 'attachment; filename="' . $originalName . '"',
            'Pragma' => 'no-cache',
            'Expires' => '0'
        ];

        // Obtener el path completo del archivo
        $filePath = Storage::disk('local')->path($file->path);

        // Verificar si es un archivo Excel para headers especiales
        if (in_array(strtolower($file->format), ['xls', 'xlsx', 'xlsm'])) {
            return response()->download($filePath, $originalName, $headers);
        }

        return Storage::disk('local')->download($file->path, $originalName, $headers);
    }

    private function getMimeType($extension)
    {
        $mimeTypes = [
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'xlsm' => 'application/vnd.ms-excel.sheet.macroEnabled.12',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'pdf' => 'application/pdf',
            'ppt' => 'application/vnd.ms-powerpoint',
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'csv' => 'text/csv',
            'txt' => 'text/plain',
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
        ];

        return $mimeTypes[strtolower($extension)] ?? 'application/octet-stream';
    }
}
