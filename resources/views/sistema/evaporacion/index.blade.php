@extends('layouts.app')

@can('sistema.evaporacion')
    @section('content')
        <x-sistema.card-contenedor>
            <div class="p-4 pb-0">
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
            </div>
            {{-- Tabla --}}
            <div class="p-4">
                <x-ui.table id="evaporacion">
                    <x-slot:thead>
                        <tr>
                            <th>{{ __('RUC') }}</th>
                            <th>{{ __('RAZÓN SOCIAL') }}</th>
                            <th>{{ __('EECC') }}</th>
                            <th>{{ __('FECHA EVALUACIÓN') }}</th>
                            <th>{{ __('ESTADO') }}</th>
                            <th>{{ __('OBSERVACIÓN') }}</th>
                        </tr>
                    </x-slot>
                    <x-slot:tbody>
                        @foreach ($evaporacion as $item)
                            <tr>
                                <td>{{ $item->RucNumero }}</td>
                                <td>{{ $item->RucRazonSocial }}</td>
                                <td class="flex flex-col">
                                    <b>{{ $item->EjecutivoEquipo }}</b>
                                    <span>{{ $item->EjecutivoNombre }}</span>
                                </td>
                                <td>{{ $item->FechaEvaluacion }}</td>
                                <td class="flex flex-col">
                                    <span>{{ $item->EvaluacionEstadoFecha }}</span>
                                    <span class="text-xs font-weight-bold mb-0 px-3 py-1 rounded-lg bg-rose-50 text-rose-500 border border-red-500">{{ $item->EvaluacionEstado }}</span>
                                </td>
                                <td>{{ $item->Observacion }}</td>
                            </tr>
                        @endforeach
                    </x-slot>
                    <x-slot:tfoot></x-slot>
                </x-ui.table>
                {{ $evaporacion->links() }}
            </div>
        </x-sistema.card-contenedor>
    @endsection
@endcan