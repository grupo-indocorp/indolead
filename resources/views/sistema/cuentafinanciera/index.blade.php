@extends('layouts.app')

@can('sistema.evaporacion')
    @section('content')
        <x-sistema.card-contenedor>
            <section class="p-4 pb-0">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <x-sistema.titulo title="Cuentas Financieras" />
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
            </section>
            {{-- Tabla --}}
            <section class="p-4 w-full overflow-x-auto">
                <x-ui.table id="evaporacion">
                    <x-slot:thead>
                        <tr>
                            <th>{{ __('RUC') }}</th>
                            <th>{{ __('RAZÓN SOCIAL') }}</th>
                            <th>{{ __('CUENTA FINANCIERA') }}</th>
                            <th>{{ __('EECC') }}</th>
                            <th>{{ __('FECHA EVALUACIÓN') }}</th>
                            <th>{{ __('ESTADO') }}</th>
                            <th>{{ __('OBSERVACIÓN') }}</th>
                        </tr>
                    </x-slot:thead>
                    <x-slot:tbody>
                        @foreach ($cuentafinancieras as $item)
                            <tr>
                                <td>
                                    <b class="cursor-pointer hover:text-sky-600"
                                        data-bs-toggle="tooltip"
                                        data-bs-original-title="Detalle"
                                        onclick="cuentafinancieraDetalle({{ $item->id }})">
                                        {{ $item->cliente->ruc }}
                                    </b>
                                </td>
                                <td>{{ substr($item->cliente->razon_social, 0, 45) }}</td>
                                <td>{{ $item->cuenta_financiera }}</td>
                                <td class="flex flex-col">
                                    <b>{{ $item->user->equipos->last()->nombre ?? '' }}</b>
                                    <span>{{ $item->user->name }}</span>
                                </td>
                                <td>{{ $item->fecha_evaluacion }}</td>
                                <td></td>
                                <td>{{ substr($item->ultimo_comentario, 0, 45) }}</td>
                            </tr>
                        @endforeach
                    </x-slot:tbody>
                    <x-slot:tfoot></x-slot:tfoot>
                </x-ui.table>
                {{ $cuentafinancieras->links() }}
            </section>
        </x-sistema.card-contenedor>
    @endsection
    @section('script')
        <script>
            function cuentafinancieraDetalle(cuentafinanciera_id) {
                $.ajax({
                    url: `{{ url('cuentas-financieras/${cuentafinanciera_id}') }}`,
                    method: "GET",
                    data: {
                        view: 'show-detalle',
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
        </script>
    @endsection
@endcan