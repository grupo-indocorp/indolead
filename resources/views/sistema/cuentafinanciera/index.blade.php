@extends('layouts.app')

@can('sistema.evaporacion')
    @section('content')
        <x-sistema.card-contenedor>
            <x-sistema.card-contenedor-header title="Cuentas Financieras">
                @can('sistema.evaporacion.subir')
                    <x-ui.button type="button" onclick="importExcel()">{{ __('Importar') }}</x-ui.button>
                @endcan
            </x-sistema.card-contenedor-header>
            {{-- Filter --}}
            <section class="p-4 pb-0">
                <form action="{{ route('cuentas-financieras.index') }}" method="GET" class="m-0">
                    <div class="flex gap-1">
                        <div class="form-group flex flex-col">
                            <label for="filtro_equipo_id" class="form-control-label">Equipos:</label>
                            <select class="form-control" name="filtro_equipo_id" id="filtro_equipo_id" style="width: 250px;">
                                <option></option>
                                @foreach ($equipos as $item)
                                    <option value="{{ $item->id }}"
                                        @if ($item->id == request('filtro_equipo_id')) selected @endif
                                        >
                                        {{ $item->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group flex flex-col">
                            <label for="filtro_user_id" class="form-control-label">Ejecutivo:</label>
                            <select class="form-control" name="filtro_user_id" id="filtro_user_id" onchange="filterCuentaFinanciera()"  style="width: 250px;">
                                <option></option>
                                @foreach ($users as $item)
                                    <option value="{{ $item->id }}"
                                        @if ($item->id == request('filtro_user_id')) selected @endif
                                        >
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="filtro_periodo" class="form-control-label">Periodo:</label>
                            <input class="form-control" 
                                type="search"
                                value="{{ request('filtro_periodo') }}"
                                id="filtro_periodo"
                                name="filtro_periodo"
                                placeholder="Periodo">
                        </div>
                        <div class="form-group">
                            <label for="filtro_cuentafinanciera" class="form-control-label">Cuenta Financiera:</label>
                            <input class="form-control"
                                type="search"
                                value="{{ request('filtro_cuentafinanciera') }}"
                                id="filtro_cuentafinanciera"
                                name="filtro_cuentafinanciera"
                                placeholder="Cuenta Financiera">
                        </div>
                        <div class="form-group">
                            <label for="filtro_ruc" class="form-control-label">RUC:</label>
                            <input class="form-control"
                                type="search"
                                value="{{ request('filtro_ruc') }}"
                                id="filtro_ruc"
                                name="filtro_ruc"
                                placeholder="RUC">
                        </div>
                    </div>
                </form>
            </section>
            {{-- Tabla --}}
            <section class="p-4 w-full overflow-x-auto">
                <x-ui.table id="cuentafinanciera">
                    <x-slot:thead>
                        <tr>
                            <th>{{ __('Tipo') }}</th>
                            <th>{{ __('Responsable') }}</th>
                            <th>{{ __('Cuenta Financiera') }}</th>
                            <th>{{ __('Ruc') }}</th>
                            <th>{{ __('Eecc') }}</th>
                            <th>{{ __('Ciclo Facturación') }}</th>
                            <th>{{ __('Periodo') }}</th>
                            <th>{{ __('Estado Factura') }}</th>
                            <th>{{ __('Monto') }}</th>
                            <th>{{ __('Deuda') }}</th>
                        </tr>
                    </x-slot:thead>
                    <x-slot:tbody>
                        @foreach ($cuentafinancieras as $item)
                            @php
                                $facturas = $item->facturas->sortByDesc('id')->values();
                                $factura1 = $facturas->get(2) ?? null;
                                $factura2 = $facturas->get(1) ?? null;
                                $factura3 = $facturas->get(0) ?? null;
                            @endphp
                            <tr>
                                <td>{{ $item->categoria->nombre }}</td>
                                <td>{{ $item->userEvaporacion->name }}</td>
                                <td>
                                    <b class="cursor-pointer hover:text-sky-600"
                                        data-bs-toggle="tooltip"
                                        data-bs-original-title="Detalle"
                                        onclick="cuentafinancieraDetalle({{ $item->id }})">
                                        {{ $item->cuenta_financiera }}
                                    </b>
                                </td>
                                <td>
                                    <div class="flex flex-col">
                                        <b>{{ $item->text_cliente_ruc }}</b>
                                        <span>{{ substr($item->text_cliente_razon_social, 0, 45)}}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex flex-col">
                                        <b>{{ $item->text_user_equipo }}</b>
                                        <span>{{ $item->text_user_nombre }}</span>
                                    </div>
                                </td>
                                <td>{{ $item->ciclo }}</td>
                                <td>{{ $item->periodo }}</td>
                                <td class="flex flex-col">
                                    @if (!is_null($factura3))
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
                                    @if (!is_null($factura2))
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
                                    @if (!is_null($factura1))
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
                                <td>{{ $factura3 != null ? $factura3->monto : 0 }}</td>
                                <td>{{ $factura3 != null ? $factura3->deuda : 0 }}</td>
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
            function importExcel() {
                $.ajax({
                    url: `{{ url('cuentas-financieras/create') }}`,
                    method: "GET",
                    data: {
                        view: 'import'
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
            $('#filtro_equipo_id').on('change', function() {
                if ($(this).val()) {
                    $.ajax({
                        url: `{{ url('cuentas-financieras/${$(this).val()}') }}`,
                        method: "GET",
                        data: {
                            view: 'show-select-equipo',
                        },
                        success: function(data) {
                            let opt_user = '<option></option>';
                            data.users.map(function (item) {
                                opt_user += `<option value="${item.id}">${item.name}</option>`;
                            })
                            $('#filtro_user_id').html(opt_user);
                        },
                        error: function( response ) {
                            console.log('error');
                        }
                    });
                } else {
                    $.ajax({
                        url: `{{ url('cuentas-financieras/0') }}`,
                        method: "GET",
                        data: {
                            view: 'show-select-user',
                        },
                        success: function(data) {
                            let opt_user = '<option></option>';
                            data.users.map(function (item) {
                                opt_user += `<option value="${item.id}">${item.name}</option>`;
                            })
                            $('#filtro_user_id').html(opt_user);
                            filterCuentaFinanciera();
                        },
                        error: function( response ) {
                            console.log('error');
                        }
                    });
                }
            });
            $('#filtro_periodo').on('keypress', function(e) {
                if (e.which == 13) {
                    filterCuentaFinanciera();
                }
            });
            $('#filtro_cuentafinanciera').on('keypress', function(e) {
                if (e.which == 13) {
                    filterCuentaFinanciera();
                }
            });
            $('#filtro_ruc').on('keypress', function(e) {
                if (e.which == 13) {
                    filterCuentaFinanciera();
                }
            });
            function filterCuentaFinanciera() {
                window.location.href = `/cuentas-financieras?filtro_equipo_id=${$('#filtro_equipo_id').val()}&filtro_user_id=${$('#filtro_user_id').val()}&filtro_periodo=${$('#filtro_periodo').val()}&filtro_cuentafinanciera=${$('#filtro_cuentafinanciera').val()}&filtro_ruc=${$('#filtro_ruc').val()}`;
            }
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