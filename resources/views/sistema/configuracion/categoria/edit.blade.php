<x-sistema.modal title="Editar Categoría" dialog_id="dialog">
    <div class="form-group">
        <div class="row">
            <div class="col-12">
                <label for="name" class="form-control-label">Nombre:</label>
                <input class="form-control" type="text" value="{{ $categoria->nombre }}" id="nombre" name="nombre">
            </div>
            <div class="col-12">
                <label for="name" class="form-control-label">Estado:</label>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="estado" @checked($categoria->estado)>
                </div>
            </div>
        </div>
    </div>
    <div class="flex justify-end">
        <button type="button" class="btn bg-gradient-primary m-0" onclick="submitCategoria({{ $categoria->id }})">Guardar</button>
    </div>
</x-sistema.modal>
<script>
    function submitCategoria(categoria_id) {
        const dialog = document.querySelector("#dialog");
        dialog.querySelectorAll('.is-invalid, .invalid-feedback').forEach(element => {
            element.classList.contains('is-invalid') ? element.classList.remove('is-invalid') : element.remove();
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: `{{ url('configuracion-categoria/${categoria_id}') }}`,
            method: "PUT",
            data: {
                view: 'update-categoria',
                nombre: $('#nombre').val(),
                estado: $('#estado').is(":checked"),
            },
            success: function( result ) {
                location.reload();
                closeModal();
            },
            error: function( data ) {
                let errors = data.responseJSON;
                if(errors) {
                    $.each(errors.errors, function(key, value){
                        $('#dialog #'+key).addClass('is-invalid');
                        $('#dialog #'+key).after('<span class="invalid-feedback" role="alert"><strong>'+ value +'</strong></span>');
                    });
                }
            }
        });
    }
</script>
