<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estadowick extends Model
{
    use HasFactory;

    // Relación uno a muchos
    public function movistars()
    {
        return $this->hasMany(Movistar::class);
    }
}
