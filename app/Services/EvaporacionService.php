<?php

namespace App\Services;

use App\Models\Evaporacion;

class EvaporacionService
{
    /**
     * Funcion que regresar las evaporaciones segun el rol
     * ejecutivo y por defecto todo
     * @param object $user
     * @param array $filter
     * ['estado']
     * @return object $evaporacion
     */
    public function evaporacionGet($user, $filter=null)
    {
        // filtro
        $where = [];
        if (!is_null($filter)) {
            if (!is_null($filter['estado'])) {
                if ($filter['estado'] === 'Sin Estado') {
                    $where[] = ['EvaluacionEstado', ''];
                } else {
                    $where[] = ['EvaluacionEstado', $filter['estado']];
                }
            }
            if (!is_null($filter['fechainicio'])) {
                $where[] = ['FechaEvaluacion', '>=', $filter['fechainicio']];
            }
            if (!is_null($filter['fechafin'])) {
                $where[] = ['FechaEvaluacion', '<=', $filter['fechafin']];
            }
        }

        if ($user->hasrole('ejecutivo')) {
            $evaporacion = Evaporacion::where('EjecutivoCodigo', $user->identity_document)
                ->where($where)
                ->paginate(20);
        } else {
            $evaporacion = Evaporacion::where($where)->paginate(20);
        }
        return $evaporacion;
    }
}