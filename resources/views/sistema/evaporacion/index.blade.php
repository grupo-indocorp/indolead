@extends('layouts.app')

@can('sistema.evaporacion')
    @section('content')
        <x-sistema.card-contenedor>
            <section class="p-4 pb-0">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <x-sistema.titulo title="Evaporación" />
                    </div>
                </div>
                @can('sistema.evaporacion.subir')
                    <div>
                        <form action="{{ route('import.evaporacion') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="file" class="form-label">Selecciona el archivo Excel:</label>
                                <input type="file" name="file" id="file" class="form-control" required>
                            </div>
                            <x-ui.button type="submit">Subir</x-ui.button>
                        </form>
                    </div>
                @endcan

                {{-- Filtro --}}
                <section>
                    <form action="{{ url('evaporacion') }}" method="GET">
                        <div class="flex gap-1">
                            <div class="form-group">
                                <label for="filtro_fechainicio" class="form-control-label">Fecha Evaluación Desde:</label>
                                <input class="form-control"
                                    type="date"
                                    value="{{ request('filtro_fechainicio') }}"
                                    id="filtro_fechainicio"
                                    name="filtro_fechainicio">
                            </div>
                            <div class="form-group">
                                <label for="filtro_fechafin" class="form-control-label">Fecha Evaluación Hasta:</label>
                                <input class="form-control"
                                    type="date"
                                    value="{{ request('filtro_fechafin') }}"
                                    id="filtro_fechafin"
                                    name="filtro_fechafin">
                            </div>
                            <div class="form-group">
                                <label for="filtro_estado" class="form-control-label">Estado:</label> <br>
                                <select class="form-control"
                                    name="filtro_estado"
                                    id="filtro_estado">
                                    <option></option>
                                    <option value="Activo" @if ('Activo' == request('filtro_estado')) selected @endif>Activo</option>
                                    <option value="BajaAPC" @if ('BajaAPC' == request('filtro_estado')) selected @endif>BajaAPC</option>
                                    <option value="Baja portabilidad" @if ('Baja portabilidad' == request('filtro_estado')) selected @endif>Baja portabilidad</option>
                                    <option value="Corte Deuda Parcial" @if ('Corte Deuda Parcial' == request('filtro_estado')) selected @endif>Corte Deuda Parcial</option>
                                    <option value="Corte Deuda Total" @if ('Corte Deuda Total' == request('filtro_estado')) selected @endif>Corte Deuda Total</option>
                                    <option value="Fraude" @if ('Fraude' == request('filtro_estado')) selected @endif>Fraude</option>
                                    <option value="Suspendido APC" @if ('Suspendido APC' == request('filtro_estado')) selected @endif>Suspendido APC</option>
                                    <option value="Prepago" @if ('Prepago' == request('filtro_estado')) selected @endif>Prepago</option>
                                    <option value="Sin Estado" @if ('Sin Estado' == request('filtro_estado')) selected @endif>Sin Estado</option>
                                </select>
                            </div>
                        </div>
                        <x-ui.button type="submit">Filtrar</x-ui.button>
                    </form>
                </section>
            </section>
            {{-- Tabla --}}
            <section class="p-4 w-full overflow-x-auto">
                <x-ui.table id="evaporacion">
                    <x-slot:thead>
                        <tr>
                            <th>{{ __('RUC') }}</th>
                            <th>{{ __('RAZÓN SOCIAL') }}</th>
                            @role(['sistema'])
                                <th>{{ __('EECC') }}</th>
                            @endrole
                            <th>{{ __('NÚMERO') }}</th>
                            <th>{{ __('FECHA ACTIVACIÓN') }}</th>
                            <th>{{ __('CARGO FIJO') }}</th>
                            <th>{{ __('FECHA EVALUACIÓN') }}</th>
                            <th>{{ __('ESTADO') }}</th>
                            <th>{{ __('OBSERVACIÓN') }}</th>
                            <th></th>
                        </tr>
                    </x-slot>
                    <x-slot:tbody>
                        @foreach ($evaporacion as $item)
                            <tr>
                                <td>{{ $item->ruc }}</td>
                                <td>{{ substr($item->razon_social, 0, 30) }}</td>
                                @role(['sistema'])
                                    <td class="flex flex-col">
                                        <b>{{ $item->equipo }}</b>
                                        <span>{{ $item->ejecutivo }}</span>
                                    </td>
                                @endrole
                                <td>{{ $item->numero_servicio }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->fecha_activacion)->format('d-m-Y') }}</td>
                                <td>{{ $item->cargo_fijo }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->fecha_evaluacion)->format('d-m-Y') }}</td>
                                <td class="flex flex-col">
                                    <span>{{ \Carbon\Carbon::parse($item->fecha_estado_linea)->format('d-m-Y') }}</span>
                                    @switch($item->estado_linea)
                                        @case('Activo')
                                            <span class="text-xs font-weight-bold mb-0 px-3 py-1 rounded-lg bg-green-50 text-green-500 border border-green-500">{{ $item->estado_linea }}</span>
                                            @break
                                        @case('BajaAPC')
                                            <span class="text-xs font-weight-bold mb-0 px-3 py-1 rounded-lg bg-red-50 text-red-500 border border-red-500">{{ $item->estado_linea }}</span>
                                            @break
                                        @case('Baja portabilidad')
                                            <span class="text-xs font-weight-bold mb-0 px-3 py-1 rounded-lg bg-red-50 text-red-500 border border-red-500">{{ $item->estado_linea }}</span>
                                            @break
                                        @case('Corte Deuda Parcial')
                                            <span class="text-xs font-weight-bold mb-0 px-3 py-1 rounded-lg bg-yellow-50 text-yellow-500 border border-yellow-500">{{ $item->estado_linea }}</span>
                                            @break
                                        @case('Corte Deuda Total')
                                            <span class="text-xs font-weight-bold mb-0 px-3 py-1 rounded-lg bg-red-50 text-red-500 border border-red-500">{{ $item->estado_linea }}</span>
                                            @break
                                        @case('Fraude')
                                            <span class="text-xs font-weight-bold mb-0 px-3 py-1 rounded-lg bg-red-50 text-red-500 border border-red-500">{{ $item->estado_linea }}</span>
                                            @break
                                        @case('Suspendido APC')
                                            <span class="text-xs font-weight-bold mb-0 px-3 py-1 rounded-lg bg-red-50 text-red-500 border border-red-500">{{ $item->estado_linea }}</span>
                                            @break
                                        @case('Prepago')
                                            <span class="text-xs font-weight-bold mb-0 px-3 py-1 rounded-lg bg-red-50 text-red-500 border border-red-500">{{ $item->estado_linea }}</span>
                                            @break
                                        @default
                                            
                                    @endswitch
                                </td>
                                <td>{{ substr($item->observacion, 0, 45) }}</td>
                                <td>
                                    <span class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Detalle">
                                        <a href="javascript:;" class="cursor-pointer" onclick="detalleEvaporacion({{ $item->id }})">
                                            <i class="fa-solid fa-eyes"></i>
                                        </a>
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </x-slot>
                    <x-slot:tfoot></x-slot>
                </x-ui.table>
                {{ $evaporacion->appends([
                    'filtro_fechainicio'=>request('filtro_fechainicio'),
                    'filtro_fechafin'=>request('filtro_fechafin'),
                    'filtro_estado'=>request('filtro_estado'),
                ])->links() }}
            </section>
        </x-sistema.card-contenedor>
    @endsection
    @section('script')
        <script>
            $('#filtro_estado').select2({
                placeholder: 'Seleccionar',
                allowClear: true,
            });
            function detalleEvaporacion(evaporacion_id) {
                $.ajax({
                    url: `{{ url('evaporacion/${evaporacion_id}') }}`,
                    method: "GET",
                    data: {
                        view: 'show-evaporacion',
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
        </script>
    @endsection
@endcan