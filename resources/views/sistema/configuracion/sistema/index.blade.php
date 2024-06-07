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
            <div class="w-full py-2 px-4 flex justify-between">
                <h3>Sistema</h3>
                @if (isset($sistema))
                    <x-ui.button onclick="editarSistema()">
                        Editar <i class="fa-solid fa-eyes"></i>
                    </x-ui.button>
                @else
                    <x-ui.button onclick="agregarSistema()">
                        Agregar <i class="fa-solid fa-eyes"></i>
                    </x-ui.button>
                @endif
            </div>
            <div class="w-1/4">
                <x-sistema.card>
                    @if (isset($sistema))
                        <div class="card bg-white">
                            <div class="card-header p-0 mx-3 mt-3 position-relative z-index-1">
                                <a href="javascript:;" class="d-block">
                                    <img src="{{ Storage::url($sistema->logo) }}" class="img-fluid border-radius-lg">
                                </a>
                            </div>
                            <div class="card-body pt-2 bg-white">
                                <div class="author align-items-center">
                                    <img src="{{ Storage::url($sistema->icono) }}" class="avatar shadow">
                                    <div>
                                        <span class="text-gradient text-primary text-xs font-weight-bold my-2">Empresa:</span>
                                        <a href="javascript:;" class="card-title h5 d-block text-darker">
                                            {{ $sistema->nombre }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </x-sistema.card>
            </div>
        </x-sistema.card-contenedor>
    @endsection
    @section('modal')
        <div id="contModal"></div>
    @endsection
    @section('script')
        <script>
            function agregarSistema() {
                $.ajax({
                    url: `{{ url('configuracion-sistema/create') }}`,
                    method: "GET",
                    data: {
                        view: 'create-sistema'
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
            function editarSistema() {
                $.ajax({
                    url: `{{ url('configuracion-sistema/0/edit') }}`,
                    method: "GET",
                    data: {
                        view: 'edit-sistema'
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
