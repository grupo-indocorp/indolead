<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    // Relación con los archivos
    public function files()
    {
        return $this->hasMany(File::class, 'folder_id');
    }
}