@extends('layouts.app')

@can('sistema.notificacion')
    @section('content')
        <x-sistema.card-contenedor>
            <div class="p-4">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <x-sistema.titulo title="Agenda"/>
                    </div>
                    <div>
                        <a href="javascript:;" class="btn bg-gradient-primary m-0" onclick="agregarNotificacion()" type="button">Agregar</a>
                    </div>
                </div>
            </div>
            <div class="p-4">
                <x-ui.table id="table_notificacion">
                    <x-slot:thead>
                        <tr>
                            <th>{{ __("Tipo de Agenda") }}</th>
                            @role(['sistema', 'gerente comercial', 'supervisor'])
                                <th>{{ __("Ejecutivo") }}</th>
                                <th>{{ __("Equipo") }}</th>
                            @endrole
                            <th>{{ __("Asunto") }}</th>
                            <th>{{ __("Mensaje") }}</th>
                            <th>{{ __("Cliente") }}</th>
                            <th>{{ __("Fecha") }}</th>
                            <th></th>
                            <th>{{ __("Opciones") }}</th>
                        </tr>
                    </x-slot>
                    <x-slot:tbody>
                        @foreach ($notificaciones as $value)
                            <tr>
                                <td>{{ $value->notificaciontipo->nombre }}</td>
                                @role(['sistema', 'gerente comercial', 'supervisor'])
                                    <td>{{ substr($value->user->name, 0, 16) }}</td>
                                    <td>{{ substr($value->user->equipos->last()->nombre ?? '', 0, 16) }}</td>
                                @endrole
                                <td>{{ substr($value->asunto, 0, 35) }}</td>
                                <td>{{ substr($value->mensaje, 0, 20) }}</td>
                                <td>{{ $value->cliente->ruc ?? '' }}</td>
                                <td>
                                     @php $class = $value->fecha <= date('Y-m-d') ? 'bg-red-200' : 'bg-green-200'; @endphp
                                     <span class="{{ $class }} text-xs font-semibold font-se mb-0 px-3 py-1 rounded-lg">{{ $value->fecha }} {{ $value->hora }}</span>
                                </td>
                                <td>
                                    @if (!is_null($value->comentario_gestion))
                                        <span class="bg-green-200 text-xs font-semibold font-se mb-0 px-3 py-1 rounded-lg">Evaporación Gestionado</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($value->notificaciontipo->nombre === 'evaporación')
                                        @if (is_null($value->comentario_gestion))
                                            <span class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Gestionar Evaporación">
                                                <a href="javascript:;" class="cursor-pointer" onclick="gestionEvaporacion({{ $value->id }})">
                                                    <i class="fa-solid fa-print-magnifying-glass"></i>
                                                </a>
                                            </span>
                                        @endif
                                    @else
                                        @if ($value->fecha >= date('Y-m-d'))
                                            @if (auth()->user()->id === $value->user_id)
                                                <span class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Editar">
                                                    <a href="javascript:;" class="cursor-pointer" onclick="editarNotificacion({{ $value->id }})">
                                                        <i class="fa-solid fa-pen"></i>
                                                    </a>
                                                </span>
                                                <span class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Eliminar">
                                                    <a href="javascript:;" class="cursor-pointer" onclick="eliminarNotificacion({{ $value->id }})">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
                                                </span>
                                            @endif
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </x-slot>
                    <x-slot:tfoot></x-slot>
                </x-ui.table>
                <div class="mt-2">
                    {{ $notificaciones->links() }}
                </div>
            </div>
        </x-sistema.card-contenedor>
        <script>
            function agregarNotificacion() {
                $.ajax({
                    url: `{{ url('notificacion/create') }}`,
                    method: "GET",
                    data: {
                        view: 'create'
                    },
                    success: function( result ) {
                        $('#contenedorModal').html(result);
                        openModal();
                    },
                    error: function( response ) {
                        console.log('error');
                    }
                });
            }
            function editarNotificacion(notificacion_id) {
                $.ajax({
                    url: `{{ url('notificacion/${notificacion_id}/edit') }}`,
                    method: "GET",
                    data: {
                        view: 'edit',
                    },
                    success: function( result ) {
                        $('#contenedorModal').html(result);
                        openModal();
                    },
                    error: function( response ) {
                        console.log('error');
                    }
                });
            }
            function eliminarNotificacion(notificacion_id) {
                $.ajax({
                    url: `{{ url('notificacion/${notificacion_id}/edit') }}`,
                    method: "GET",
                    data: {
                        view: 'delete',
                    },
                    success: function( result ) {
                        $('#contenedorModal').html(result);
                        openModal();
                    },
                    error: function( response ) {
                        console.log('error');
                    }
                });
            }
            function gestionEvaporacion(notificacion_id) {
                $.ajax({
                    url: `{{ url('notificacion/${notificacion_id}/edit') }}`,
                    method: "GET",
                    data: {
                        view: 'gestion-evaporacion',
                    },
                    success: function( result ) {
                        $('#contenedorModal').html(result);
                        openModal();
                    },
                    error: function( response ) {
                        console.log('error');
                    }
                });
            }
            // $('#table_notificacion').DataTable({
            //     dom: '<"flex justify-between p-4"fl>rt<"flex justify-between p-4"ip>',
            //     processing: true,
            //     language: {
            //         search: 'Buscar:',
            //         info: 'Mostrando _START_ a _END_ de _TOTAL_ entradas',
            //         processing: 'Cargando',
            //     },
            //     pageLength: 50,
            //     order: [],
            // });
        </script>
    @endsection
@endcan
