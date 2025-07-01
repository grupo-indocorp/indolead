@extends('layouts.app')

@can('sistema.files')
    @section('content')
        <x-sistema.card-contenedor>
            <div class="p-4 pb-0">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <x-sistema.titulo title="Gestión de Biblioteca" />
                    </div>
                    <div>
                        <x-ui.button type="button" onclick="agregarArchivo()">Subir Archivo</x-ui.button>
                    </div>
                </div>
            </div>
            <div class="p-4" id="cont-tabla-archivos">
                @include('sistema.archivos.tabla')
            </div>
        </x-sistema.card-contenedor>
    @endsection

    @section('modal')
        <div id="contModal"></div>
    @endsection

    @section('script')
        <!-- Define la ruta base para descargas -->
        <script>
            window.downloadRouteBase = "{{ url('files') }}"; // http://public.test/files
        </script>

        <!-- Funciones JavaScript -->
        <script>
            // Función para abrir modal de subida
            function agregarArchivo() {
                $.ajax({
                    url: `{{ route('files.create') }}`,
                    method: "GET",
                    success: function(result) {
                        $('#contModal').html(result);
                        $('#uploadFileModal').modal('show');
                    },
                    error: function(response) {
                        console.error('Error al cargar modal:', response);
                    }
                });
            }

            // Función para eliminar archivo
            function eliminarArchivo(id) {
                if (confirm('¿Eliminar archivo permanentemente?')) {
                    $.ajax({
                        url: `{{ url('files') }}/${id}`,
                        method: "DELETE",
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function() {
                            location.reload();
                        },
                        error: function(response) {
                            console.error('Error al eliminar:', response);
                        }
                    });
                }
            }
        </script>

        <!-- Incluye el archivo JS DESPUÉS de definir variables -->
        <script src="{{ asset('js/indotech.js') }}"></script>
        <!-- jQuery (necesario para DataTables) -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- DataTables CSS -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">

        <!-- DataTables JS -->
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

        <!-- DataTables Responsive (opcional, para mejor visualización en móviles) -->
        <link rel="stylesheet" type="text/css"
            href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
        <script type="text/javascript" charset="utf8"
            src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    @endsection
@endcan
