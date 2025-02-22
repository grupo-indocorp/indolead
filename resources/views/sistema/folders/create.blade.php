<div class="modal fade" id="folderModal" tabindex="-1" aria-labelledby="folderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="folderModalLabel">Nueva Carpeta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="folderForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nombre de la carpeta</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Descripción</label>
                        <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#folderForm').submit(function(e) {
            e.preventDefault();
            
            $.ajax({
                url: "{{ route('folders.store') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    $('#folderModal').modal('hide');
                    // Actualizar el dropdown de carpetas
                    $.get("{{ route('files.create') }}", function(data) {
                        $('#folder_id').html(
                            $(data).find('#folder_id').html()
                        );
                    });
                },
                error: function(response) {
                    console.error('Error:', response);
                }
            });
        });
    });
</script>