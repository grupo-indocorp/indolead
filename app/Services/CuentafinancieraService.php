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
    public function cuentafinancieraGet($filters)
    {
        $where = [];
        if (isset($filters['user_id'])) {
            $where[] = ['user_id', $filters['user_id']];
        }
        if (isset($filters['periodo'])) {
            $where[] = ['periodo', 'like', '%'.$filters['periodo'].'%'];
        }
        if (isset($filters['cuentafinanciera'])) {
            $where[] = ['cuenta_financiera', 'like', '%'.$filters['cuentafinanciera'].'%'];
        }
        if (isset($filters['ruc'])) {
            $where[] = ['text_cliente_ruc', 'like', '%'.$filters['ruc'].'%'];
        }
        if (auth()->user()->hasRole('calidad comercial')) {
            $where[] = ['user_evaporacion', auth()->id()];
        }

        $cuentafinanciera = Cuentafinanciera::with([
                'cliente',
                'user',
                'user.equipos',
                'evaporacions',
                'estadofactura',
                // 'facturas' => function ($query) {
                //     $query->orderByDesc('id')->limit(3);
                // },
                'facturas',
                'facturas.estadofactura',
                'categoria',
            ])
            ->where($where)
            ->orderBy('id')
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
