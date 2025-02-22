@extends('layouts.app')

@section('content')
    <!-- Contenido de la vista -->
    <div class="container-fluid">
        <div class="p-4">
            @if ($folders->count() > 0)
                @foreach ($folders as $folder)
                    <div class="card mb-4" style="background-color: #e0e2e6; border-radius: 15px">
                        <div class="card-header bg-secondary" style="cursor: pointer;" onclick="toggleFolder('folder-{{ $folder->id }}')">
                            <h5 class="card-title mb-0 d-flex justify-content-between align-items-center" style="border-radius: 15px">
                                <span>
                                    <i class="fas fa-folder me-2"></i> {{ $folder->name }}
                                </span>
                                <i id="arrow-{{ $folder->id }}" class="fas fa-chevron-down"></i> <!-- Flecha hacia abajo -->
                            </h5>
                        </div>
                        <div class="card-body" id="folder-{{ $folder->id }}" style="background-color: #e0e2e6; border-radius: 15px; display: {{ $loop->last ? 'block' : 'none' }};">
                            @if ($folder->files->count() > 0)
                                <div class="row">
                                    @foreach ($folder->files as $file)
                                        <div class="col-md-3 mb-4">
                                            <a href="{{ route('files.download', $file->id) }}" class="card h-100 text-decoration-none" style="color: inherit;">
                                                <div class="card-body" style="background-color: #ffffff; border-radius: 15px;">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h6 class="card-title" title="{{ $file->name }}">
                                                            <i class="far fa-file me-2"></i> {{ Str::limit($file->name, 20) }}
                                                        </h6>
                                                        <span class="text-muted small">
                                                            <i class="far fa-calendar-alt me-1"></i> {{ $file->created_at->format('d/m/Y') }}
                                                        </span>
                                                    </div>
                                                    <p class="card-text text-muted small">
                                                        {{ Str::limit($file->description, 150) ?? 'Sin descripción' }}
                                                    </p>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="badge bg-secondary">
                                                            {{ strtoupper($file->format) }}
                                                        </span>
                                                        <span class="text-muted small">
                                                            {{ \App\Helpers\Helpers::formatSizeUnits($file->size) }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-info mb-0">
                                    No hay archivos en esta carpeta.
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <div class="alert alert-warning">
                    No hay carpetas disponibles.
                </div>
            @endif
        </div>
    </div>
@endsection

@section('script')
    <script>
        // Función para mostrar/ocultar carpetas
        function toggleFolder(folderId) {
            const folderContent = document.getElementById(folderId);
            const arrow = document.getElementById(`arrow-${folderId}`);

            if (folderContent.style.display === "none") {
                folderContent.style.display = "block";
                arrow.classList.remove('fa-chevron-down');
                arrow.classList.add('fa-chevron-up'); // Cambia la flecha hacia arriba
            } else {
                folderContent.style.display = "none";
                arrow.classList.remove('fa-chevron-up');
                arrow.classList.add('fa-chevron-down'); // Cambia la flecha hacia abajo
            }
        }

        // Abrir automáticamente la última carpeta al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            const lastFolder = document.querySelector('.card-body:last-of-type');
            const lastFolderArrow = document.querySelector('.card-header:last-of-type i');

            if (lastFolder && lastFolderArrow) {
                lastFolder.style.display = 'block';
                lastFolderArrow.classList.remove('fa-chevron-down');
                lastFolderArrow.classList.add('fa-chevron-up');
            }
        });
    </script>
@endsection