<x-sistema.modal title="Registrar Etapa" dialog_id="dialog">
    <div class="flex justify-end">
        <button type="button" class="btn bg-gradient-primary m-0" onclick="submitEtapa()">Exportar</button>
    </div>
    <x-sistema.tabla-contenedor>
        <table>
            <thead>
                <tr>
                    <th style="width: 150px; background: #49b6ff;">Equipo</th>
                    <th style="width: 150px; background: #49b6ff;">Ejecutivo</th>
                    <th style="width: 150px; background: #49b6ff;">Ruc</th>
                    <th style="width: 250px; background: #49b6ff;">Razón Social</th>
                    <th style="width: 250px; background: #49b6ff;">Ciudad</th>
                    <th style="width: 250px; background: #49b6ff;">Nombre Contacto</th>
                    <th style="width: 250px; background: #49b6ff;">Celular Contacto</th>
                    <th style="width: 250px; background: #49b6ff;">Correo Electrónico Contacto</th>
                    
                    <th style="width: 250px; background: #6589ff;">Estado Wick</th>
                    <th style="width: 250px; background: #6589ff;">Evaluación Dito</th>
                    <th style="width: 250px; background: #6589ff;">Líneas Claro</th>
                    <th style="width: 250px; background: #6589ff;">Líneas Entel</th>
                    <th style="width: 250px; background: #6589ff;">Líneas Bitel</th>
                    
                    <th style="width: 250px; background: #49b6ff;">Etapa de Negociación</th>
                    <th style="width: 250px; background: #ddd01b;">Líneas de Negociación (Móvil Alta Nueva)</th>
                    <th style="width: 250px; background: #ddd01b;">Cargo en Negociación (Móvil Alta Nueva)</th>
                    <th style="width: 250px; background: #ddd01b;">Líneas de Negociación (Móvil Portabilidad)</th>
                    <th style="width: 250px; background: #ddd01b;">Cargo en Negociación (Móvil Portabilidad)</th>
                    <th style="width: 250px; background: #1bd0dd;">Líneas de Negociación (Fija)</th>
                    <th style="width: 250px; background: #1bd0dd;">Cargo en Negociación (Fija)</th>
                    <th style="width: 250px; background: #dd791b;">Líneas de Negociación (Avanzada)</th>
                    <th style="width: 250px; background: #dd791b;">Cargo en Negociación (Avanzada)</th>
                    <th style="width: 250px; background: #dd791b;">Líneas de Negociación (Avanzada 2)</th>
                    <th style="width: 250px; background: #dd791b;">Cargo en Negociación (Avanzada 2)</th>
                    <th style="width: 250px; background: #dd791b;">Líneas de Negociación (Avanzada 3)</th>
                    <th style="width: 250px; background: #dd791b;">Cargo en Negociación (Avanzada 3)</th>

                    <th style="width: 250px; background: #6589ff;">Fecha Primer Contacto</th>
                    <th style="width: 250px; background: #6589ff;">Fecha Último Contacto</th>
                    <th style="width: 250px; background: #db1d1d;">Fecha Próximo Contacto</th>

                    <th style="width: 250px; background: #6589ff;">Comentario 5</th>
                    <th style="width: 250px; background: #6589ff;">Comentario 4</th>
                    <th style="width: 250px; background: #6589ff;">Comentario 3</th>
                    <th style="width: 250px; background: #6589ff;">Comentario 2</th>
                    <th style="width: 250px; background: #6589ff;">Comentario 1</th>
                    <th style="width: 250px; background: #12c456;">Tipo de Cliente</th>
                    <th style="width: 250px; background: #12c456;">Agencia</th>
                    <th style="width: 250px; background: #12c456;">Fecha Blindaje</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clientes as $cliente)
                    @php
                        $comentario = $cliente->comentarios->last();
                        $fecha_ultimagestion = $comentario->created_at ?? $cliente->created_at;
                    @endphp
                    @if ($fecha_desde <= $fecha_ultimagestion->format('Y-m-d') && $fecha_hasta >= $fecha_ultimagestion->format('Y-m-d'))
                        @php
                            $data_venta = $cliente->ventas->last();
                            $ventas = [];
                            if (isset($data_venta)) {
                                foreach ($data_venta->productos as $producto) {
                                    $ventas[] = [
                                        'producto_id' => $producto->id,
                                        'producto' => $producto->nombre,
                                        'producto_nombre' => $producto->pivot->producto_nombre,
                                        'cantidad' => $producto->pivot->cantidad,
                                        'total' => $producto->pivot->total,
                                    ];
                                }
                            }
                            // movil
                            $movil_altanueva_cantidad = $ventas[0]['cantidad'] ?? '';
                            $movil_altanueva_total = $ventas[0]['total'] ?? '';
                            $movil_portabilidad_cantidad = $ventas[1]['cantidad'] ?? '';
                            $movil_portabilidad_total = $ventas[1]['total'] ?? '';
                            // fija
                            $fija_cantidad = $ventas[2]['cantidad'] ?? '';
                            $fija_total = $ventas[2]['total'] ?? '';
                            // avanzada
                            $avanzada_producto = $ventas[3]['producto_nombre'] ?? '';
                            $avanzada_total = $ventas[3]['total'] ?? '';
                            $avanzada2_producto = $ventas[4]['producto_nombre'] ?? '';
                            $avanzada2_total = $ventas[4]['total'] ?? '';
                            $avanzada3_producto = $ventas[5]['producto_nombre'] ?? '';
                            $avanzada3_total = $ventas[5]['total'] ?? '';
                        @endphp
                        <tr>
                            <td>{{ $cliente->user->equipos->last()->nombre ?? '' }}</td>
                            <td>{{ $cliente->user->name ?? '' }}</td>
                            <td>{{ $cliente->ruc }}</td>
                            <td>{{ $cliente->razon_social }}</td>
                            <td>{{ $cliente->ciudad }}</td>
                            <td>{{ $cliente->contactos->last()->nombre ?? '' }}</td>
                            <td>{{ $cliente->contactos->last()->celular ?? '' }}</td>
                            <td>{{ $cliente->contactos->last()->correo ?? '' }}</td>
                            
                            <td>{{ $cliente->movistars->last()->estadowick->nombre ?? '' }}</td>
                            <td>{{ $cliente->movistars->last()->estadodito->nombre ?? '' }}</td>
                            <td>{{ $cliente->movistars->last()->linea_claro ?? '0' }}</td>
                            <td>{{ $cliente->movistars->last()->linea_entel ?? '0' }}</td>
                            <td>{{ $cliente->movistars->last()->linea_bitel ?? '0' }}</td>
                            
                            <td>{{ $cliente->etapas->last()->nombre ?? '' }}</td>
                            <td>{{ $movil_altanueva_cantidad }}</td>
                            <td>{{ $movil_altanueva_total }}</td>
                            <td>{{ $movil_portabilidad_cantidad }}</td>
                            <td>{{ $movil_portabilidad_total }}</td>
                            <td>{{ $fija_cantidad }}</td>
                            <td>{{ $fija_total }}</td>
                            <td>{{ $avanzada_producto }}</td>
                            <td>{{ $avanzada_total }}</td>
                            <td>{{ $avanzada2_producto }}</td>
                            <td>{{ $avanzada2_total }}</td>
                            <td>{{ $avanzada3_producto }}</td>
                            <td>{{ $avanzada3_total }}</td>
                            
                            <td>{{ $cliente->created_at->format('d/m/Y') }}</td>
                            <td>{{ $fecha_ultimagestion->format('d/m/Y') }}</td>
                            <td></td>
                        
                            @foreach ($cliente->comentarios->reverse()->take(5) as $item)
                                <td>{{ $item->comentario ?? '' }}</td>
                            @endforeach
                            <td>{{ $cliente->movistars->last()->clientetipo->nombre ?? '' }}</td>
                            <td>{{ $cliente->movistars->last()->agencia->nombre ?? '' }}</td>
                            <td></td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        {{ $clientes->onEachSide(2)->links() }}
    </x-sistema.tabla-contenedor>
</x-sistema.modal>