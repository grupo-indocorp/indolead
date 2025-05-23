<x-sistema.modal title="Editar Notificación" dialog_id="dialog">
    <div class="form-group">
        <label for="asunto" class="form-control-label">Asunto</label>
        <input class="form-control" type="text" value="{{ $notificacion->asunto }}" id="asunto" name="asunto">
    </div>
    <div class="form-group">
        <label for="mensaje" class="form-control-label">Mensaje</label>
        <textarea class="form-control" rows="3" id="mensaje" name="mensaje">{{ $notificacion->mensaje }}</textarea>
    </div>
    <div class="form-group">
        <label for="fecha" class="form-control-label">Fecha y Hora</label>
        <div class="row">
            <div class="col">
                <input class="form-control" type="date" value="{{ $notificacion->fecha }}" id="fecha" name="fecha">
            </div>
            <div class="col">
                <input class="form-control" type="time" value="{{ $notificacion->hora }}" id="hora" name="hora">
            </div>
        </div>
    </div>
    <div class="form-group">
        @role(['ejecutivo'])
            <div class="form-check form-switch">
                <label class="form-check-label" for="atendido">Atendido</label>
                <input class="form-check-input" type="checkbox" id="atendido" @if($notificacion->atendido ?? false) checked @endif>
            </div>
        @endrole
    </div>
    <div class="flex justify-end">
        <button type="button" class="btn bg-gradient-primary m-0" onclick="updateNotificacion({{ $notificacion->id }})">Actualizar</button>
    </div>
</x-sistema.modal>
<script> 
    function updateNotificacion(notificacion_id) {
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
            url: `notificacion/${notificacion_id}`,
            method: "PUT",
            data: {
                view: 'update',
                asunto: $('#asunto').val(),
                mensaje: $('#mensaje').val(),
                fecha: $('#fecha').val(),
                hora: $('#hora').val(),
                atendido: $('#atendido').is(':checked'),
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