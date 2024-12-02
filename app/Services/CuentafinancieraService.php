<?php

namespace App\Services;

use App\Models\Cuentafinanciera;
use Illuminate\Support\Facades\DB;

class CuentafinancieraService
{
    /**
     * Muestra las cuentas financieras de evaporación
     * @return object $cuentafinanciera
     */
    public function cuentafinancieraGet()
    {
        $cuentafinanciera = Cuentafinanciera::with(['cliente', 'user', 'user.equipos'])
            ->orderBy('cliente_id')
            ->paginate(100);

        return $cuentafinanciera;
    }

    /**
     * Muestra la cuenta financiera y sus detalles
     * @param string $cuentafinanciera_id
     * @return object $cuentafinanciera
     */
    public function cuentafinancieraDetalle($cuentafinanciera_id)
    {
        $cuentafinanciera = Cuentafinanciera::with(['cliente', 'user'])->find($cuentafinanciera_id);
        // $cuentafinanciera = Cuentafinanciera::with(['cliente', 'user', 'user.equipos'])->paginate(20);
        return $cuentafinanciera;
    }
}
