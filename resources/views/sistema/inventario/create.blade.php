<x-sistema.modal class="" style="width: 600px;" title="Agregar Inventario">
    <section class="flex gap-2">
        <article class="w-1/2">
            <div class="form-group">
                <x-ui.label for="codigo">{{ __('Código *') }}</x-ui.label>
                <x-ui.input type="number" id="codigo" name="codigo" />
            </div>
            <div class="form-group">
                <x-ui.label for="categoria">{{ __('Categoría *') }}</x-ui.label>
                <x-ui.input type="text" id="categoria" name="categoria" />
            </div>
            <div class="form-group">
                <x-ui.label for="marca">{{ __('Marca *') }}</x-ui.label>
                <x-ui.input type="text" id="marca" name="marca" />
            </div>
            <div class="form-group">
                <x-ui.label for="serie">{{ __('Serie *') }}</x-ui.label>
                <x-ui.input type="text" id="serie" name="serie" required />
            </div>
        </article>
        <article class="w-1/2">
            <div class="form-group">
                <x-ui.label for="modelo">{{ __('Modelo *') }}</x-ui.label>
                <x-ui.input type="text" id="modelo" name="modelo" />
            </div>
            <div class="form-group">
                <x-ui.label for="estado">{{ __('Estado *') }}</x-ui.label>
                <select class="form-control" name="estado" id="estado">
                    <option value="activo">Activo</option>
                    <option value="inactivo">Inactivo</option>
                </select>
            </div>
            <div class="form-group">
                <x-ui.label for="procesador">{{ __('Procesador *') }}</x-ui.label>
                <x-ui.input type="text" id="procesador" name="procesador" />
            </div>
            <div class="form-group">
                <x-ui.label for="ram">{{ __('RAM *') }}</x-ui.label>
                <x-ui.input type="text" id="ram" name="ram" />
            </div>
            <div class="form-group">
                <x-ui.label for="num_ram">{{ __('Número de RAM *') }}</x-ui.label>
                <x-ui.input type="number" id="num_ram" name="num_ram" />
            </div>
        </article>
        <article>
            <div class="form-group">
                <x-ui.label for="disco_duro">{{ __('Disco Duro *') }}</x-ui.label>
                <x-ui.input type="text" id="disco_duro" name="disco_duro" />
            </div>
            <div class="form-group">
                <x-ui.label for="pantalla">{{ __('Pantalla *') }}</x-ui.label>
                <x-ui.input type="text" id="pantalla" name="pantalla" />
            </div>
            <div class="form-group">
                <x-ui.label for="color">{{ __('Color *') }}</x-ui.label>
                <x-ui.input type="text" id="color" name="color" />
            </div>
            <div class="form-group">
                <x-ui.label for="descripcion">{{ __('Descripción') }}</x-ui.label>
                <x-ui.input type="text" id="descripcion" name="descripcion" />
            </div>
        </article>
    </section>

    <div class="flex justify-end w-full">
        <x-ui.button type="button" onclick="submitInventario(this)">{{ __('Agregar') }}</x-ui.button>
    </div>
</x-sistema.modal>

<script>
    function submitInventario(button) {
        limpiarError();  // Limpiar errores previos (si los hay)
        capturarToken(); // Capturar el token CSRF si es necesario

        $.ajax({
            url: `{{ url('inventario') }}`,  // Asegúrate de que esta URL sea correcta
            method: "POST",
            data: {
                codigo: $('#codigo').val(),
                categoria: $('#categoria').val(),
                marca: $('#marca').val(),
                serie: $('#serie').val(),
                modelo: $('#modelo').val(),
                estado: $('#estado').val(),
                procesador: $('#procesador').val(),
                ram: $('#ram').val(),
                num_ram: $('#num_ram').val(),
                disco_duro: $('#disco_duro').val(),
                pantalla: $('#pantalla').val(),
                color: $('#color').val(),
                descripcion: $('#descripcion').val(),
            },
            beforeSend: function() {
                button.disabled = true;  
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert(response.message); 
                }
            },
            error: function(response) {
                button.disabled = false;
                mostrarError(response);  
            }
        });
    }
</script>

