@extends('layouts.app')

@section('content')
    <x-sistema.card-contenedor>
        <x-sistema.card-contenedor-header title="Inventarios">
            <x-ui.button type="button" onclick="agregarInventario()">
                {{ __('Agregar') }}
            </x-ui.button>
        </x-sistema.card-contenedor-header>
        
        <div class="p-4">
            <x-ui.table id="table_inventario">
                <x-slot:thead>
                    <tr>
                        <th>Código</th>
                        <th>Categoría</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Estado</th>
                        <th>Opciones</th>
                    </tr>
                </x-slot>
                <x-slot:tbody>
                    @foreach ($inventarios as $inventario)
                        <tr id="{{ $inventario->id }}">
                            <td>{{ $inventario->codigo }}</td>
                            <td>{{ $inventario->categoria }}</td>
                            <td>{{ $inventario->marca }}</td>
                            <td>{{ $inventario->modelo }}</td>
                            <td>{{ $inventario->estado }}</td>
                            <td>
                                <x-ui.link class="me-2" onclick="editarInventario({{ $inventario->id }})" data-bs-toggle="tooltip" data-bs-original-title="Editar">
                                    <x-slot:url>javascript:;</x-slot>
                                    <i class="fa-solid fa-pen"></i>
                                </x-ui.link>
                                <x-ui.link class="me-2 text-danger" onclick="eliminarInventario({{ $inventario->id }})" data-bs-toggle="tooltip" data-bs-original-title="Eliminar">
                                    <x-slot:url>javascript:;</x-slot>
                                    <i class="fa-solid fa-trash"></i>
                                </x-ui.link>
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
        function agregarInventario() {
            $.ajax({
                url: `{{ url('inventario/create') }}`,
                method: "GET",
                success: function(result) {
                    $('#contenedorModal').html(result); // Cargar contenido dinámico en el contenedor
                    openModal(); 
                },
                error: function() {
                    console.error('Error al cargar el formulario de creación.');
                }
            });
        }

        function editarInventario(inventario_id) {
            $.ajax({
                url: `{{ url('inventario/${inventario_id}/edit') }}`,
                method: "GET",
                success: function(result) {
                    $('#contenedorModal').html(result); // Cargar contenido dinámico en el contenedor
                    openModal(); 
                },
                error: function() {
                    console.error('Error al cargar el formulario de edición.');
                }
            });
        }

        function eliminarInventario(inventario_id) {
            if (!confirm('¿Estás seguro de eliminar este inventario?')) return;

            $.ajax({
                url: `{{ url('inventario/${inventario_id}') }}`,
                method: "DELETE",
                data: {
                    _token: `{{ csrf_token() }}`
                },
                success: function() {
                    alert('Inventario eliminado correctamente.');
                    location.reload();
                },
                error: function() {
                    console.error('Error al eliminar el inventario.');
                }
            });
        }

        // Inicializar DataTable
        $('#table_inventario').DataTable({
            dom: '<"flex justify-between p-4"fl>rt<"flex justify-between p-4"ip>',
            processing: true,
            language: {
                search: 'Buscar:',
                info: 'Mostrando _START_ a _END_ de _TOTAL_ entradas',
                processing: 'Cargando...'
            },
            pageLength: 50,
            order: [],
        });
    </script>
@endsection
