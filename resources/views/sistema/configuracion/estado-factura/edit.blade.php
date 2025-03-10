<x-sistema.modal class="" style="width: 500px;" title="Editar">
    <div class="form-group">
        <label for="name" class="form-control-label">Nombre:</label>
        <input class="form-control" type="text" value="{{ $estadofactura->name }}" id="name" name="name">
    </div>
    <div class="form-group">
        <x-ui.label for="status">{{ __('Estado *') }}</x-ui.label>
        <select class="form-control uppercase" name="status" id="status" onchange="selectRole()">
            <option value="1" @if (true == $estadofactura->status) selected @endif>ACTIVO</option>
            <option value="0" @if (false == $estadofactura->status) selected @endif>INACTIVO</option>
        </select>
    </div>
    <div class="flex justify-end">
        <x-ui.button type="submit" onclick="submit(this, {{ $estadofactura->id }})">{{ __('Guardar') }}</x-ui.button>
    </div>
</x-sistema.modal>
<script>
    function submit(button, id) {
        limpiarError();
        capturarToken();
        $.ajax({
            url: `{{ url('configuracion-estado-factura/${id}') }}`,
            method: "PUT",
            data: {
                view: 'update',
                name: $('#name').val(),
                status: $('#status').val(),
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
