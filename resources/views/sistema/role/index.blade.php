@extends('layouts.app')

@can('sistema.role')
@section('content')
    <x-sistema.card-contenedor>
        <x-sistema.card-contenedor-header title="Roles y Permisos">
            <x-ui.button type="button" onclick="agregarRol()">{{ __('Agregar') }}</x-ui.button>
        </x-sistema.card-contenedor-header>

        {{-- Tabla --}}
        <div class="p-4">
            <x-ui.table id="asd">
                <x-slot:thead>
                    <tr>
                        <th>Rol</th>
                        <th>Fecha de Creación</th>
                        <th>Permisos</th>
                    </tr>
                </x-slot>
                <x-slot:tbody>
                    @foreach ($roles as $role)
                        <tr id="{{ $role->id }}">
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->created_at }}</td>
                            <td>
                                <x-ui.link class="me-2" onclick="permisos({{ $role->id }})" data-bs-toggle="tooltip" data-bs-original-title="Permisos">
                                    <x-slot:url>javascript:;</x-slot>
                                    <i class="fa-solid fa-eyes"></i>
                                </x-ui.link>
                                @role('sistema')
                                <x-ui.link class="me-2" onclick="editarRol({{ $role->id }})" data-bs-toggle="tooltip" data-bs-original-title="Editar">
                                    <x-slot:url>javascript:;</x-slot>
                                    <i class="fa-solid fa-edit"></i>
                                </x-ui.link>
                                <x-ui.link class="me-2" onclick="eliminarRol({{ $role->id }})" data-bs-toggle="tooltip" data-bs-original-title="Eliminar">
                                    <x-slot:url>javascript:;</x-slot>
                                    <i class="fa-solid fa-trash"></i>
                                </x-ui.link>
                                @endrole
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
        function agregarRol() {
            $.ajax({
                url: `{{ url('role/create') }}`,
                method: "GET",
                data: {},
                success: function(result) {
                    $('#contenedorModal').html(result);
                    openModal();
                },
                error: function(response) {
                    console.log('error');
                }
            });
        }
        function permisos(role_id) {
            $.ajax({
                url: `{{ url('role/show-permiso') }}`,
                method: "GET",
                data: {
                    role_id: role_id
                },
                success: function(result) {
                    $('#contenedorModal').html(result);
                    openModal();
                },
                error: function(response) {
                    console.log('error');
                }
            });
        }
        function editarRol(role_id) {
            $.ajax({
                url: `{{ url('role/${role_id}/edit') }}`,
                method: "GET",
                data: {},
                success: function(result) {
                    $('#contenedorModal').html(result);
                    openModal();
                },
                error: function(response) {
                    console.log('error');
                }
            });
        }
        function eliminarRol(role_id) {
        }
    </script>
@endsection
@endcan
