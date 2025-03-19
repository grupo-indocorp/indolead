@extends('layouts.app')

@can('sistema.configuracion')
    @section('content')
        <x-sistema.card-contenedor>
            <div class="w-full py-2 px-4">
                <x-ui.link>
                    <x-slot:url>{{ url('configuracion') }}</x-slot>
                    <i class="fa-solid fa-arrow-left"></i> Configuración
                </x-ui.link>
            </div>
            <div class="w-full px-4 flex justify-between">
                <h3>Etapas</h3>
                <x-ui.button onclick="agregarEtapa()">
                    Agregar <i class="fa-solid fa-eyes"></i>
                </x-ui.button>
            </div>
            <div class="w-1/4 px-4 pb-4">
                <x-sistema.card>
                    <div class="timeline timeline-one-side">
                        @foreach ($etapas as $etapa)
                            <div class="timeline-block">
                                <span class="timeline-step text-slate-400" style="background-color: {{ $etapa->opacity }}; color: {{ $etapa->color }};">
                                    <i class="fa-solid fa-bell"></i>
                                </span>
                                <div class="timeline-content mb-2">
                                    <h6 class="text-dark text-sm font-weight-bold m-0">{{ $etapa->nombre }}</h6>
                                    <button onclick="editarEtapa({{ $etapa->id }})">Editar</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-sistema.card>
            </div>
        </x-sistema.card-contenedor>
    @endsection
    @section('script')
        <script>
            function agregarEtapa() {
                $.ajax({
                    url: `{{ url('configuracion-etapa/create') }}`,
                    method: "GET",
                    data: {
                        view: 'create-etapa'
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
            function editarEtapa(etapa_id) {
                $.ajax({
                    url: `{{ url('configuracion-etapa/${etapa_id}/edit') }}`,
                    method: "GET",
                    data: {
                        view: 'edit-etapa'
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
            function eliminarEtapa(etapa_id) {
                $.ajax({
                    url: `{{ url('configuracion-etapa/${etapa_id}/edit') }}`,
                    method: "GET",
                    data: {
                        view: 'delete-etapa'
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
