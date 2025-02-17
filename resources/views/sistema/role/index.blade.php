@extends('layouts.app')

@can('sistema.role')
    @section('content')
        <x-sistema.card-contenedor class="max-w-[50vh] overflow-y-auto">
            <x-sistema.card-contenedor-header title="Roles y Permisos" >
                <x-ui.button type="button" onclick="agregarRol()" class="bg-indigo-600 hover:bg-indigo-700">
                    {{ __('Agregar Rol') }}
                </x-ui.button>
            </x-sistema.card-contenedor-header>

            {{-- Tabla Mejorada --}}
            <div class="p-4">
                <x-ui.table class="w-auto max-w-md">
                    <x-slot:thead>
                        <tr class="bg-gray-50">
                            <th class="px-5 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider w-1/2">Rol
                            </th>
                            <th class="px-5 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider w-1/2">
                                Fecha de Creación</th>
                            <th class="px-5 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider w-1/2">
                                Permisos</th>
                        </tr>
                    </x-slot>
                    <x-slot:tbody>
                        @foreach ($roles as $role)
                            <tr class="hover:bg-white transition-colors" id="{{ $role->id }}">
                                <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $role->name }}
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">
                                    {{ $role->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-600">
                                    <div class="flex items-center space-x-4">
                                        <x-ui.link onclick="permisos({{ $role->id }})"
                                            class="text-indigo-600 hover:text-indigo-900" data-bs-toggle="tooltip"
                                            data-bs-original-title="Gestionar Permisos">
                                            <x-slot:url>javascript:;</x-slot>
                                            <i class="fa-solid fa-shield-halved mr-1"></i> Administrar
                                        </x-ui.link>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </x-slot>
                    <x-slot:tfoot>
                        <!-- Pie de tabla vacío -->
                    </x-slot>
                </x-ui.table>

                {{-- Mensaje cuando no hay datos --}}
                @if ($roles->isEmpty())
                    <div class="p-6 text-center text-gray-500">
                        No se encontraron roles registrados
                    </div>
                @endif
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

            function eliminarRol(role_id) {}
        </script>
    @endsection
@endcan
