@extends('layouts.app')

@can('sistema.lista_usuario')
    @section('content')
        <x-sistema.card-contenedor>
            <x-sistema.card-contenedor-header title="Lista de Usuarios">
                <x-ui.button type="button" onclick="agregarUsuario()">{{ __('Agregar') }}</x-ui.button>
            </x-sistema.card-contenedor-header>
            <div class="p-4">
                <x-ui.table id="table_lista_usuario">
                    <x-slot:thead>
                        <tr>
                            <th>Nombre</th>
                            <th>DNI</th>
                            <th>Correo</th>
                            <th>Equipo</th>
                            <th>Rol</th>
                            <th>Sede</th>
                            <th></th>
                        </tr>
                    </x-slot>
                    <x-slot:tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->identity_document }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->equipos->last()->nombre ?? '' }}</td>
                                <td>{{ $user->getRoleNames()->last() }}</td>
                                <td>{{ $user->sede->nombre }}</td>
                                <td>
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
                    </x-slot>
                    <x-slot:tfoot></x-slot>
                </x-ui.table>
            </div>
        </x-sistema.card-contenedor>
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
                        $('#contenedorModal').html(result);
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
                        $('#contenedorModal').html(result);
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
                        $('#contenedorModal').html(result);
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
                        $('#contenedorModal').html(result);
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
