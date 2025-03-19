<x-sistema.modal style="width: 500px;" title="Editar Etapa" dialog_id="dialog">
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
    <div class="form-group">
        <x-ui.label for="orden">{{ __('Orden *') }}</x-ui.label>
        <x-ui.input type="number" step="1" min="0" value="{{ $etapa->orden }}" id="orden" name="orden" />
    </div>
    <div class="form-group">
        <x-ui.label for="estado">{{ __('Estado *') }}</x-ui.label>
        <select class="form-control uppercase" name="estado" id="estado">
            <option value="1" @if ($etapa->estado == 1) selected @endif>Activo</option>
            <option value="0" @if ($etapa->estado == 0) selected @endif>Inactivo</option>
        </select>
    </div>
    <div class="flex justify-end w-full">
        <x-ui.button type="submit" onclick="submitEtapa(this, {{ $etapa->id }})">{{ __('Guardar') }}</x-ui.button>
    </div>
</x-sistema.modal>
<script>
    function submitEtapa(button, etapa_id) {
        limpiarError();
        capturarToken();

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
                orden: $('#orden').val(),
                estado: $('#estado').val(),
            },
            beforeSend: function() {
                button.disabled = true;
            },
            success: function(response) {
                if (response.redirect) {
                    location.reload();
                } else {
                    alert('Posiblemente ya ha registrado el cliente, actualizar la página');
                }
            },
            error: function(response) {
                mostrarError(response)
                button.disabled = false;
            }
        });
    }
</script>
