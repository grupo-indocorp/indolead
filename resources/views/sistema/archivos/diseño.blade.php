<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
    @forelse($files as $file)
        <div class="col">
            <div class="card file-card shadow-sm h-100" onclick="descargarArchivo({{ $file->id }})" style="cursor: pointer;">
                <!-- Encabezado de la tarjeta -->
                <div class="card-header bg-light d-flex justify-content-between align-items-center rounded-top p-3">
                    <!-- Número de iteración -->
                    <small class="text-muted">{{ $loop->iteration }}</small>
                    
                    <!-- Nombre del archivo (responsivo) y formato -->
                    <div class="d-flex align-items-center gap-2">
                        <h6 class="card-title fw-bold mb-0 text-truncate" title="{{ $file->name }}">
                            <!-- Vista grande (25 caracteres) -->
                            <span class="d-none d-xl-inline">{{ Str::limit($file->name, 25) }}</span>
                            <!-- Vista mediana (10 caracteres) -->
                            <span class="d-none d-md-inline d-xl-none">{{ Str::limit($file->name, 10) }}</span>
                            <!-- Vista pequeña (5 caracteres) -->
                            <span class="d-inline d-md-none">{{ Str::limit($file->name, 5) }}</span>
                        </h6>
                        <span class="badge bg-{{ $file->category_color ?? 'secondary' }} bg-opacity-25 text-dark fs-7">
                            {{ strtoupper($file->format) }}
                        </span>
                    </div>
                </div>

                <!-- Cuerpo de la tarjeta -->
                <div class="card-body p-3 rounded-bottom">
                    <!-- Descripción -->
                    <p class="card-text text-muted small mb-3">
                        {{ $file->description ?? 'Sin descripción' }}
                    </p>

                    <!-- Detalles del archivo -->
                    <div class="file-details small text-muted">
                        <div class="mb-2 d-flex align-items-center">
                            <i class="fas fa-folder me-2 text-warning"></i>
                            <span>{{ $file->category ?? 'Sin categoría' }}</span>
                        </div>
                        <div class="mb-2 d-flex align-items-center">
                            <i class="fas fa-weight-hanging me-2 text-info"></i>
                            <span>{{ \App\Helpers\Helpers::formatSizeUnits($file->size) }}</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-calendar-alt me-2 text-success"></i>
                            <span>{{ $file->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <div class="empty-state">
                <i class="fas fa-file-export fa-3x text-muted mb-3"></i>
                <h5 class="text-muted mb-2">No hay archivos disponibles</h5>
                <small class="text-muted">Sube tu primer archivo para comenzar</small>
            </div>
        </div>
    @endforelse
</div>

<style>
    .file-card {
        border-radius: 15px !important; /* Esquinas redondeadas */
        overflow: hidden; /* Asegura que el contenido respete el radio */
        transition: all 0.3s ease; /* Transición suave */
    }

    .file-card:hover {
        transform: translateY(-5px); /* Efecto de elevación */
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12); /* Sombra más pronunciada */
    }

    .card-header {
        border-top-left-radius: inherit !important; /* Hereda el radio del contenedor */
        border-top-right-radius: inherit !important;
        border: none; /* Elimina bordes por defecto */
    }

    .card-body {
        border-bottom-left-radius: inherit !important; /* Hereda el radio del contenedor */
        border-bottom-right-radius: inherit !important;
    }

    .file-details i {
        width: 16px;
        text-align: center;
    }

    .empty-state {
        opacity: 0.7;
        transition: opacity 0.3s ease;
    }

    .empty-state:hover {
        opacity: 1;
    }

    .card-title {
        font-size: 1rem;
    }

    .card-text {
        font-size: 0.875rem;
    }

    .badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }
</style>