<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * Muestra la lista de archivos.
     */
    public function index()
    {
        // Obtener todos los archivos con la relación 'uploadedBy'
        $files = File::with('uploadedBy')->get();

        // Retornar la vista con los archivos
        return view('sistema.archivos.index', compact('files'));
    }

    /**
     * Muestra el formulario para subir un archivo.
     */
    public function create()
    {
        return view('sistema.archivos.create'); // No extiende el layout
    }

    /**
     * Almacena un archivo subido.
     */
    public function store(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'file' => 'required|file|max:10240', // Máximo 10 MB
            'description' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:100',
        ]);

        // Subir el archivo
        $uploadedFile = $request->file('file');
        $path = $uploadedFile->store('uploads'); // Almacena el archivo en la carpeta "storage/app/uploads"

        // Guardar la información en la base de datos
        $file = new File();
        $file->name = $uploadedFile->getClientOriginalName();
        $file->path = $path;
        $file->uploaded_by = auth()->id(); // Asume que el usuario está autenticado
        $file->description = $request->input('description');
        $file->format = $uploadedFile->getClientOriginalExtension();
        $file->size = $uploadedFile->getSize();
        $file->category = $request->input('category');
        $file->save();

        // Redirigir con un mensaje de éxito
        return redirect()->route('files.index')->with('success', 'Archivo subido correctamente.');
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

    public function edit($id)
    {
        $file = File::findOrFail($id);
        return view('sistema.archivos.edit', compact('file'));
    }

    public function update(Request $request, $id)
    {
        $file = File::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:100',
            'new_file' => 'nullable|file|max:10240', // Opcional: permitir actualizar el archivo
        ]);

        // Actualizar archivo físico (si se proporciona uno nuevo)
        if ($request->hasFile('new_file')) {
            Storage::delete($file->path); // Eliminar archivo antiguo
            $path = $request->file('new_file')->store('uploads');
            $file->path = $path;
            $file->format = $request->file('new_file')->getClientOriginalExtension();
            $file->size = $request->file('new_file')->getSize();
        }

        // Actualizar metadatos
        $file->name = $request->input('name');
        $file->description = $request->input('description');
        $file->category = $request->input('category');
        $file->save();

        return response()->json(['success' => 'Archivo actualizado correctamente.']);
    }

    /**
     * Elimina un archivo específico.
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
                'error' => 'Error al eliminar el archivo: ' . $e->getMessage()
            ], 500);
        }
    }
}
