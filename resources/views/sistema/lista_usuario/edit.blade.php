<x-sistema.modal title="Editar Usuario" dialog_id="dialog">
    <div class="form-group">
        <label for="name" class="form-control-label">Nombre:</label>
        <input class="form-control" type="text" value="{{ $user->name }}" id="name" name="name">
    </div>
    <div class="form-group">
        <label for="name" class="form-control-label">DNI:</label>
        <input class="form-control" type="text" value="{{ $user->identity_document }}" id="identity_document" name="identity_document">
    </div>
    <div class="form-group">
        <label for="email" class="form-control-label">Correo:</label>
        <input class="form-control" type="email" value="{{ $user->email }}" id="email" name="email">
    </div>
    <div class="form-group">
        <label for="password" class="form-control-label">Nueva Contraseña</label>
        <input class="form-control" type="password" value="" id="password" name="password" placeholder="******">
    </div>
    <div class="form-group">
        <label for="sede_id">Sedes:</label>
        <select class="form-control" id="sede_id" name="sede_id">
            @foreach ($sedes as $item)
                <option value="{{ $item->id }}" @if ($item->id == $user->sede_id) selected @endif>{{ $item->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="flex justify-end">
        <button type="button" class="btn bg-gradient-primary m-0" onclick="updateUsuario({{ $user->id }})">Actualizar</button>
    </div>
</x-sistema.modal>
<script>
    function updateUsuario(user_id) {
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
            url: `{{ url('lista_usuario/${user_id}') }}`,
            method: "PUT",
            data: {
                view: 'update',
                name: $('#name').val(),
                identity_document: $('#identity_document').val(),
                email: $('#email').val(),
                password: $('#password').val(),
                sede_id: $('#sede_id').val(),
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