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
                <x-sistema.tabla-contenedor>
                    <table class="table align-items-center mb-0" id="table_notificacion">
                        <thead>
                            <tr>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tipo de Agenda</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Asunto</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Mensaje</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Cliente</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fecha</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($notificaciones as $value)
                            <tr id="{{ $value->id }}">
                                <td class="align-middle text-center">
                                    <span class="bg-gray-200 text-xs font-semibold font-se mb-0 px-3 py-1 rounded-lg">{{ $value->notificaciontipo->nombre }}</span>
                                </td>
                                <td class="align-middle text-center">
                                    <p class="text-xs font-weight-bold mb-0">{{ $value->asunto }}</p>
                                </td>
                                <td class="align-middle text-center">
                                    <p class="text-xs font-weight-bold mb-0">{{ substr($value->mensaje, 0, 30) }}</p>
                                </td>
                                <td class="align-middle text-center">
                                    <p class="text-xs font-weight-bold mb-0">{{ $value->cliente->ruc ?? '' }}</p>
                                </td>
                                <td class="align-middle text-center">
                                    @php $class = $value->fecha <= date('Y-m-d') ? 'bg-red-200' : 'bg-green-200'; @endphp
                                    <span class="{{ $class }} text-xs font-semibold font-se mb-0 px-3 py-1 rounded-lg">{{ $value->fecha }} {{ $value->hora }}</span>
                                </td>
                                <td class="align-center">
                                    @if ($value->fecha >= date('Y-m-d'))
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
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </x-sistema.tabla-contenedor>
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
                        $('#contModal').html(result);
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
                        $('#contModal').html(result);
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
                        $('#contModal').html(result);
                        openModal();
                    },
                    error: function( response ) {
                        console.log('error');
                    }
                });
            }
            mostrarDatatable();
            function mostrarDatatable() {
                new DataTable('#table_notificacion', {
                    dom: '<"flex justify-between p-4"fl>rt<"flex justify-between p-4"ip>',
                    processing: true,
                    language: {
                        search: 'Buscar:',
                        info: 'Mostrando _START_ a _END_ de _TOTAL_ entradas',
                        processing: 'Cargando',
                    },
                    pageLength: 50,
                });
            }
        </script>
    @endsection
@endcan
