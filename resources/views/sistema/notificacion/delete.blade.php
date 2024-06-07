<x-sistema.modal title="Eliminar Notificación" dialog_id="dialog">
    <div class="form-group">
        <label for="asunto" class="form-control-label">Asunto</label>
        <input class="form-control" type="text" value="{{ $notificacion->asunto }}" id="asunto" name="asunto" disabled>
    </div>
    <div class="flex justify-end">
        <button type="button" class="btn bg-gradient-primary m-0" onclick="updateNotificacion({{ $notificacion->id }})">Eliminar</button>
    </div>
</x-sistema.modal>
<script>
    function updateNotificacion(notificacion_id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: `notificacion/${notificacion_id}`,
            method: "DELETE",
            data: {
                view: 'destroy',
            },
            success: function( result ) {
                location.reload();
                closeModal();
            }
        });
    }
</script>