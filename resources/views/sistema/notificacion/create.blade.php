<x-sistema.modal title="Registrar Notificación" dialog_id="dialog">
    <div class="form-group">
        <label for="notificaciontipo_id" class="form-control-label">Tipo de Notificación</label>
        <select class="form-control" id="notificaciontipo_id" name="notificaciontipo_id" disabled>
            @foreach ($tipos as $tipo)
                <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="asunto" class="form-control-label">Asunto</label>
        <input class="form-control" type="text" value="" id="asunto" name="asunto">
    </div>
    <div class="form-group">
        <label for="mensaje" class="form-control-label">Mensaje</label>
        <textarea class="form-control" rows="3" id="mensaje" name="mensaje"></textarea>
    </div>
    <div class="form-group">
        <label for="fecha" class="form-control-label">Fecha y Hora</label>
        <div class="row">
            <div class="col">
                <input class="form-control" type="date" value="{{ $fecha }}" id="fecha" name="fecha">
            </div>
            <div class="col">
                <input class="form-control" type="time" value="" id="hora" name="hora">
            </div>
        </div>
    </div>
    <div class="flex justify-end">
        <button type="button" class="btn bg-gradient-primary m-0" onclick="submitNotificacion()">Agregar</button>
    </div>
</x-sistema.modal>
<script>
    function submitNotificacion() {
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
            url: `notificacion`,
            method: "POST",
            data: {
                view: 'store',
                notificaciontipo_id: $('#notificaciontipo_id').val(),
                asunto: $('#asunto').val(),
                mensaje: $('#mensaje').val(),
                fecha: $('#fecha').val(),
                hora: $('#hora').val(),
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