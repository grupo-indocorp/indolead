<x-sistema.modal title="Agregar Usuario" dialog_id="dialog">
    <div class="form-group">
        <label for="name" class="form-control-label">Nombre:</label>
        <input class="form-control" type="text" id="name" name="name">
    </div>
    <div class="form-group">
        <label for="email" class="form-control-label">Correo:</label>
        <input class="form-control" type="text" id="email" name="email">
    </div>
    <div class="form-group">
        <label for="password" class="form-control-label">Contraseña:</label>
        <input class="form-control" type="password" id="password" name="password">
    </div>
    <div class="form-group">
        <label for="sede_id" class="form-control-label">Sede:</label>
        <select class="form-control uppercase" name="sede_id" id="sede_id">
            <option></option>
            @foreach ($sedes as $item)
                <option value="{{ $item->id }}">{{ $item->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="role_id" class="form-control-label">Rol:</label>
        <select class="form-control uppercase" name="role_id" id="role_id" onchange="selectRole()">
            <option></option>
            @foreach ($roles as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group" id="cont_equipo_id" style="display: none">
        <label for="equipo_id" class="form-control-label">Equipo:</label>
        <select class="form-control uppercase" name="equipo_id" id="equipo_id">
            <option></option>
            @foreach ($equipos as $item)
                <option value="{{ $item->id }}">{{ $item->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="flex justify-end">
        <button type="button" class="btn bg-gradient-primary m-0" onclick="submitUsuario()">Agregar</button>
    </div>
</x-sistema.modal>
<script>
    function submitUsuario() {
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
            url: `{{ url('lista_usuario') }}`,
            method: "POST",
            data: {
                view: 'store',
                name: $('#name').val(),
                email: $('#email').val(),
                password: $('#password').val(),
                sede_id: $('#sede_id').val(),
                role_id: $('#role_id').val(),
                equipo_id: $('#equipo_id').val(),
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
    function selectRole() {
        // Mostrar Equipo si es Ejecutivo
        var role = document.getElementById('role_id');
        var cont_equipo = document.getElementById('cont_equipo_id');
        if (role.value === '4') {
            cont_equipo.style.display = "block";
        } else {
            cont_equipo.style.display = "none";
        }
    }

</script>