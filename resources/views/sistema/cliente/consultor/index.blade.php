@extends('layouts.app')
@section('content')
    <x-sistema.card-contenedor>
        <div class="p-4 pb-0">
            <div class="d-flex flex-row flex-wrap justify-content-between">
                <x-sistema.titulo title="Consultor Clientes" />
                <div class="w-full">
                    @livewire('busqueda', ['mensaje' => $mensaje])
                </div>
            </div>
        </div>
        <div class="p-4">
            <x-sistema.tabla-contenedor>
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-10">RUC</th>
                            <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-10">Razón Social</th>
                            <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-10">EECC</th>
                            <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-10">Fecha de última Gestión</th>
                            <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-10">Etapa</th>
                            <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-10">Días sin Gestión</th>
                            <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-10">Solicitar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!is_null($cliente))
                            @php
                                $fecha_gestion = Carbon\Carbon::parse($cliente->fecha_gestion)->startOfDay();
                                $dias = $fecha_gestion->diffInDays(now()->startOfDay());
                            @endphp
                            <tr id="{{ $cliente->id }}">
                                <td class="align-middle text-center">
                                    @role(['sistema', 'gerente general', 'gerente comercial', 'asistente comercial', 'jefe comercial', 'capacitador', 'planificacion'])
                                        <h6 class="mb-0 text-xs hover:cursor-pointer" onclick="detalleCliente({{ $cliente->id }})">{{ $cliente->ruc }}</h6>
                                    @else
                                        <h6 class="mb-0 text-xs">{{ $cliente->ruc }}</h6>
                                    @endrole
                                </td>
                                <td class="align-middle text-center">
                                    <p class="text-xs font-weight-bold mb-0">{{ substr($cliente->razon_social, 0, 30) }}</p>
                                </td>
                                <td class="align-middle text-center">
                                    <p class="text-xs font-weight-bold mb-0">{{ $cliente->equipo->nombre }}</p>
                                    <p class="text-xs text-secondary mb-0">{{ $cliente->user->name }}</p>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="text-secondary text-xs font-weight-normal">{{ $fecha_gestion->format('d/m/Y') }}</span>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="text-xs font-semibold font-se mb-0 px-3 py-1 rounded-lg" style="background-color: {{ $cliente->etapa->opacity }};">
                                        {{ $cliente->etapa->nombre }}
                                    </span>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    @if ($dias >= $cliente->etapa->blindaje)
                                        <span class="text-xs font-weight-bold mb-0 px-3 py-1 rounded-lg bg-red-100">{{ $dias }}</span>
                                    @else
                                        <span class="text-xs font-weight-bold mb-0 px-3 py-1 rounded-lg bg-green-100">{{ $dias }}</span>
                                    @endif
                                </td>
                                <td class="align-middle text-center">
                                    @role('ejecutivo')
                                        @if ($dias >= $cliente->etapa->blindaje)
                                            <span class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Solicitar">
                                                <a href="javascript:;" class="cursor-pointer" onclick="solicitarCliente({{ $cliente->id }})">
                                                    <i class="fa-solid fa-hand-point-up"></i>
                                                </a>
                                            </span>
                                        @endif
                                    @else
                                        <span class="text-xs font-semibold font-se mb-0 px-3 py-1 rounded-lg bg-red-100">Solo los ejecutivos pueden solicitar</span>
                                    @endrole
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </x-sistema.tabla-contenedor>
        </div>
    </x-sistema.card-contenedor>
@endsection

@section('modal')
    <div id="contModal"></div>
@endsection
<script>
    function detalleCliente(cliente_id) {
        $.ajax({
            url: `{{ url('cliente-gestion/${cliente_id}/edit') }}`,
            method: "GET",
            data: {
                view: 'edit-detalle'
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
    function solicitarCliente(cliente_id) {
        $.ajax({
            url: `{{ url('cliente-consultor/${cliente_id}') }}`,
            method: "GET",
            data: {
                view: 'show-cliente',
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
    function closeFicha() {
        closeModal();
    }
</script>
