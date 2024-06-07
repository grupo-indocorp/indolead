@extends('layouts.app')

@can('sistema.reporte')
    @section('content')
        <div class="grid grid-cols-3 gap-4">
            <a href="{{ url('reporte_cliente_nuevo') }}">
                <x-ui.card-icon>
                    <x-slot:icon>
                        <i class="fa-solid fa-mug-hot"></i>
                    </x-slot:icon>
                    <x-slot:title>Clientes Nuevos</x-slot>
                    <x-slot:subtitle>Reportes</x-slot>
                </x-ui.card-icon>
            </a>
        </div>
    @endsection
    @section('modal')
        <div id="contModal"></div>
    @endsection
    <script>
        function filtrarCliente() {
            $.ajax({
                url: `{{ url('reporte/create') }}`,
                method: "GET",
                data: {
                    view: 'create-filtro-cliente',
                    fecha_desde: $('#fecha_desde').val(),
                    fecha_hasta: $('#fecha_hasta').val(),
                    sede_id: $('#sede_id').val(),
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
@endcan