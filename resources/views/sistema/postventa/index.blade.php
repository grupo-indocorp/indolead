@extends('layouts.app')

@can('sistema.postventa')
    @section('content')
        <x-sistema.card-contenedor>
            <div class="p-4 pb-0">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <x-sistema.titulo title="Postventa" />
                    </div>
                </div>
            </div>
            {{-- Tabla --}}
            <div class="p-4">
                <x-ui.table id="postventa">
                    <x-slot:thead>
                        <tr>
                            <th>Identificacion</th>
                            <th>RucNumero</th>
                            <th>RucRazonSocial</th>
                            <th>ProductoNumero</th>
                            <th>ProductoOrden</th>
                            <th>ProductoNombre</th>
                            <th>ProductoCargoFijo</th>
                            <th>ProductoDescuento</th>
                            <th>ProductoDescuentoVigencia</th>
                            <th>ProductoCuentaFinanciera</th>
                            <th>EjecutivoNombre</th>
                            <th>EjecutivoCodigo</th>
                            <th>EjecutivoEquipo</th>
                            <th>EjecutivoSupervisor</th>
                            <th>FechaSolicitud</th>
                            <th>FechaActivacion1</th>
                            <th>FechaEjecutivoPeriodo</th>
                            <th>IdEvaporacion</th>
                            <th>FechaActivacion2</th>
                            <th>FechaEvaluacion</th>
                            <th>EvaluacionEstado</th>
                            <th>EvaluacionEstadoFecha</th>
                            <th>EvaluacionDescuento</th>
                            <th>EvaluacionDescuentoVigencia</th>
                            <th>EvaluacionDescuentoFecha</th>
                            <th>CicloFacturación</th>
                            <th>EstadoFacturacion1</th>
                            <th>FechaEmision1</th>
                            <th>FechaVencimiento1</th>
                            <th>MontoFacturado1</th>
                            <th>Deuda1</th>
                            <th>EstadoFacturacion2</th>
                            <th>FechaEmision2</th>
                            <th>FechaVencimiento2</th>
                            <th>MontoFacturado2</th>
                            <th>Deuda2</th>
                            <th>EstadoFacturacion3</th>
                            <th>FechaEmision3</th>
                            <th>FechaVencimiento3</th>
                            <th>MontoFacturado3</th>
                            <th>Deuda3</th>
                            <th>Observacion</th>
                        </tr>
                    </x-slot>
                    <x-slot:tbody>
                        @foreach ($evaporacion as $item)
                            <tr>
                                <td>{{ $item->Identificacion }}</td>
                                <td>{{ $item->RucNumero }}</td>
                                <td>{{ $item->RucRazonSocial }}</td>
                                <td>{{ $item->ProductoNumero }}</td>
                                <td>{{ $item->ProductoOrden }}</td>
                                <td>{{ $item->ProductoNombre }}</td>
                                <td>{{ $item->ProductoCargoFijo }}</td>
                                <td>{{ $item->ProductoDescuento }}</td>
                                <td>{{ $item->ProductoDescuentoVigencia }}</td>
                                <td>{{ $item->ProductoCuentaFinanciera }}</td>
                                <td>{{ $item->EjecutivoNombre }}</td>
                                <td>{{ $item->EjecutivoCodigo }}</td>
                                <td>{{ $item->EjecutivoEquipo }}</td>
                                <td>{{ $item->EjecutivoSupervisor }}</td>
                                <td>{{ $item->FechaSolicitud }}</td>
                                <td>{{ $item->FechaActivacion1 }}</td>
                                <td>{{ $item->FechaEjecutivoPeriodo }}</td>
                                <td>{{ $item->IdEvaporacion }}</td>
                                <td>{{ $item->FechaActivacion2 }}</td>
                                <td>{{ $item->FechaEvaluacion }}</td>
                                <td>{{ $item->EvaluacionEstado }}</td>
                                <td>{{ $item->EvaluacionEstadoFecha }}</td>
                                <td>{{ $item->EvaluacionDescuento }}</td>
                                <td>{{ $item->EvaluacionDescuentoVigencia }}</td>
                                <td>{{ $item->EvaluacionDescuentoFecha }}</td>
                                <td>{{ $item->CicloFacturación }}</td>
                                <td>{{ $item->EstadoFacturacion1 }}</td>
                                <td>{{ $item->FechaEmision1 }}</td>
                                <td>{{ $item->FechaVencimiento1 }}</td>
                                <td>{{ $item->MontoFacturado1 }}</td>
                                <td>{{ $item->Deuda1 }}</td>
                                <td>{{ $item->EstadoFacturacion2 }}</td>
                                <td>{{ $item->FechaEmision2 }}</td>
                                <td>{{ $item->FechaVencimiento2 }}</td>
                                <td>{{ $item->MontoFacturado2 }}</td>
                                <td>{{ $item->Deuda2 }}</td>
                                <td>{{ $item->EstadoFacturacion3 }}</td>
                                <td>{{ $item->FechaEmision3 }}</td>
                                <td>{{ $item->FechaVencimiento3 }}</td>
                                <td>{{ $item->MontoFacturado3 }}</td>
                                <td>{{ $item->Deuda3 }}</td>
                                <td>{{ $item->Observacion }}</td>
                            </tr>
                        @endforeach
                    </x-slot>
                    <x-slot:tfoot></x-slot>
                </x-ui.table>
            </div>
        </x-sistema.card-contenedor>
    @endsection
@endcan