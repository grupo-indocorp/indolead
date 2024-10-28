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
                            <th>RucNumero</th>
                            <th>RucRazonSocial</th>
                            <th>EjecutivoNombre</th>
                            <th>EjecutivoEquipo</th>
                            <th>FechaSolicitud</th>
                            <th>FechaActivacion1</th>
                            <th>EvaluacionEstado</th>
                            <th>EvaluacionEstadoFecha</th>
                        </tr>
                    </x-slot>
                    <x-slot:tbody>
                        @foreach ($evaporacion as $item)
                            <tr>
                                <td>{{ $item->RucNumero }}</td>
                                <td>{{ $item->RucRazonSocial }}</td>
                                <td>{{ $item->EjecutivoNombre }}</td>
                                <td>{{ $item->EjecutivoEquipo }}</td>
                                <td>{{ $item->FechaSolicitud }}</td>
                                <td>{{ $item->FechaActivacion1 }}</td>
                                <td>{{ $item->EvaluacionEstado }}</td>
                                <td>{{ $item->EvaluacionEstadoFecha }}</td>
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