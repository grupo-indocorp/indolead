<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasRoles;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'second_name',
        'first_surname',
        'second_surname',
        'name',
        'email',
        'password',
        'personal_phone',
        'personal_email',
        'identity_document',
        'sede_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    // Relación uno a uno
    public function equipo()
    {
        return $this->hasOne(Equipo::class);
    }

    // Relación uno a muchos
    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }

    public function clientes()
    {
        return $this->hasMany(Cliente::class);
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
    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }

    // Relación muchos a muchos
    public function clientesHistorial()
    {
        return $this->belongsToMany(Cliente::class)->withTimestamps();
    }

    public function equipos()
    {
        return $this->belongsToMany(Equipo::class)->withPivot('id')->withTimestamps();
    }

    public function files()
    {
        return $this->hasMany(File::class, 'uploaded_by');
    }
}
