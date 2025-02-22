<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Folder;
use App\Models\User;

class File extends Model
{
    use HasFactory;

    /**
     * Los campos que se pueden asignar en masa.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',         // Nombre del archivo
        'path',         // Ruta del archivo en el servidor
        'uploaded_by',  // ID del usuario que subió el archivo
        'description',  // Descripción del archivo
        'format',       // Formato del archivo (extensión)
        'size',         // Tamaño del archivo
        'category',     // Categoría del archivo
        'folder_id',    // ID de la carpeta a la que pertenece el archivo
    ];

    /**
     * Obtener el usuario que subió el archivo.
     */
    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
    
    // Relación con la carpeta
    public function folder()
    {
        return $this->belongsTo(Folder::class, 'folder_id');
    }

    public function getExtensionAttribute()
    {
        return strtoupper(pathinfo($this->nombre, PATHINFO_EXTENSION));
    }
    
    public function getSizeFormattedAttribute()
    {
        $bytes = $this->size;

        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2).' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2).' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2).' KB';
        }

        return $bytes.' bytes';
    }

    protected $guarded = [];

    // Query Scopes
    public function scopeVisibleToUser($query)
    {
        return $query->where('is_public', true)
            ->orWhere('user_id', auth()->id());
    }

    public function scopeWithFilters($query, $request)
    {
        return $query->when($request->category, function ($q) use ($request) {
            $q->where('category_id', $request->category);
        })->when($request->search, function ($q) use ($request) {
            $q->where('name', 'LIKE', "%{$request->search}%");
        });
    }
}
