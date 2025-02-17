<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificaciontipo extends Model
{
    use HasFactory;

    // Relación uno a muchos
    public function notificacions()
    {
        return $this->hasMany(Notificacion::class);
    }
}
