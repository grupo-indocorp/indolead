@extends('layouts.app')

@can('sistema.equipo')
    @section('content')
        <x-sistema.card-contenedor>
            <div class="p-4 pb-0">
                <div class="d-flex flex-row justify-content-between">
                    <x-sistema.titulo title="Equipos" />
                    <a href="javascript:;" class="btn bg-gradient-primary m-0" onclick="agregarEquipo()" type="button">Agregar</a>
                </div>
            </div>
            <div class="p-4">
                <x-sistema.tabla-contenedor>
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nombre</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jefe</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Sede</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($equipos as $equipo)
                            <tr>
                                <td class="align-middle text-uppercase text-sm">
                                    <span class="text-secondary text-sm font-weight-normal">
                                        <strong>{{ $equipo->nombre }}</strong>
                                    </span>
                                </td>
                                <td class="align-middle text-uppercase text-sm">
                                    <span class="text-secondary text-xs font-weight-normal">{{ $equipo->user->name ?? '' }}</span>
                                </td>
                                <td class="align-middle text-uppercase text-sm">
                                    <span class="text-secondary text-xs font-weight-normal">{{ $equipo->sede->nombre ?? '' }}</span>
                                </td>
                                <td class="align-center">
                                    <span class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Editar">
                                        <a href="javascript:;" class="cursor-pointer" onclick="editarEquipo({{ $equipo->id }})">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                    </span>
                                    <span class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Ejecutivos">
                                        <a href="javascript:;" class="cursor-pointer" onclick="listarEjecutivo({{ $equipo->id }})">
                                            <i class="fa-solid fa-list"></i>
                                        </a>
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="" colspan="6">
                                    {{ $equipos->links() }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </x-sistema.tabla-contenedor>
            </div>
        </x-sistema.card-contenedor>
    @endsection
    @section('modal')
        <div id="contModal"></div>
    @endsection
    <script>
        function agregarEquipo() {
            $.ajax({
                url: `{{ url('equipo/create') }}`,
                method: "GET",
                data: {
                    view: 'create',
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
        function editarEquipo(equipo_id) {
            $.ajax({
                url: `{{ url('equipo/${equipo_id}/edit') }}`,
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
        function listarEjecutivo(equipo_id) {
            $.ajax({
                url: `{{ url('equipo/${equipo_id}/edit') }}`,
                method: "GET",
                data: {
                    view: 'edit-ejecutivo'
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
