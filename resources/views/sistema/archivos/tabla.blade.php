<x-sistema.tabla-contenedor>
    <table id="filesTable" class="table align-items-center mb-0" style="width:100%">
        <thead>
            <tr>
                <!-- Orden -->
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-10">#</th>

                <!-- Carpeta -->
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-10">Carpeta</th>

                <!-- Categoría -->
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-10">Categoría
                </th>

                <!-- Subido por -->
                @role(['sistema', 'gerente general', 'gerente comercial', 'asistente comercial', 'planificacion'])
                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-10">Subido Por
                    </th>
                @endrole

                <!-- Nombre -->
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-10">Nombre</th>

                <!-- Descripción -->
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-10">Descripción
                </th>

                <!-- Formato -->
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-10">Formato</th>

                <!-- Tamaño -->
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-10">Tamaño</th>

                <!-- Fecha de Actualización -->
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-10">Fecha de
                    Actualización</th>

                <!-- Acciones -->
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-10">Acciones
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse($files as $index => $file)
                <tr>
                    <!-- Orden -->
                    <td class="text-center text-xs font-weight-bold mb-0">{{ $index + 1 }}</td>

                    <!-- Carpeta -->
                    <td class="text-center text-xs font-weight-bold mb-0">
                        {{ $file->folder->name ?? 'Sin carpeta' }}
                    </td>

                    <!-- Categoría -->
                    <td class="text-center text-xs font-weight-bold mb-0">
                        {{ $file->category ?? 'Sin categoría' }}
                    </td>

                    <!-- Subido por -->
                    @role(['sistema', 'gerente general', 'gerente comercial', 'asistente comercial', 'planificacion'])
                        <td class="text-center text-xs font-weight-bold mb-0">
                            {{ $file->uploadedBy->name ?? 'Usuario desconocido' }}
                        </td>
                    @endrole

                    <!-- Nombre -->
                    <td class="text-center text-xs font-weight-bold mb-0">
                        {{ Str::limit($file->name, 25) }}
                    </td>

                    <!-- Descripción -->
                    <td class="text-center text-xs font-weight-bold mb-0">
                        {{ Str::limit($file->description, 35) ?? 'Sin descripción' }}
                    </td>

                    <!-- Formato -->
                    <td class="text-center text-xs font-weight-bold mb-0">
                        <span class="badge bg-secondary">
                            {{ strtoupper($file->format) }}
                        </span>
                    </td>

                    <!-- Tamaño -->
                    <td class="text-center text-xs font-weight-bold mb-0">
                        {{ \App\Helpers\Helpers::formatSizeUnits($file->size) }}
                    </td>

                    <!-- Fecha de Actualización -->
                    <td class="text-center text-xs font-weight-bold mb-0">
                        {{ $file->updated_at->format('d/m/Y H:i') }}
                    </td>

                    <!-- Acciones -->
                    <td class="text-center text-xs font-weight-bold mb-0">
                        <div class="d-flex justify-content-center gap-3">
                            <!-- Editar -->
                            <a href="#" data-bs-toggle="tooltip" class="text hover-effect"
                                onclick="editarArchivo({{ $file->id }})" title="Editar">
                                <i class="far fa-edit fa-2x"></i>
                            </a>

                            <!-- Descargar -->
                            <a href="#" data-bs-toggle="tooltip" class="text hover-effect"
                                onclick="descargarArchivo({{ $file->id }})" title="Descargar">
                                <i class="far fa-download fa-2x"></i>
                            </a>

                            <!-- Eliminar -->
                            <a href="#" data-bs-toggle="tooltip" class="text hover-effect"
                                onclick="eliminarArchivo({{ $file->id }})" title="Eliminar">
                                <i class="far fa-trash fa-2x"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center">No hay archivos disponibles.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <style>
        /* Estilo para el buscador alineado a la izquierda */
        .dataTables_wrapper .dataTables_filter {
            float: left !important;
            margin-bottom: 15px;
        }

        .dataTables_wrapper .dataTables_filter input {
            margin-left: 0 !important;
            border: 1px solid #ddd;
            padding: 5px 10px;
            border-radius: 4px;
        }

        /* Estilo para el selector de cantidad de registros */
        .dataTables_wrapper .dataTables_length {
            float: right;
            margin-top: 5px;
        }

        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #ddd;
            padding: 4px;
            border-radius: 4px;
            margin: 0 5px;
        }

        /* Estilo para la paginación */
        .dataTables_wrapper .dataTables_paginate {
            margin-top: 10px;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#filesTable').DataTable({
                responsive: true,
                // Paginación de 100 en 100
                pageLength: 100,
                lengthMenu: [
                    [100, 200, 500, -1],
                    [100, 200, 500, "Todos"]
                ],

                // Configuración del DOM para mover el buscador a la izquierda
                dom: '<"toolbar">frtlip',
                language: {
                    "decimal": "",
                    "emptyTable": "No hay datos disponibles en la tabla",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    "infoEmpty": "Mostrando 0 a 0 de 0 registros",
                    "infoFiltered": "(filtrado de _MAX_ registros totales)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ registros por página",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "No se encontraron registros coincidentes",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
                initComplete: function() {
                    // Mover el buscador a la izquierda
                    $('.dataTables_filter').css('float', 'left');
                    $('.dataTables_filter').css('margin-bottom', '10px');

                    // Eliminar clases adicionales de DataTables
                    $(this).removeClass('dataTable no-footer');
                    $(this).find('thead th').removeClass('sorting sorting_asc sorting_desc');
                },
                columnDefs: [{
                        orderable: false,
                        targets: [0, 9]
                    },
                    {
                        searchable: false,
                        targets: [0, 9]
                    }
                ],
                order: [
                    [8, 'desc']
                ],
                drawCallback: function(settings) {
                    // Eliminar estilos inline que DataTables añade
                    $(this).find('th, td').css({
                        'padding': '',
                        'border-top': '',
                        'border-bottom': ''
                    });
                }
            });
        });
    </script>
    
</x-sistema.tabla-contenedor>
