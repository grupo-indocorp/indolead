<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Attributes\SearchUsingPrefix;
use Laravel\Scout\Searchable;

class Cliente extends Model
{
    use HasFactory, Searchable;

    protected $guarded = [];

    // Relación uno a muchos
    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    public function contactos()
    {
        return $this->hasMany(Contacto::class);
    }

    public function movistars()
    {
        return $this->hasMany(Movistar::class);
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }

    public function notificacions()
    {
        return $this->hasMany(Notificacion::class);
    }

    public function cuentas_financieras()
    {
        return $this->hasMany(Cuentafinanciera::class);
    }

    // Relación uno a muchos inversa
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
    }

    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }

    public function etapa()
    {
        return $this->belongsTo(Etapa::class);
    }

    public function etiqueta()
    {
        return $this->belongsTo(Etiqueta::class);
    }

    // Relación muchos a muchos
    public function usersHistorial()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function etapas()
    {
        return $this->belongsToMany(Etapa::class)->withPivot('id')->withTimestamps();
    }

    // Relación uno a uno
    public function exportCliente()
    {
        return $this->hasOne(Exportcliente::class);
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array<string, mixed>
     */
    #[SearchUsingPrefix(['ruc', 'razon_social'])]
    public function toSearchableArray(): array
    {
        return [
            'ruc' => $this->ruc,
            'razon_social' => $this->razon_social,
        ];
    }
}
