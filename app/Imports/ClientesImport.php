<?php

namespace App\Imports;

use App\Models\Cliente;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ClientesImport implements ToModel, WithHeadingRow
{
    /**
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Cliente([
            'ruc' => (string) $row['ruc'],
            'razon_social' => $row['razon_social'],
            'ciudad' => $row['ciudad'] ?? '',
        ]);
    }
}
