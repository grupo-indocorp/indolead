<table>
    <thead>
        <tr>
            <th colspan="16"></th>
            <th colspan="2" style="background: #ddd01b;">MOVIL</th>
            <th colspan="2" style="background: #1bd0dd;">FIJA</th>
            <th colspan="2" style="background: #dd791b;">AVANZADA</th>
            <th colspan="7"></th>
        </tr>
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

            <th style="width: 250px; background: #6589ff;">Fecha Primer Contacto</th>
            <th style="width: 250px; background: #6589ff;">Fecha Último Contacto</th>
            {{-- <th style="width: 250px; background: #db1d1d;">Fecha Próximo Contacto</th> --}}
            <th style="background: #ddd01b;">Cantidad</th>
            <th style="background: #ddd01b;">Cargo Fijo</th>
            <th style="background: #1bd0dd;">Cantidad</th>
            <th style="background: #1bd0dd;">Cargo Fijo</th>
            <th style="background: #dd791b;">Cantidad</th>
            <th style="background: #dd791b;">Cargo Fijo</th>

            <th style="width: 250px; background: #6589ff;">Ultimo Comentario</th>
            <th style="width: 250px; background: #6589ff;">4to Comentario</th>
            <th style="width: 250px; background: #6589ff;">3er Comentario</th>
            <th style="width: 250px; background: #6589ff;">2do Comentario</th>
            <th style="width: 250px; background: #6589ff;">1er Comentario</th>
            <th style="width: 250px; background: #12c456;">Tipo de Cliente</th>
            <th style="width: 250px; background: #12c456;">Agencia</th>
            {{-- <th style="width: 250px; background: #12c456;">Fecha Blindaje</th> --}}
        </tr>
    </thead>
    <tbody>
        @foreach($clientes as $cliente)
                @php
                    $ventas = $cliente->ventas->last();
                    $m_cant = 0;
                    $m_carf = 0;
                    $f_cant = 0;
                    $f_carf = 0;
                    $a_cant = 0;
                    $a_carf = 0;
                    if ($ventas) {
                        // 2 = movil, 3 = fija, 4 = avanzada
                        foreach ($ventas->productos as $item) {
                            if ($item->categoria_id === 2) {
                                $m_cant += $item->pivot->cantidad;
                                $m_carf += $item->pivot->total;
                            } elseif ($item->categoria_id === 3) {
                                $f_cant += $item->pivot->cantidad;
                                $f_carf += $item->pivot->total;
                            } elseif ($item->categoria_id === 4) {
                                $a_cant += $item->pivot->cantidad;
                                $a_carf += $item->pivot->total;
                            }
                        }
                    }

                    // Comentarios
                    $comentarios = $cliente->comentarios()->where('user_id', $cliente->user_id)->latest()->take(5)->get();
                    $comentariosArray = $comentarios->toArray();
                    $textoPredeterminado = "";
                    while (count($comentariosArray) < 5) {
                        $comentariosArray[] = ['comentario' => $textoPredeterminado];
                    }
                @endphp
                <tr>
                    <td>{{ $cliente->equipo->nombre ?? '' }}</td>
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
                    
                    <td>{{ $cliente->etapa->nombre ?? '' }}</td>
                    
                    <td>{{ date('d/m/Y', strtotime($cliente->fecha_nuevo)) }}</td>
                    <td>{{ date('d/m/Y', strtotime($cliente->fecha_gestion)) }}</td>
                    {{-- <td></td> --}}
                    <td>{{ $m_cant }}</td>
                    <td>{{ $m_carf }}</td>
                    <td>{{ $f_cant }}</td>
                    <td>{{ $f_carf }}</td>
                    <td>{{ $a_cant }}</td>
                    <td>{{ $a_carf }}</td>
                    @foreach ($comentariosArray as $comentario)
                        <td>{{ $comentario['comentario'] }}</td>
                    @endforeach
                    <td>{{ $cliente->movistars->last()->clientetipo->nombre ?? '' }}</td>
                    <td>{{ $cliente->movistars->last()->agencia->nombre ?? '' }}</td>
                    {{-- <td></td> --}}
                </tr>
        @endforeach
    </tbody>
</table>