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
        $cuentafinanciera = Cuentafinanciera::with([
                'cliente',
                'user',
                'user.equipos',
                'evaporacions',
                'estadofactura',
                'facturas' => function ($query) {
                    $query->orderByDesc('id')->limit(3);
                },
                'facturas.estadofactura',
                'facturas.facturadetalles',
                'facturas.facturadetalles.estadoproducto',
            ])
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
        $cuentafinanciera = Cuentafinanciera::with(['cliente', 'user', 'evaporacions', 'estadofactura'])
            ->find($cuentafinanciera_id);

        return $cuentafinanciera;
    }
}
