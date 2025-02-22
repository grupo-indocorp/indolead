<div class="modal fade" id="editFileModal" tabindex="-1" aria-labelledby="editFileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editFileModalLabel">Editar Archivo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editFileForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <!-- Selector de carpeta -->
                    <div class="form-group mb-4">
                        <label for="folder_id">Carpeta</label>
                        <select name="folder_id" id="folder_id" class="form-control">
                            <option value="">Sin carpeta</option>
                            @foreach($folders as $folder)
                                <option value="{{ $folder->id }}" {{ $file->folder_id == $folder->id ? 'selected' : '' }}>
                                    {{ $folder->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre del Archivo</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $file->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Descripción</label>
                        <textarea class="form-control" id="description" name="description">{{ $file->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Categoría</label>
                        <input type="text" class="form-control" id="category" name="category" value="{{ $file->category }}">
                    </div>
                    <div class="mb-3">
                        <label for="new_file" class="form-label">Reemplazar Archivo (opcional)</label>
                        <input type="file" class="form-control" id="new_file" name="new_file">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>