<x-sistema.modal class="" style="width: 500px;" title="Agregar Usuario">
    <section class="flex gap-2">
        <article class="w-1/2">
            <div class="form-group">
                <x-ui.label for="first_name">{{ __('Primer Nombre *') }}</x-ui.label>
                <x-ui.input type="text" id="first_name" name="first_name" />
            </div>
            <div class="form-group">
                <x-ui.label for="second_name">{{ __('Segundo Nombre') }}</x-ui.label>
                <x-ui.input type="text" id="second_name" name="second_name" />
            </div>
            <div class="form-group">
                <x-ui.label for="first_surname">{{ __('Apellido Paterno *') }}</x-ui.label>
                <x-ui.input type="text" id="first_surname" name="first_surname" />
            </div>
            <div class="form-group">
                <x-ui.label for="second_surname">{{ __('Apellido Materno') }}</x-ui.label>
                <x-ui.input type="text" id="second_surname" name="second_surname" />
            </div>
            <div class="form-group">
                <x-ui.label for="personal_phone">{{ __('Celular Personal') }}</x-ui.label>
                <x-ui.input type="text" id="personal_phone" name="personal_phone" />
            </div>
            <div class="form-group">
                <x-ui.label for="personal_email">{{ __('Correo Personal *') }}</x-ui.label>
                <x-ui.input type="email" id="personal_email" name="personal_email" />
            </div>
        </article>
        <article class="w-1/2">
            <div class="form-group">
                <x-ui.label for="tipodocumento_id">{{ __('Tipo de Documento *') }}</x-ui.label>
                <select class="form-control uppercase" name="tipodocumento_id" id="tipodocumento_id">
                    @foreach ($tipodocumentos as $item)
                        <option value="{{ $item->id }}">{{ $item->abbreviation }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <x-ui.label for="identity_document">{{ __('Nro. Identificación *') }}</x-ui.label>
                <x-ui.input type="text" id="identity_document" name="identity_document" />
            </div>
            <div class="form-group">
                <x-ui.label for="sede_id">{{ __('Sede *') }}</x-ui.label>
                <select class="form-control uppercase" name="sede_id" id="sede_id">
                    @foreach ($sedes as $item)
                        <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <x-ui.label for="role_id">{{ __('Rol *') }}</x-ui.label>
                <select class="form-control uppercase" name="role_id" id="role_id" onchange="selectRole()">
                    <option></option>
                    @foreach ($roles as $item)
                        <option value="{{ $item->id }}" role="{{ $item->name }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" id="cont_equipo_id" style="display: none">
                <x-ui.label for="equipo_id">{{ __('Equipo *') }}</x-ui.label>
                <select class="form-control uppercase" name="equipo_id" id="equipo_id">
                    <option></option>
                    @foreach ($equipos as $item)
                        <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </article>
    </section>
    <div class="flex justify-end w-full">
        <span id="jsonerror" class="text-red-400 w-full"></span>
        <x-ui.button type="submit" onclick="submitUsuario(this)">{{ __('Agregar') }}</x-ui.button>
    </div>
</x-sistema.modal>
<script>
    function submitUsuario(button) {
        limpiarError();
        capturarToken();

        $('#jsonerror').text('');
        $.ajax({
            url: `{{ url('lista_usuario') }}`,
            method: "POST",
            data: {
                view: 'store',
                first_name: $('#first_name').val(),
                second_name: $('#second_name').val(),
                first_surname: $('#first_surname').val(),
                second_surname: $('#second_surname').val(),
                personal_phone: $('#personal_phone').val(),
                personal_email: $('#personal_email').val(),
                tipodocumento_id: $('#tipodocumento_id').val(),
                identity_document: $('#identity_document').val(),
                sede_id: $('#sede_id').val(),
                role_id: $('#role_id').val(),
                roleNombre: $("#role_id option:selected").attr("role"),
                equipo_id: $('#equipo_id').val(),
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
                if (response.responseJSON.error) {
                    $('#jsonerror').text(response.responseJSON.error);
                }
                mostrarError(response)
                button.disabled = false;
            }
        });
    }
    // Mostrar Equipo si es Ejecutivo
    function selectRole() {
        var role = document.getElementById('role_id');
        var roleNombre = $("#role_id option:selected").attr("role");
        var cont_equipo = document.getElementById('cont_equipo_id');
        if (roleNombre === 'ejecutivo') {
            cont_equipo.style.display = "block";
        } else {
            cont_equipo.style.display = "none";
        }
    }

</script>