<x-sistema.modal title="Editar Producto" dialog_id="dialog">
    <div class="form-group">
        <label for="categoria_id" class="form-control-label">Categoría:</label>
        <select class="form-control" name="categoria_id" id="categoria_id" onchange="filtroAutomatico()">
            <option></option>
            @foreach ($categorias as $item)
                <option value="{{ $item->id }}" @if ($item->id == $producto->categoria_id) selected @endif>{{ $item->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="name" class="form-control-label">Nombre:</label>
        <input class="form-control" type="text" value="{{ $producto->nombre }}" id="nombre" name="nombre">
    </div>
    <div class="flex justify-end">
        <button type="button" class="btn bg-gradient-primary m-0" onclick="submitProducto({{ $producto->id }})">Guardar</button>
    </div>
</x-sistema.modal>
<script>
    function submitProducto(producto_id) {
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
            url: `{{ url('configuracion-producto/${producto_id}') }}`,
            method: "PUT",
            data: {
                view: 'update-producto',
                nombre: $('#nombre').val(),
                categoria_id: $('#categoria_id').val(),
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
