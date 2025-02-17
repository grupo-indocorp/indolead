<x-sistema.modal class="w-auto max-w-md" title="Agregar Rol">
    {{-- Nombre del rol --}}
    <div class="form-group">
        <x-ui.label for="name">{{ __('Rol') }}</x-ui.label>
        <x-ui.input type="text" id="name" name="name" />
    </div>
    <div class="flex justify-end">
        <x-ui.button type="submit" onclick="submitPost(this)">{{ __('Agregar') }}</x-ui.button>
    </div>
</x-sistema.modal>
<script>
    function submitPost(button) {
        limpiarError();
        capturarToken();
        $.ajax({
            url: `{{ url('role') }}`,
            method: "POST",
            data: {
                name: $('#name').val()
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
