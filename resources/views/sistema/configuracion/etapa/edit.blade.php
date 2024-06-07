<x-sistema.modal title="Editar Etapa" dialog_id="dialog">
    <div class="form-group">
        <label for="name" class="form-control-label">Nombre:</label>
        <input class="form-control" type="text" value="{{ $etapa->nombre }}" id="nombre" name="nombre">
    </div>
    <div class="form-group">
        <label for="color" class="form-control-label">Color:</label>
        <input class="form-control" type="color" value="{{ $etapa->color }}" id="color" name="color">
    </div>
    <div class="form-group">
        <label for="blindaje" class="form-control-label">Blindaje (días):</label>
        <input class="form-control" type="number" step="1" min="0" value="{{ $etapa->blindaje }}" id="blindaje" name="blindaje">
    </div>
    <div class="form-group">
        <label for="avance" class="form-control-label">Avance (porcentaje):</label>
        <input class="form-control" type="number" step="1" min="0" value="{{ $etapa->avance }}" id="avance" name="avance">
    </div>
    <div class="form-group">
        <label for="probabilidad" class="form-control-label">Probabilidad:</label>
        <input class="form-control uppercase" type="text" value="{{ $etapa->probabilidad }}" id="probabilidad" name="probabilidad">
    </div>
    <div class="flex justify-end">
        <button type="button" class="btn bg-gradient-primary m-0" onclick="submitEtapa({{ $etapa->id }})">Guardar</button>
    </div>
</x-sistema.modal>
<script>
    function submitEtapa(etapa_id) {
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
            url: `{{ url('configuracion-etapa/${etapa_id}') }}`,
            method: "PUT",
            data: {
                view: 'update-etapa',
                nombre: $('#nombre').val(),
                color: $('#color').val(),
                blindaje: $('#blindaje').val(),
                avance: $('#avance').val(),
                probabilidad: $('#probabilidad').val(),
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
