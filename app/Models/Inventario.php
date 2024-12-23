<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;

    // Atributos asignables
    protected $fillable = [
        'codigo',
        'categoria',
        'marca',
        'modelo',
        'estado',
        'serie', 
        'procesador', 
        'ram', 
        'num_ram',
        'disco_duro',
        'pantalla',
        'color', 
        'descripcion',
    ];
}
