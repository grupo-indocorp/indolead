<x-sistema.tabla-contenedor>
    <table class="table align-items-center mb-0" id="gestion_cliente">
        <thead>
            <tr>
                @can('sistema.gestion_cliente.asignar')
                    <th>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="selectAllClients" >
                        </div>
                    </th>
                @endcan
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">RUC</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Razón Social</th>

                @role(['sistema', 'gerente general', 'gerente comercial', 'asistente comercial', 'jefe comercial', 'supervisor'])
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">EECC</th>
                @endrole

                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Etapa</th>

                @role(['sistema', 'gerente general', 'gerente comercial', 'asistente comercial'])
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Sede</th>
                @endrole

                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Comentario</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fecha de última Gestión</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Días sin Gestión</th>

                @role(['sistema', 'gerente general', 'gerente comercial', 'asistente comercial', 'supervisor'])
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Etiqueta</th>
                @endrole
            </tr>
        </thead>
        <tbody>
            @foreach ($clientes as $value)
            @php
                $comentario = $value->comentarios->last();
            @endphp
            @php
                $fecha_gestion = \Carbon\Carbon::parse($value->fecha_gestion)->startOfDay();
                $dias = $fecha_gestion->diffInDays(\Carbon\Carbon::now()->startOfDay());
            @endphp
            <tr id="{{ $value->id }}">
                @can('sistema.gestion_cliente.asignar')
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="{{ $value->id }}" >
                        </div>
                    </td>
                @endcan
                <td class="align-middle text-center">
                    <h6 class="mb-0 text-xs hover:cursor-pointer" onclick="detalleCliente({{ $value->id }})">{{ $value->ruc }}</h6>
                </td>
                <td class="align-middle text-center">
                    <p class="text-xs font-weight-bold mb-0 uppercase">{{ substr($value->razon_social, 0, 30) }}</p>
                </td>

                @role(['sistema', 'gerente general', 'gerente comercial', 'asistente comercial', 'jefe comercial', 'supervisor'])
                <td class="align-middle text-center">
                    <p class="text-xs font-weight-bold mb-0">{{ $value->equipo->nombre }}</p>
                    <p class="text-xs text-secondary mb-0">{{ $value->user->name }}</p>
                </td>
                @endrole

                <td class="align-middle text-center">
                    <span class="text-xs font-semibold font-se mb-0 px-3 py-1 rounded-lg" style="background-color: {{ $value->etapa->opacity }};">
                        {{ $value->etapa->nombre }}
                    </span>
                </td>

                @role(['sistema', 'gerente general', 'gerente comercial', 'asistente comercial'])
                <td class="align-middle text-center">
                    <span class="text-xs font-weight-bold mb-0 uppercase">{{ $value->sede->nombre }}</span>
                </td>
                @endrole

                <td class="align-middle text-center">
                    <span class="text-secondary text-xs font-weight-normal">{{ substr($comentario->comentario ?? '', 0, 40) }}</span>
                </td>
                <td class="align-middle text-center">
                    <span class="text-secondary text-xs font-weight-normal">{{ date('d/m/Y H:i:s A', strtotime($value->fecha_gestion)) }}</span>
                </td>
                <td class="align-middle text-center text-sm">
                    @if ($dias >= 60)
                        <span class="text-xs font-weight-bold mb-0 px-3 py-1 rounded-lg bg-red-100">{{ $dias }}</span>
                    @else
                        <span class="text-xs font-weight-bold mb-0 px-3 py-1 rounded-lg bg-green-100">{{ $dias }}</span>
                    @endif
                </td>

                @role(['sistema', 'gerente general', 'gerente comercial', 'asistente comercial', 'supervisor'])
                <td class="align-middle text-center">
                    @php
                        $fechaGestion = Carbon\Carbon::parse($value->fecha_gestion)->toDateString();
                        $fechaNuevo = Carbon\Carbon::parse($value->fecha_nuevo)->toDateString();
                        $fechaHoy = Carbon\Carbon::today()->toDateString();
                    @endphp
                    @if ($fechaGestion == $fechaHoy)
                        @if ($value->etiqueta_id != 2)
                            <span class="bg-slate-300 text-slate-700 text-xs font-semibold font-se mb-0 mx-1 px-3 py-1 rounded-lg">
                                gestionado
                            </span>
                        @endif
                    @endif
                    @if ($fechaNuevo == $fechaHoy)
                        <span class="bg-slate-300 text-slate-700 text-xs font-semibold font-se mb-0 mx-1 px-3 py-1 rounded-lg">
                            nuevo
                        </span>
                    @endif
                </td>
                @endrole
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $clientes->appends([
        'filtro_ruc'=>$filtro['filtro_ruc'],
        'filtro_etapa_id'=>$filtro['filtro_etapa_id'],
        'filtro_equipo_id'=>$filtro['filtro_equipo_id'],
        'filtro_user_id'=>$filtro['filtro_user_id'],
        'filtro_sede_id'=>$filtro['filtro_sede_id'],
        'filtro_fecha_desde'=>$filtro['filtro_fecha_desde'],
        'filtro_fecha_hasta'=>$filtro['filtro_fecha_hasta']
    ])->links() }}
</x-sistema.tabla-contenedor>
