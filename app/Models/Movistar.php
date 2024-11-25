<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movistar extends Model
{
    use HasFactory;

    // Relación uno a muchos inversa
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function clientetipo()
    {
        return $this->belongsTo(Clientetipo::class);
    }

    public function estadowick()
    {
        return $this->belongsTo(Estadowick::class);
    }

    public function estadodito()
    {
        return $this->belongsTo(Estadodito::class);
    }

    public function agencia()
    {
        return $this->belongsTo(Agencia::class);
    }
}
