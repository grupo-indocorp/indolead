<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * Muestra la lista de archivos.
     */
    public function index()
    {
        $files = File::with('uploadedBy')
            ->orderBy('created_at', 'desc') // Solo por fecha, más recientes primero
            ->get();

        return view('sistema.archivos.index', compact('files'));
    }

    /**
     * Muestra el formulario para subir un archivo.
     */
    public function create()
    {
        $folders = Folder::all();
        return view('sistema.archivos.create', compact('folders'));
    }

    /**
     * Almacena un archivo subido.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:doc,docx,odt,rtf,txt,pdf,xls,xlsx,xlsm,ods,csv,ppt,pptx,odp,accdb,mdb,one,pub,vsd|max:10485760', // 10GB
            'description' => 'nullable|string|max:355',
            'category' => 'nullable|string|max:100',
            'folder_id' => 'nullable|exists:folders,id',
        ]);

        $uploadedFile = $request->file('file');
        $path = $uploadedFile->store('uploads');

        File::create([
            'name' => $uploadedFile->getClientOriginalName(),
            'path' => $path,
            'uploaded_by' => auth()->id(),
            'description' => $request->description,
            'format' => $uploadedFile->getClientOriginalExtension(),
            'size' => $uploadedFile->getSize(),
            'category' => $request->category,
            'folder_id' => $request->folder_id
        ]);

        return redirect()->route('files.index')->with('success', 'Archivo subido correctamente.');
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

    /**
     * Muestra el formulario de edición.
     */
    public function edit($id)
    {
        $file = File::findOrFail($id);
        $folders = Folder::all(); // Cargar carpetas para el dropdown
        return view('sistema.archivos.edit', compact('file', 'folders'));
    }

    /**
     * Actualiza un archivo existente.
     */
    public function update(Request $request, $id)
    {
        $file = File::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:355',
            'description' => 'nullable|string|max:355',
            'category' => 'nullable|string|max:100',
            'folder_id' => 'nullable|exists:folders,id',
            'new_file' => 'nullable|file|max:102400',
        ]);

        // Actualizar archivo físico si se proporciona uno nuevo
        if ($request->hasFile('new_file')) {
            Storage::delete($file->path);
            $path = $request->file('new_file')->store('uploads');
            $file->path = $path;
            $file->format = $request->file('new_file')->getClientOriginalExtension();
            $file->size = $request->file('new_file')->getSize();
        }

        // Actualizar metadatos (incluyendo folder_id)
        $file->update([
            'name' => $request->name,
            'description' => $request->description,
            'category' => $request->category,
            'folder_id' => $request->folder_id
        ]);

        return response()->json(['success' => 'Archivo actualizado correctamente.']);
    }

    /**
     * Elimina un archivo.
     */
    public function destroy($id)
    {
        try {
            $file = File::findOrFail($id);

            if (Storage::exists($file->path)) {
                Storage::delete($file->path);
            }

            $file->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al eliminar el archivo: ' . $e->getMessage(),
            ], 500);
        }
    }
}
