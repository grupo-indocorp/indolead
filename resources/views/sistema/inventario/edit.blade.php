<x-sistema.modal class="" style="width: 600px;" title="Editar Inventario">
    <form id="form-editar-inventario">
        <section class="flex gap-2">
            <article class="w-1/2">
                <div class="form-group">
                    <x-ui.label for="codigo">{{ __('Código *') }}</x-ui.label>
                    <x-ui.input type="number" id="codigo" name="codigo" value="{{ $inventario->codigo }}" />
                </div>
                <div class="form-group">
                    <x-ui.label for="categoria">{{ __('Categoría *') }}</x-ui.label>
                    <x-ui.input type="text" id="categoria" name="categoria" value="{{ $inventario->categoria }}" />
                </div>
                <div class="form-group">
                    <x-ui.label for="marca">{{ __('Marca *') }}</x-ui.label>
                    <x-ui.input type="text" id="marca" name="marca" value="{{ $inventario->marca }}" />
                </div>
                <div class="form-group">
                    <x-ui.label for="serie">{{ __('Serie *') }}</x-ui.label>
                    <x-ui.input type="text" id="serie" name="serie" value="{{ $inventario->serie }}" />
                </div>
            </article>
            <article class="w-1/2">
                <div class="form-group">
                    <x-ui.label for="modelo">{{ __('Modelo *') }}</x-ui.label>
                    <x-ui.input type="text" id="modelo" name="modelo" value="{{ $inventario->modelo }}" />
                </div>
                <div class="form-group">
                    <x-ui.label for="estado">{{ __('Estado *') }}</x-ui.label>
                    <select class="form-control" name="estado" id="estado">
                        <option value="activo" {{ $inventario->estado == 'activo' ? 'selected' : '' }}>Activo</option>
                        <option value="inactivo" {{ $inventario->estado == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>
                <div class="form-group">
                    <x-ui.label for="procesador">{{ __('Procesador *') }}</x-ui.label>
                    <x-ui.input type="text" id="procesador" name="procesador" value="{{ $inventario->procesador }}" />
                </div>
                <div class="form-group">
                    <x-ui.label for="ram">{{ __('RAM *') }}</x-ui.label>
                    <x-ui.input type="text" id="ram" name="ram" value="{{ $inventario->ram }}" />
                </div>
            </article>
            <article>
                <div class="form-group">
                    <x-ui.label for="num_ram">{{ __('Número de RAM *') }}</x-ui.label>
                    <x-ui.input type="number" id="num_ram" name="num_ram" value="{{ $inventario->num_ram }}" />
                </div>
                <div class="form-group">
                    <x-ui.label for="disco_duro">{{ __('Disco Duro *') }}</x-ui.label>
                    <x-ui.input type="text" id="disco_duro" name="disco_duro" value="{{ $inventario->disco_duro }}" />
                </div>
                <div class="form-group">
                    <x-ui.label for="pantalla">{{ __('Pantalla *') }}</x-ui.label>
                    <x-ui.input type="text" id="pantalla" name="pantalla" value="{{ $inventario->pantalla }}" />
                </div>
                <div class="form-group">
                    <x-ui.label for="color">{{ __('Color *') }}</x-ui.label>
                    <x-ui.input type="text" id="color" name="color" value="{{ $inventario->color }}" />
                </div>
                <div class="form-group">
                    <x-ui.label for="descripcion">{{ __('Descripción') }}</x-ui.label>
                    <x-ui.input type="text" id="descripcion" name="descripcion" value="{{ $inventario->descripcion }}" />
                </div>
            </article>
        </section>

        <div class="flex justify-end w-full">
            <x-ui.button type="button" onclick="updateInventario({{ $inventario->id }})">{{ __('Guardar Cambios') }}</x-ui.button>
        </div>
    </form>
</x-sistema.modal>

<script>
    function updateInventario(inventario_id) {
        $.ajax({
            url: `{{ url('inventario/${inventario_id}') }}`,
            method: "PUT",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
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
            success: function(response) {
                if (response.success) {
                    location.reload();
                    closeModal();  
                } else {
                    alert(response.message);  
                }
            },
            error: function(response) {
                alert("Error al actualizar el inventario. Inténtelo nuevamente.");
            }
        });
    }
</script>
