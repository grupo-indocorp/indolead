<?php

namespace App\Services;

use App\Models\Evaporacion;

class EvaporacionService
{
    /**
     * Funcion que regresar las evaporaciones segun el rol
     * ejecutivo y por defecto todo
     * @param object $user
     * @return object $evaporacion
     */
    public function evaporacionGet($user)
    {
        if ($user->hasrole('ejecutivo')) {
            $evaporacion = Evaporacion::where('EjecutivoCodigo', $user->identity_document)
                ->paginate(20);
        } else {
            $evaporacion = Evaporacion::paginate(20);
        }
        return $evaporacion;
    }
}