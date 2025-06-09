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
                <form action="{{ route('cliente-gestion.index') }}" method="GET" class="m-0">
                    <div class="w-full flex justify-between">
                        <div class="flex flex-col">
                            <div class="flex gap-1">
                                <div class="form-group flex flex-col">
                                    <label for="filtro_equipo_id" class="form-control-label">Equipos:</label>
                                    <select class="form-control" name="filtro_equipo_id" id="filtro_equipo_id"
                                        style="width: 250px;">
                                        <option></option>
                                        @foreach ($equipos as $item)
                                            <option value="{{ $item->id }}"
                                                @if ($item->id == request('filtro_equipo_id')) selected @endif>{{ $item->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group flex flex-col">
                                    <label for="filtro_user_id" class="form-control-label">Ejecutivo:</label>
                                    <select class="form-control" name="filtro_user_id" id="filtro_user_id"
                                        onchange="filtroAutomatico()" style="width: 250px;">
                                        <option></option>
                                        @foreach ($users as $item)
                                            <option value="{{ $item->id }}"
                                                @if ($item->id == request('filtro_user_id')) selected @endif>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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
                                    <td>{{ substr(optional($value->user->equipos->last())->nombre, 0, 16) }}</td>
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

            $('#filtro_equipo_id').select2({
                placeholder: 'Seleccionar',
                allowClear: true,
            });
            $('#filtro_user_id').select2({
                placeholder: 'Seleccionar',
                allowClear: true,
            });
            $('#filtro_equipo_id').on("change", function() {
                if ($(this).val()) {
                    $.ajax({
                        url: `{{ url('notificacion/${$(this).val()}') }}`,
                        method: "GET",
                        data: {
                            view: 'show-select-equipo',
                            sede_id: $('#filtro_sede_id').val(),
                        },
                        success: function(data) {
                            let opt_user = '<option></option>';
                            data.users.map(function(item) {
                                opt_user += `<option value="${item.id}">${item.name}</option>`;
                            })
                            $('#filtro_user_id').html(opt_user);
                            filtroAutomatico();
                        },
                        error: function(response) {
                            console.log('error');
                        }
                    });
                } else {
                    $.ajax({
                        url: `{{ url('notificacion/0') }}`,
                        method: "GET",
                        data: {
                            view: 'show-select-user',
                            sede_id: $('#filtro_sede_id').val(),
                        },
                        success: function(data) {
                            let opt_user = '<option></option>';
                            data.users.map(function(item) {
                                opt_user += `<option value="${item.id}">${item.name}</option>`;
                            })
                            $('#filtro_user_id').html(opt_user);
                            filtroAutomatico();
                        },
                        error: function(response) {
                            console.log('error');
                        }
                    });
                }
            });
            function filtroAutomatico() {
                let filtro_sede_id = $('#filtro_sede_id').val();
                let filtro_equipo_id = $('#filtro_equipo_id').val();
                let filtro_user_id = $('#filtro_user_id').val();
                window.location.href =
                    `/notificacion?filtro_sede_id=${filtro_sede_id}&filtro_equipo_id=${filtro_equipo_id}&filtro_user_id=${filtro_user_id}`;
            }
        </script>
    @endsection
@endcan
