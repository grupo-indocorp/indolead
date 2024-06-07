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
                <h3>Excel</h3>
                <x-ui.button onclick="accesoExcel()">
                    Ver Acceso Excel <i class="fa-solid fa-eyes"></i>
                </x-ui.button>
            </div>
        </x-sistema.card-contenedor>
    @endsection

    @section('modal')
    <div id="contModal"></div>
    @endsection

    @section('script')
        <script>
            function accesoExcel() {
                $.ajax({
                    url: `{{ url('configuracion-excel/0/edit') }}`,
                    method: "GET",
                    data: {
                        view: 'edit'
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
