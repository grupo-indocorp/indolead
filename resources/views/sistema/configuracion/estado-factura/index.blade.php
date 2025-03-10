@extends('layouts.app')

@can('sistema.configuracion')
    @section('content')
        <x-sistema.card-contenedor>
            <div class="w-full pt-2 px-2">
                <x-ui.link>
                    <x-slot:url>{{ url('configuracion') }}</x-slot>
                    <i class="fa-solid fa-arrow-left"></i> Configuración
                </x-ui.link>
            </div>
            <div class="w-full px-2 flex justify-between">
                <h5>Estado de Facturas</h5>
                <x-ui.button onclick="add()">
                    Agregar
                </x-ui.button>
            </div>
            <div class="p-2">
                <x-ui.table id="estado-factura">
                    <x-slot:thead>
                        <tr>
                            <th>Slug</th>
                            <th>Nombre</th>
                            <th>Estado</th>
                            <th></th>
                        </tr>
                    </x-slot>
                    <x-slot:tbody>
                        @foreach ($estados as $item)
                            <tr>
                                <td>{{ $item->id_name }}</td>
                                <td>{{ $item->name }}</td>
                                <td>
                                    <span class="text-xs font-weight-bold mb-0 px-3 py-1 rounded-lg {{ $item->status ? 'bg-green-100' : 'bg-red-100' }}">
                                        {{ $item->status ? 'ACTIVO' : 'INACTIVO' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="ml-2" data-bs-toggle="tooltip" data-bs-original-title="Editar">
                                        <a href="javascript:;" class="cursor-pointer" onclick="edit({{ $item->id }})">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                    </span>
                                    <span class="ml-2" data-bs-toggle="tooltip" data-bs-original-title="Eliminar">
                                        <a href="javascript:;" class="cursor-pointer" onclick="destroy({{ $item->id }})">
                                            <i class="fa-solid fa-trash"></i>
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
            function add() {
                $.ajax({
                    url: `{{ url('configuracion-estado-factura/create') }}`,
                    method: "GET",
                    data: {
                        view: 'create-etapa'
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
            function edit(id) {
                $.ajax({
                    url: `{{ url('configuracion-estado-factura/${id}/edit') }}`,
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
            function destroy(id) {
                $.ajax({
                    url: `{{ url('configuracion-estado-factura/${id}/edit') }}`,
                    method: "GET",
                    data: {
                        view: 'delete'
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
        </script>
    @endsection
@endcan
