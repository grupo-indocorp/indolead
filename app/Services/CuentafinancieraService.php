<?php

namespace App\Services;

use App\Models\Cuentafinanciera;

class CuentafinancieraService
{
    /**
     * Muestra las cuentas financieras de evaporación
     *
     * @return object $cuentafinanciera
     */
    public function cuentafinancieraGet()
    {
        $cuentafinanciera = Cuentafinanciera::with(['cliente', 'user', 'user.equipos', 'evaporacions'])
            ->orderBy('cliente_id')
            ->paginate(50);

        return $cuentafinanciera;
    }

    /**
     * Muestra la cuenta financiera y sus detalles
     *
     * @param  string  $cuentafinanciera_id
     * @return object $cuentafinanciera
     */
    public function cuentafinancieraDetalle($cuentafinanciera_id)
    {
        $cuentafinanciera = Cuentafinanciera::with(['cliente', 'user', 'evaporacions'])->find($cuentafinanciera_id);

        return $cuentafinanciera;
    }
}
