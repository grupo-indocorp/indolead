@extends('layouts.app')

@section('content')
    <x-sistema.card-contenedor>
        <div class="p-4 pb-0">
            <div class="d-flex flex-row justify-content-between">
                <div>
                    <x-sistema.titulo title="Visualización de Archivos" />
                </div>
            </div>
        </div>
        <div class="p-4" id="cont-tabla-archivos">
            @include('sistema.archivos.diseño')
        </div>
    </x-sistema.card-contenedor>
@endsection

@section('script')
    <!-- Define la ruta base para descargas -->
    <script>
        window.downloadRouteBase = "{{ url('files') }}"; // http://public.test/files
    </script>

    <!-- Incluye el archivo JS DESPUÉS de definir variables -->
    <script src="{{ asset('js/indotech.js') }}"></script>
@endsection