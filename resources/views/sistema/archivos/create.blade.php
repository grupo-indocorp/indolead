<div class="modal fade" id="uploadFileModal" tabindex="-1" aria-labelledby="uploadFileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadFileModalLabel">Subir Archivo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('files.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <!-- Campo para seleccionar carpeta -->
                    <div class="form-group mb-4">
                        <label for="folder_id" class="form-label">Carpeta Destino</label>
                        <select name="folder_id" id="folder_id" class="form-select">
                            <option value="">Sin carpeta (General)</option>
                            @foreach($folders as $folder)
                                <option value="{{ $folder->id }}">{{ $folder->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Campos existentes -->
                    <div class="form-group mb-4">
                        <label for="file">Archivo</label>
                        <input type="file" name="file" id="file" class="form-control" required 
                            onchange="rellenarDescripcion(this)">
                    </div>
                    
                    <div class="form-group mb-4">
                        <label for="description">Descripción</label>
                        <input type="text" name="description" id="description" class="form-control" 
                            placeholder="Ej: Documento de procedimientos 2024">
                    </div>
                    
                    <div class="form-group">
                        <label for="category">Categoría</label>
                        <input type="text" name="category" id="category" class="form-control"
                            placeholder="Ej: Manuales, Formatos Legales">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Subir Archivo</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function crearNuevaCarpeta() {
        // Código para abrir modal de creación de carpetas
        alert('Implementar lógica para crear nueva carpeta');
    }
</script>