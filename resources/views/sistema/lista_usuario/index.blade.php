@extends('layouts.app')

@can('sistema.lista_usuario')
    @section('content')
        <x-sistema.card-contenedor>
            <div class="p-4 pb-0">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <x-sistema.titulo title="Lista de Usuarios" />
                    </div>
                    <div>
                        <a href="javascript:;" class="btn bg-gradient-primary m-0" onclick="agregarUsuario()" type="button">Agregar</a>
                    </div>
                </div>
            </div>
            <div class="p-4">
                <x-sistema.tabla-contenedor>
                    <table class="table align-items-center mb-0" id="table_lista_usuario">
                        <thead>
                            <tr>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nombre</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">DNI</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Correo</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Equipo</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Rol</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Sede</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td class="align-middle text-center">
                                        <h6 class="mb-0 text-xs uppercase">{{ $user->name }}</h6>
                                    </td>
                                    <td class="align-middle text-center">
                                        <h6 class="mb-0 text-xs uppercase">{{ $user->identity_document }}</h6>
                                    </td>
                                    <td class="align-middle text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $user->email }}</p>
                                    </td>
                                    <td class="align-middle text-center">
                                        <p class="text-xs font-weight-bold mb-0 uppercase">{{ $user->equipos->last()->nombre ?? '' }}</p>
                                    </td>
                                    <td class="align-middle text-center">
                                        <p class="text-xs font-weight-bold mb-0 uppercase">{{ $user->getRoleNames()->last() }}</p>
                                    </td>
                                    <td class="align-middle text-center">
                                        <p class="text-xs font-weight-bold mb-0 uppercase">{{ $user->sede->nombre }}</p>
                                    </td>
                                    <td class="align-middle text-right">
                                        @if ($user->getRoleNames()->last() == 'ejecutivo')
                                            <span class="" data-bs-toggle="tooltip" data-bs-original-title="Asignar Equipo">
                                                <a href="javascript:;" class="cursor-pointer" onclick="asignarEquipo({{ $user->id }})">
                                                    <i class="fa-solid fa-sync"></i>
                                                </a>
                                            </span>
                                        @endif
                                        <span class="ml-2" data-bs-toggle="tooltip" data-bs-original-title="Asignar Rol">
                                            <a href="javascript:;" class="cursor-pointer" onclick="asignarRol({{ $user->id }})">
                                                <i class="fa-solid fa-tower-control"></i>
                                            </a>
                                        </span>
                                        <span class="ml-2" data-bs-toggle="tooltip" data-bs-original-title="Editar Usuario">
                                            <a href="javascript:;" class="cursor-pointer" onclick="editarUsuario({{ $user->id }})">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </x-sistema.tabla-contenedor>
            </div>
        </x-sistema.card-contenedor>
    @endsection

    @section('modal')
        <div id="contModal"></div>
    @endsection

    @section('script')
        <script>
            function agregarUsuario() {
                $.ajax({
                    url: `{{ url('lista_usuario/create') }}`,
                    method: "GET",
                    data: {
                        view: 'create'
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
            function asignarEquipo(user_id) {
                $.ajax({
                    url: `{{ url('lista_usuario/${user_id}/edit') }}`,
                    method: "GET",
                    data: {
                        view: 'edit-asignar-equipo'
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
            function asignarRol(user_id) {
                $.ajax({
                    url: `{{ url('lista_usuario/${user_id}/edit') }}`,
                    method: "GET",
                    data: {
                        view: 'edit-asignar-rol'
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
            function editarUsuario(user_id) {
                $.ajax({
                    url: `{{ url('lista_usuario/${user_id}/edit') }}`,
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
            $('#table_lista_usuario').DataTable({
                dom: '<"flex justify-between p-4"fl>rt<"flex justify-between p-4"ip>',
                processing: true,
                language: {
                    search: 'Buscar:',
                    info: 'Mostrando _START_ a _END_ de _TOTAL_ entradas',
                    processing: 'Cargando',
                },
                pageLength: 50,
                order: [],
            });
        </script>
    @endsection
@endcan
