<x-sistema.modal title="Lista de Ejecutivos" dialog_id="dialog">
    <div class="form-group">
        <label for="nombre" class="form-control-label">Equipo</label>
        <input class="form-control" type="text" value="{{ $equipo->nombre }}" id="nombre" name="nombre" disabled>
    </div>
    <x-sistema.tabla-contenedor>
        <table class="table align-items-center mb-0" id="gestion_cliente">
            <thead>
                <tr>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ejecutivos</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Cambiar Equipo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($equipo->users as $value)
                    @if ($value->equipos()->orderByDesc('pivot_id')->first()->id == $equipo->id)
                        <tr id="{{ $value->id }}">
                            <td class="align-middle text-center">
                                <h6 class="mb-0 text-xs">{{ $value->name }}</h6>
                            </td>
                            <td class="align-middle text-center">
                                <span class="" data-bs-toggle="tooltip" data-bs-original-title="Cambiar Equipo">
                                    <a href="javascript:;" class="cursor-pointer" onclick="previsualizarCambiarEquipo({{ $value->id }})">
                                        <i class="fa-solid fa-person-booth"></i>
                                    </a>
                                </span>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </x-sistema.tabla-contenedor>
    <div id="contenedorCambiarEquipo" style="display: none;" class="mt-4">
        <div class="form-group">
            <span class="text-md font-bold p-2" id="ejecutivoCambiarEquipo"></span><br>
            <select class="form-control" id="equipo_id">
                <option></option>
                @foreach ($equipos as $item)
                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div id="botonCambiarEquipo"></div>
    </div>
</x-sistema.modal>
<script>
    function previsualizarCambiarEquipo(user_id) {
        let contenedor = document.getElementById('contenedorCambiarEquipo');
        let ejecutivoRef = document.getElementById('ejecutivoCambiarEquipo');
        let botonRef = document.getElementById('botonCambiarEquipo');
        contenedor.style.display = 'none'
        $.ajax({
            url: `{{ url('equipo/0') }}`,
            method: "GET",
            data: {
                view: 'show-cambiar-equipo',
                user_id: user_id,
            },
            success: function(data) {
                ejecutivoRef.innerHTML = `${data.name}`;
                contenedor.style.display = 'block';
                botonRef.innerHTML = `<button type="button" class="btn bg-gradient-info" onclick="cambiarEquipo(${data.id})">Cambiar</button>`;
            },
            error: function(response) {
                console.log('error');
            }
        });
    }
    function cambiarEquipo(user_id) {
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
            url: `{{ url('equipo/${user_id}') }}`,
            method: "PUT",
            data: {
                view: 'update-cambiar-equipo',
                user_id: user_id,
                equipo_id: $('#equipo_id').val(),
            },
            success: function(data) {
                location.reload();
            },
            error: function(data) {
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