<x-sistema.modal title="Registrar Equipo" dialog_id="dialog">
    <div class="form-group">
        <label for="nombre" class="form-control-label">Equipo:</label>
        <input class="form-control" type="text" name="nombre" id="nombre">
    </div>
    <div class="form-group">
        <label for="sede_id">Sede:</label>
        <select class="form-control" name="sede_id" id="sede_id">
            @foreach ($sedes as $item)
                <option value="{{ $item->id }}">{{ $item->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="user_id">Jefe:</label>
        <select class="form-control" name="user_id" id="user_id">
            @foreach ($users as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="flex justify-end">
        <button type="button" class="btn bg-gradient-primary m-0" onclick="submitEquipo()">Registrar</button>
    </div>
</x-sistema.modal>
<script>
    function submitEquipo() {
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
            url: `{{ url('equipo') }}`,
            method: "POST",
            data: {
                view: 'store',
                nombre: $('#nombre').val(),
                sede_id: $('#sede_id').val(),
                user_id: $('#user_id').val(),
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