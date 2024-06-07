<x-sistema.modal title="Editar Equipo" dialog_id="dialog">
    <div class="form-group">
        <label for="nombre" class="form-control-label">Equipo:</label>
        <input class="form-control" type="text" value="{{ $equipo->nombre }}" id="nombre" name="nombre" >
    </div>
    <div class="form-group">
        <label for="sede_id">Sede:</label>
        <select class="form-control" id="sede_id" name="sede_id" >
            @foreach ($sedes as $item)
                <option value="{{ $item->id }}">{{ $item->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="user_id">Jefe:</label>
        <select class="form-control" id="user_id" name="user_id" >
            @foreach ($users as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="flex justify-end">
        <button type="button" class="btn bg-gradient-primary m-0" onclick="submitEquipo({{ $equipo->id }})">Actualizar</button>
    </div>
</x-sistema.modal>
<script>
    function submitEquipo(equipo_id) {
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
            url: `equipo/${equipo_id}`,
            method: "PUT",
            data: {
                view: 'update',
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
    selectSede({{ $equipo->sede_id }});
    function selectSede(sede_id) {
        $(`#sede_id option[value='${sede_id}']`).attr('selected', 'selected');
    }
    selectSupervisor({{ $equipo->user_id }});
    function selectSupervisor(user_id) {
        $(`#user_id option[value='${user_id}']`).attr('selected', 'selected');
    }
</script>
