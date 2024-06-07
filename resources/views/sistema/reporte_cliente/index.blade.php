@extends('layouts.app')

@can('sistema.reporte.cliente')
    @section('content')
        <x-sistema.card-contenedor>
            <div class="p-4">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <x-sistema.titulo title="Reporte de Clientes"/>
                    </div>
                    <div>
                        @can('sistema.gestion_cliente.exportar')
                            <input type="date" name="fecha_filtro" id="fecha_filtro">
                            <a href="javascript:;" class="btn bg-gradient-primary m-0" onclick="exportCliente()" type="button">Descargar</a>
                        @endcan
                        <a href="javascript:;" class="btn bg-gradient-primary m-0" onclick="filtrarCliente()" type="button">Filtrar</a>
                    </div>
                </div>
            </div>
            <div class="p-4">
                <x-sistema.tabla-contenedor>
                    <table class="table align-items-center mb-0" id="table_notificacion">
                        <thead>
                            <tr>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Equipo</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ejecutivo</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ruc</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Razón Social</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ciudad</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nombre de Contacto</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Celular de Contacto</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </x-sistema.tabla-contenedor>
            </div>
        </x-sistema.card-contenedor>
    @endsection
@endcan