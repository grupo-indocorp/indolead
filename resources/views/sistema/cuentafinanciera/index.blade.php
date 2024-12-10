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
                            <th>{{ __('Cuenta Financiera') }}</th>
                            <th>{{ __('Ruc') }}</th>
                            <th>{{ __('Ejecutivo') }}</th>
                            <th>{{ __('Monto de Deuda') }}</th>
                            <th>{{ __('Estado') }}</th>
                            <th>{{ __('Periodo') }}</th>
                            <th>{{ __('Producto (M/F)') }}</th>
                            <th>{{ __('Ciclo Facturación') }}</th>
                            <th>{{ __('Estado Factura 1') }}</th>
                            <th>{{ __('Estado Factura 2') }}</th>
                            <th>{{ __('Estado Factura 3') }}</th>
                        </tr>
                    </x-slot:thead>
                    <x-slot:tbody>
                        @foreach ($cuentafinancieras as $item)
                            <tr>
                                <td>{{ $item->cuenta_financiera }}</td>
                                <td>
                                    <div class="flex flex-col">
                                        <b class="cursor-pointer hover:text-sky-600"
                                            data-bs-toggle="tooltip"
                                            data-bs-original-title="Detalle"
                                            onclick="cuentafinancieraDetalle({{ $item->id }})">
                                            {{ $item->text_cliente_ruc }}
                                        </b>
                                        <span>{{ substr($item->text_cliente_razon_social, 0, 45)}}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex flex-col">
                                        <b>{{ $item->text_user_equipo }}</b>
                                        <span>{{ $item->text_user_nombre }}</span>
                                    </div>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{ $item->ciclo }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
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