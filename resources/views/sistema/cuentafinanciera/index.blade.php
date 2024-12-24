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
                <x-ui.table id="cuentafinanciera">
                    <x-slot:thead>
                        <tr>
                            <th>{{ __('Cuenta Financiera') }}</th>
                            <th>{{ __('Ruc') }}</th>
                            <th>{{ __('Ejecutivo') }}</th>
                            <th>{{ __('Monto') }}</th>
                            <th>{{ __('Deuda') }}</th>
                            <th>{{ __('Estado C.F') }}</th>
                            <th>{{ __('Estado Producto') }}</th>
                            <th>{{ __('Periodo') }}</th>
                            <th>{{ __('Producto (M/F)') }}</th>
                            <th>{{ __('Ciclo Facturación') }}</th>
                            <th>{{ __('Factura Antiguo') }}</th>
                            <th>{{ __('Factura Intermedio') }}</th>
                            <th>{{ __('Factura Último') }}</th>
                        </tr>
                    </x-slot:thead>
                    <x-slot:tbody>
                        @foreach ($cuentafinancieras as $item)
                            @php
                                $facturas = $item->facturas->sortByDesc('id')->values();
                                $factura1 = $facturas->get(2) ?? '';
                                $factura2 = $facturas->get(1) ?? '';
                                $factura3 = $facturas->get(0) ?? '';
                            @endphp
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
                                <td>{{ $factura3->monto ?? 0 }}</td>
                                <td>{{ $factura3->deuda ?? 0 }}</td>
                                <td>
                                    @if (!is_null($item->estadofactura_id))
                                        @if ($item->estadofactura->id_name === 'pagado')
                                            <span class="text-xs font-weight-bold mb-0 px-3 py-1 rounded-lg bg-green-50 text-green-500 border border-green-500">
                                                {{ $item->estadofactura->name }}
                                            </span>
                                        @elseif ($item->estadofactura->id_name === 'pagado_ajuste' || $item->estadofactura->id_name === 'pagado_reclamo')
                                            <span class="text-xs font-weight-bold mb-0 px-3 py-1 rounded-lg bg-yellow-50 text-yellow-500 border border-yellow-500">
                                                {{ $item->estadofactura->name }}
                                            </span>
                                        @else
                                            <span class="text-xs font-weight-bold mb-0 px-3 py-1 rounded-lg bg-red-50 text-red-500 border border-red-500">
                                                {{ $item->estadofactura->name }}
                                            </span>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if ($factura3)
                                        @switch($factura3->facturadetalles->last()->estadoproducto->id_name)
                                            @case('activo')
                                                <span class="text-xs font-weight-bold mb-0 px-3 py-1 rounded-lg bg-green-50 text-green-500 border border-green-500">
                                                    {{ $factura3->facturadetalles->last()->estadoproducto->name }}
                                                </span>
                                                @break
                                            @case('corte_deuda_parcial')
                                                <span class="text-xs font-weight-bold mb-0 px-3 py-1 rounded-lg bg-yellow-50 text-yellow-500 border border-yellow-500">
                                                    {{ $factura3->facturadetalles->last()->estadoproducto->name }}
                                                </span>
                                                @break
                                            @default
                                                <span class="text-xs font-weight-bold mb-0 px-3 py-1 rounded-lg bg-red-50 text-red-500 border border-red-500">
                                                    {{ $factura3->facturadetalles->last()->estadoproducto->name }}
                                                </span>
                                        @endswitch
                                    @endif
                                </td>
                                <td>
                                    @if ($factura3)
                                        {{ $factura3->facturadetalles->last()->periodo_servicio }}
                                    @endif
                                </td>
                                <td></td>
                                <td>{{ $item->ciclo }}</td>
                                <td>
                                    @if ($factura1)
                                        @if ($factura1->estadofactura->id_name === 'pagado')
                                            <span class="text-xs font-weight-bold mb-0 px-3 py-1 rounded-lg bg-green-50 text-green-500 border border-green-500">
                                                {{ $factura1->estadofactura->name }}
                                            </span>
                                        @elseif ($factura1->estadofactura->id_name === 'pagado_ajuste' || $factura1->estadofactura->id_name === 'pagado_reclamo')
                                            <span class="text-xs font-weight-bold mb-0 px-3 py-1 rounded-lg bg-yellow-50 text-yellow-500 border border-yellow-500">
                                                {{ $factura1->estadofactura->name }}
                                            </span>
                                        @else
                                            <span class="text-xs font-weight-bold mb-0 px-3 py-1 rounded-lg bg-red-50 text-red-500 border border-red-500">
                                                {{ $factura1->estadofactura->name }}
                                            </span>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if ($factura2)
                                        @if ($factura2->estadofactura->id_name === 'pagado')
                                            <span class="text-xs font-weight-bold mb-0 px-3 py-1 rounded-lg bg-green-50 text-green-500 border border-green-500">
                                                {{ $factura2->estadofactura->name }}
                                            </span>
                                        @elseif ($factura2->estadofactura->id_name === 'pagado_ajuste' || $factura2->estadofactura->id_name === 'pagado_reclamo')
                                            <span class="text-xs font-weight-bold mb-0 px-3 py-1 rounded-lg bg-yellow-50 text-yellow-500 border border-yellow-500">
                                                {{ $factura2->estadofactura->name }}
                                            </span>
                                        @else
                                            <span class="text-xs font-weight-bold mb-0 px-3 py-1 rounded-lg bg-red-50 text-red-500 border border-red-500">
                                                {{ $factura2->estadofactura->name }}
                                            </span>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if ($factura3)
                                        @if ($factura3->estadofactura->id_name === 'pagado')
                                            <span class="text-xs font-weight-bold mb-0 px-3 py-1 rounded-lg bg-green-50 text-green-500 border border-green-500">
                                                {{ $factura3->estadofactura->name }}
                                            </span>
                                        @elseif ($factura3->estadofactura->id_name === 'pagado_ajuste' || $factura3->estadofactura->id_name === 'pagado_reclamo')
                                            <span class="text-xs font-weight-bold mb-0 px-3 py-1 rounded-lg bg-yellow-50 text-yellow-500 border border-yellow-500">
                                                {{ $factura3->estadofactura->name }}
                                            </span>
                                        @else
                                            <span class="text-xs font-weight-bold mb-0 px-3 py-1 rounded-lg bg-red-50 text-red-500 border border-red-500">
                                                {{ $factura3->estadofactura->name }}
                                            </span>
                                        @endif
                                    @endif
                                </td>
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