<x-sistema.tabla-contenedor>
    <table class="table align-items-center mb-0">
        <thead>
            <tr>
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-10"></th>
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-10">Nombre</th>
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-10">Descripción</th>
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-10">Formato</th>
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-10">Tamaño</th>
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-10">Categoría</th>
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-10">Subido Por</th>
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-10">Fecha de Actualización</th>
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-10"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($files as $index => $file)
                <tr>
                    <!-- Índice -->
                    <td class="text-center text-xs font-weight-bold mb-0">{{ $index + 1 }}</td>
                    
                    <!-- Nombre -->
                    <td class="text-center text-xs font-weight-bold mb-0">{{ Str::limit($file->name, 20) }}</td>
                    
                    <!-- Descripción -->
                    <td class="text-center text-xs font-weight-bold mb-0">{{ $file->description ?? 'Sin descripción' }}</td>
                    
                    <!-- Formato -->
                    <td class="text-center text-xs font-weight-bold mb-0">
                        <span class="badge bg-secondary">
                            {{ strtoupper($file->format) }}
                        </span>
                    </td>
                    
                    <!-- Tamaño formateado -->
                    <td class="text-center text-xs font-weight-bold mb-0">{{ \App\Helpers\Helpers::formatSizeUnits($file->size) }}</td>
                    
                    <!-- Categoría -->
                    <td class="text-center text-xs font-weight-bold mb-0">{{ $file->category ?? 'Sin categoría' }}</td>
                    
                    <!-- Subido por -->
                    <td class="text-center text-xs font-weight-bold mb-0">{{ $file->uploadedBy->name ?? 'Usuario desconocido' }}</td>
                    
                    <!-- Fecha de subida -->
                    <td class="text-center text-xs font-weight-bold mb-0">{{ $file->created_at->format('d/m/Y') }}</td>
                    
                    <!-- Acciones con iconos -->
                    <td class="text-center text-xs font-weight-bold mb-0">
                        <div class="d-flex justify-content-center gap-3">
                            <!-- Editar -->
                            <a href="#" data-bs-toggle="tooltip" class="text hover-effect" onclick="editarArchivo({{ $file->id }})" title="Editar">
                                <i class="far fa-edit fa-2x"></i>
                            </a>
                            
                            <!-- Descargar -->
                            <a href="#" data-bs-toggle="tooltip" class="text hover-effect" onclick="descargarArchivo({{ $file->id }})" title="Descargar">
                                <i class="far fa-download fa-2x"></i>
                            </a>
                            
                            <!-- Eliminar -->
                            <a href="#" data-bs-toggle="tooltip" class="text hover-effect" onclick="eliminarArchivo({{ $file->id }})" title="Eliminar">
                                <i class="far fa-trash fa-2x"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">No hay archivos disponibles.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</x-sistema.card-contenedor>