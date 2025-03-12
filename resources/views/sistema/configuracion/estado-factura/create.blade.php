<x-sistema.modal class="" style="width: 500px;" title="Registrar">
    <div class="form-group">
        <label for="name" class="form-control-label">Nombre</label>
        <input class="form-control" type="text" value="" id="name" name="name">
    </div>
    <div class="flex justify-end">
        <x-ui.button type="submit" onclick="submit(this)">{{ __('Guardar') }}</x-ui.button>
    </div>
</x-sistema.modal>
<script>
    function submit(button) {
        limpiarError();
        capturarToken();
        $.ajax({
            url: `{{ url('configuracion-estado-factura') }}`,
            method: "POST",
            data: {
                view: 'store',
                name: $('#name').val(),
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
