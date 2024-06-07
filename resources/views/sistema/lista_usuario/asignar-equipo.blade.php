<x-sistema.modal title="Asignar Equipo" dialog_id="dialog">
    <div class="form-group">
        <div class="row">
            <div class="col-2">
                <label for="name" class="form-control-label">Nombre</label>
            </div>
            <div class="col-10">
                <input class="form-control" type="text" value="{{ $user->name }}" id="name" name="name" disabled>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-2">
                <label for="equipo_id" class="form-control-label">Equipo</label>
            </div>
            <div class="col-10">
                <select class="form-control" id="equipo_id">
                    <option></option>
                    @foreach ($equipos as $equipo)
                        <option value="{{ $equipo->id }}">{{ $equipo->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="flex justify-end">
        <button type="button" class="btn bg-gradient-primary m-0" onclick="submitAsignar({{ $user->id }})">Asignar</button>
    </div>
</x-sistema.modal>
<script>
    function submitAsignar(user_id) {
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
                view: 'update-asignar-equipo',
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
</script>