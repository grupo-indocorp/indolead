@extends('layouts.app')

@can('sistema.vista')
    @section('content')
        <x-sistema.card-contenedor>
            <div class="p-4 pb-0">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <x-sistema.titulo title="Biblioteca" />
                    </div>
                </div>
            </div>

            <!-- Campo de búsqueda mejorado -->
            <div class="container-fluid">
                <div class="p-4">
                    <div class="mb-4" style="max-width: 400px;">
                        <input type="text" id="searchInput" class="form-control form-control-lg border-secondary"
                            placeholder="Buscar archivos..." aria-label="Buscar archivos" style="border-radius: 10px;">
                    </div>

                    <!-- Contenido de la vista -->
                    @if ($folders->count() > 0)
                        @foreach ($folders as $folder)
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-white border-secondary" style="cursor: pointer;"
                                    onclick="toggleFolder('folder-{{ $folder->id }}')">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-folder text-warning fs-4 me-3"></i>
                                            <h5 class="mb-0 fw-bold">{{ $folder->name }}</h5>
                                        </div>
                                        <i id="arrow-{{ $folder->id }}" class="fas fa-chevron-down fs-5 text-muted"></i>
                                    </div>
                                </div>

                                <div class="card-body bg-white p-0" id="folder-{{ $folder->id }}"
                                    style="display: {{ $loop->last ? 'block' : 'none' }};">
                                    @if ($folder->files->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="text-center align-middle">Categoría</th>
                                                    <th class="text-center align-middle">Nombre</th>
                                                    <th class="text-center align-middle">Descripción</th>
                                                    <th class="text-center align-middle">Formato</th>
                                                    <th class="text-center align-middle">Tamaño</th>
                                                    <th class="text-center align-middle">Fecha</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($folder->files as $file)
                                                    <tr class="file-item" 
                                                        data-name="{{ Str::lower($file->name) }}"
                                                        data-description="{{ Str::lower($file->description) }}"
                                                        data-category="{{ Str::lower($file->category) }}"
                                                        onclick="window.location.href='{{ route('files.download', $file->id) }}'"
                                                        style="cursor: pointer; border-top: 1.5px solid #888787;">
                                                        
                                                        <!-- Categoría -->
                                                        <td class="text-center align-middle">
                                                            {{ $file->category ?? 'Sin categoría' }}
                                                        </td>
                                                        
                                                        <!-- Nombre -->
                                                        <td title="{{ $file->name }}">
                                                            <i class="far fa-file text-muted me-2 ps-4"></i>
                                                            {{ Str::limit($file->name, 30, '...') }}
                                                        </td>
                                                        
                                                        <!-- Descripción -->
                                                        <td class="text-center align-middle">
                                                            {{ Str::limit($file->description, 50, '...') ?? 'Sin descripción' }}
                                                        </td>
                                                        
                                                        <!-- Formato -->
                                                        <td class="text-center align-middle">
                                                            <span class="badge bg-light text-dark border">
                                                                {{ strtoupper($file->format) }}
                                                            </span>
                                                        </td>
                                                        
                                                        <!-- Tamaño -->
                                                        <td class="text-center align-middle">
                                                            {{ \App\Helpers\Helpers::formatSizeUnits($file->size) }}
                                                        </td>
                                                        
                                                        <!-- Fecha -->
                                                        <td class="text-center align-middle">
                                                            <div class="d-flex align-items-center justify-content-center">
                                                                <i class="far fa-calendar-alt me-1"></i>
                                                                {{ $file->created_at->format('d/m/Y H:i') }}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @else
                                        <div class="alert alert-info m-4">
                                            No hay archivos en esta carpeta
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="alert alert-warning m-4">
                            No hay carpetas disponibles
                        </div>
                    @endif
                </div>
            </div>
        </x-sistema.card-contenedor>
    @endsection

    @section('script')
        <script>
            // Función mejorada para mostrar/ocultar carpetas
            function toggleFolder(folderId) {
                const folderContent = document.getElementById(folderId);
                const arrow = document.getElementById(`arrow-${folderId}`);

                folderContent.style.display = folderContent.style.display === 'none' ? 'block' : 'none';
                arrow.classList.toggle('fa-chevron-down');
                arrow.classList.toggle('fa-chevron-up');
            }

            // Función de búsqueda optimizada que incluye categoría
            document.getElementById('searchInput').addEventListener('input', function() {
                const query = this.value.trim().toLowerCase();

                document.querySelectorAll('.file-item').forEach(item => {
                    const name = item.dataset.name;
                    const desc = item.dataset.description;
                    const category = item.dataset.category || '';
                    const matches = name.includes(query) || 
                                   desc.includes(query) || 
                                   category.includes(query);
                    
                    item.style.display = matches ? '' : 'none';
                });
            });

            // Auto-abrir última carpeta al cargar
            window.addEventListener('DOMContentLoaded', () => {
                const lastFolder = document.querySelector('.card-body:last-of-type');
                const lastArrow = document.querySelector('.card-header:last-of-type i');
                if (lastFolder && lastArrow) {
                    lastFolder.style.display = 'block';
                    lastArrow.classList.replace('fa-chevron-down', 'fa-chevron-up');
                }
            });
        </script>
    @endsection
@endcan