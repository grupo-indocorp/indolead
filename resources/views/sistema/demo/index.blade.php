<table>
  <thead>
    <tr>
      <th></th>
      <th></th>
      <th>ruc</th>
      <th>razon social</th>
      <th>Ciudad</th>
      <th>Nombre Contacto</th>
      <th>Celular Contacto</th>
      <th>Correo Electrónico Contacto</th>

      <th>Estado Wick</th>
      <th>Evaluación Dito</th>
      <th>Líneas Claro</th>
      <th>Líneas Entel</th>
      <th>Líneas Bitel</th>

      <th>Etapa de Negociación</th>
      <th>Líneas de Negociación (Móvil Alta Nueva)</th>
      <th>Cargo en Negociación (Móvil Alta Nueva)</th>
      <th>Líneas de Negociación (Móvil Portabilidad)</th>
      <th>Cargo en Negociación (Móvil Portabilidad)</th>
      <th>Líneas de Negociación (Fija)</th>
      <th>Cargo en Negociación (Fija)</th>
      <th>Líneas de Negociación (Avanzada)</th>
      <th>Cargo en Negociación (Avanzada)</th>
      <th>Líneas de Negociación (Avanzada 2)</th>
      <th>Cargo en Negociación (Avanzada 2)</th>
      <th>Líneas de Negociación (Avanzada 3)</th>
      <th>Cargo en Negociación (Avanzada 3)</th>

      <th>Fecha Primer Contacto</th>
      <th>Fecha Último Contacto</th>
      <th>Fecha Próximo Contacto</th>

      <th>Comentario</th>
      <th>Tipo de Cliente</th>
      <th>Agencia</th>
      <th>Fecha Blindaje</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($clientes as $item)
    @php
        // $comentario = $item->comentarios->last();
        // $fecha_ultimagestion = $comentario->created_at ?? $item->created_at;
    @endphp
      <tr>
        <td>{{ $item->user->equipos->last()->nombre ?? '' }}</td>
        <td>{{ $item->user->name }}</td>
        <td>{{ $item->ruc }}</td>
        <td>{{ $item->razon_social }}</td>
        <td>{{ $item->ciudad }}</td>
        <td>{{ $item->contactos->last()->nombre ?? '' }}</td>
        <td>{{ $item->contactos->last()->celular ?? '' }}</td>
        <td>{{ $item->contactos->last()->correo ?? '' }}</td>

        <td>{{ $item->movistars->last()->estadowick->nombre ?? '' }}</td>
        <td>{{ $item->movistars->last()->estadodito->nombre ?? '' }}</td>
        <td>{{ $item->movistars->last()->linea_claro ?? '0' }}</td>
        <td>{{ $item->movistars->last()->linea_entel ?? '0' }}</td>
        <td>{{ $item->movistars->last()->linea_bitel ?? '0' }}</td>

        <td>{{ $item->etapas->last()->nombre ?? '' }}</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>

        <td></td>
        <td></td>
        <td></td>

        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    @endforeach
  </tbody>
</table>