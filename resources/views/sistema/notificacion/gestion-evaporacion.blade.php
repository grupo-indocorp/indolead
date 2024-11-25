<x-sistema.modal class="" style="width: 500px;" title="Gestionar Evaporación">
    <div class="form-group">
        <label for="comentario_gestion" class="form-control-label">Comentario</label>
        <textarea class="form-control" rows="3" id="comentario_gestion" name="comentario_gestion"></textarea>
    </div>
    <div class="flex justify-end w-full">
        <x-ui.button type="submit" onclick="submiGestionEvaporacion(this)">{{ __('Agregar') }}</x-ui.button>
    </div>
</x-sistema.modal>
<script>
    function submiGestionEvaporacion(button) {
        limpiarError();
        capturarToken();
        let notificacion_id = {{ $notificacion->id }}
        $.ajax({
            url: `notificacion/${notificacion_id}`,
            method: "PUT",
            data: {
                view: 'update-gestion-evaporacion',
                comentario_gestion: $('#comentario_gestion').val(),
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