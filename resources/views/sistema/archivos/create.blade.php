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
                    <div class="form-group">
                        <label for="file">Seleccione un archivo</label>
                        <input type="file" name="file" id="file" class="form-control" required
                            onchange="rellenarDescripcion(this)">
                    </div>
                    <div class="form-group">
                        <label for="description">Descripción</label>
                        <input type="text" name="description" id="description" class="form-control"
                            placeholder="Descripción del archivo">
                    </div>
                    <div class="form-group">
                        <label for="category">Categoría</label>
                        <input type="text" name="category" id="category" class="form-control"
                            placeholder="Categoría del archivo">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Subir</button>
                </div>
             </form>
        </div>
    </div>
</div>
