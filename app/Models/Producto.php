<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    // Relación uno a muchos inversa
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    // Relación muchos a muchos
    public function ventas()
    {
        return $this->belongsToMany(Venta::class)->withPivot('producto_nombre', 'cantidad', 'precio', 'total')->withTimestamps();
    }
}
