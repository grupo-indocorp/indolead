<x-sistema.tabla-contenedor>
    <table class="table align-items-center mb-0">
        <thead>
            <tr>
                <!-- Orden -->
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-10">#</th>
                
                <!-- Carpeta -->
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-10">Carpeta</th>
                
                <!-- Categoría -->
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-10">Categoría</th>
                
                <!-- Subido por -->
                @role(['sistema', 'gerente general', 'gerente comercial', 'asistente comercial', 'planificacion'])
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-10">Subido Por</th>
                @endrole

                <!-- Nombre -->
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-10">Nombre</th>
                
                <!-- Descripción -->
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-10">Descripción</th>
                
                <!-- Formato -->
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-10">Formato</th>
                
                <!-- Tamaño -->
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-10">Tamaño</th>
                
                <!-- Fecha de Actualización -->
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-10">Fecha de Actualización</th>
                
                <!-- Acciones -->
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-10">Acciones</th>
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
                    <td colspan="10" class="text-center">No hay archivos disponibles.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</x-sistema.tabla-contenedor>