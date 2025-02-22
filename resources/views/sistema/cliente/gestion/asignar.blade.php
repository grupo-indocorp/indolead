<x-sistema.modal title="Asignar Clientes" dialog_id="dialog">
    <div class="form-group"  @role('supervisor') style="display: none;" @endrole>
        <label for="equipo_id" class="form-control-label">Equipo</label>
        <select class="form-control" id="equipo_id" name="equipo_id">
            <option></option>
            @foreach ($equipos as $value)
                <option value="{{ $value->id }}">{{ $value->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="user_id" class="form-control-label">Ejecutivo</label>
        <select class="form-control" id="user_id" name="user_id">
            <option></option>
            @foreach ($ejecutivos as $value)
                <option value="{{ $value->id }}">{{ $value->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="etapa_id" class="form-control-label">Etapa</label>
        <select class="form-control" id="etapa_id" name="etapa_id">
            @foreach ($etapas as $value)
                <option value="{{ $value->id }}">{{ $value->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="flex justify-end">
        <button type="button" class="btn bg-gradient-primary m-0" onclick="submitAsignar()">Asignar</button>
    </div>
</x-sistema.modal>
<script>
    function submitAsignar() {
        const dialog = document.querySelector("#dialog");
        dialog.querySelectorAll('.is-invalid, .invalid-feedback').forEach(element => {
            element.classList.contains('is-invalid') ? element.classList.remove('is-invalid') : element.remove();
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        let clients = @json($clients);
        $.ajax({
            url: `{{ url('cliente-gestion/0') }}`,
            method: "PUT",
            data: {
                view: 'update-asignar',
                user_id: $('#user_id').val(),
                etapa_id: $('#etapa_id').val(),
                clients: clients,
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
    $('#equipo_id').on("change", function() {
        if ($(this).val()) {
            $.ajax({
                url: `{{ url('cliente-gestion/${$(this).val()}') }}`,
                method: "GET",
                data: {
                    view: 'show-select-equipo',
                },
                success: function(data) {
                    let opt_user = '<option></option>';
                    data.users.map(function (item) {
                        opt_user += `<option value="${item.id}">${item.name}</option>`;
                    })
                    $('#user_id').html(opt_user);
                },
                error: function( response ) {
                    console.log('error');
                }
            });
        }
    });
</script>
