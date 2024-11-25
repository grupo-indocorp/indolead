<x-sistema.modal class="" style="width: 500px;" title="Detalle">
    <div class="form-group">
        <label for="comentario_gestion" class="form-control-label">Comentario</label>
        <textarea class="form-control" rows="3" id="comentario_gestion" name="comentario_gestion" disabled>{{ $notificacion->comentario_gestion }}</textarea>
    </div>
    <div class="flex justify-end w-full">
        <x-ui.button type="submit" onclick="submiConfirmarGestion(this)">{{ __('Confirmar Gestión') }}</x-ui.button>
    </div>
</x-sistema.modal>
<script>
    function submiConfirmarGestion(button) {
        limpiarError();
        capturarToken();
        let notificacion_id = {{ $notificacion->id }}
        $.ajax({
            url: `evaporacion-gestion/${notificacion_id}`,
            method: "PUT",
            data: {
                view: 'update-confirmar',
            },
            beforeSend: function() {
                button.disabled = true;
            },
            success: function (response) {
                if (response.redirect) {
                    location.reload();
                } else {
                    alert('Posiblemente ya ha registrado el cliente, actualizar la página');
                }
            },
            error: function (response) {
                mostrarError(response)
                button.disabled = false;
            }
        });
    }
</script>