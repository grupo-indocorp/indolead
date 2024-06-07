@props([
    'onclickCloseModal' => 'closeModal()',
])
<x-sistema.modal title="Agregar Cliente" dialog_id="dialog">
    <div class="row p-1">
        <div class="col-9 p-0">
            <x-sistema.cliente.datos></x-sistema.cliente.datos>
            <x-sistema.cliente.contactos></x-sistema.cliente.contactos>
            <x-sistema.cliente.comentarios></x-sistema.cliente.comentarios>
            <x-sistema.cliente.ventas></x-sistema.cliente.ventas>
        </div>
        <div class="col-3 p-0">
            <x-sistema.cliente.movistars></x-sistema.cliente.movistars>
            <x-sistema.cliente.etapas></x-sistema.cliente.etapas>
        </div>
    </div>
    <div class="flex justify-end mt-2">
        <button type="button" class="btn bg-gradient-secondary m-0" onclick="{{ $onclickCloseModal }}">Cancelar</button>
        <button type="button" class="btn bg-gradient-primary m-0" id="btn_submit_cliente" onclick="submitCliente()">Agregar</button>
    </div>
</x-sistema.modal>
<script>
    function submitCliente() {
        $('#btn_submit_cliente').prop('disabled', true);
        const dialog = document.querySelector("#dialog");
        dialog.querySelectorAll('.is-invalid, .invalid-feedback').forEach(element => {
            element.classList.contains('is-invalid') ? element.classList.remove('is-invalid') : element.remove();
        });
        let dataCargo = [];
        $.each($('#producto_table tbody tr'), function (index, tr) {
            dataCargo.push({
                producto_id: $('#producto_id'+tr.id).val(),
                producto_nombre: $('#producto_nombre'+tr.id).val(),
                detalle: $('#detalle'+tr.id).val(),
                cantidad: $('#cantidad'+tr.id).val(),
                precio: $('#precio'+tr.id).val(),
                total: $('#cargofijo'+tr.id).val(),
            });
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: `{{ url('gestion_cliente') }}`,
            method: "POST",
            data: {
                // cliente
                view: 'store',
                ruc: $('#ruc').val(),
                razon_social: $('#razon_social').val(),
                ciudad: $('#ciudad').val(),
                // contacto
                dni: $('#dni').val(),
                nombre: $('#nombre').val(),
                celular: $('#celular').val(),
                cargo: $('#cargo').val(),
                correo: $('#correo').val(),
                // comentario
                comentario: $('#comentario').val(),
                // movisar
                estadowick_id: $('#estadowick_id').val() ?? 1,
                estadodito_id: $('#estadodito_id').val() ?? 1,
                linea_claro: $('#linea_claro').val() ?? '0',
                linea_entel: $('#linea_entel').val() ?? '0',
                linea_bitel: $('#linea_bitel').val() ?? '0',
                linea_movistar: $('#linea_movistar').val() ?? '0',
                clientetipo_id: $('#clientetipo_id').val() ?? 1,
                ejecutivo_salesforce: $('#ejecutivo_salesforce').val() ?? '',
                agencia_id: $('#agencia_id').val() ?? 1,
                // etapa
                etapa_id: $('#etapa_id').val(),
                // cargo
                dataCargo: dataCargo,
            },
            success: function( result ) {
                {{ $onclickCloseModal }}
            },
            error: function( response ) {
                mostrarError(response)
                $('#btn_submit_cliente').prop('disabled', false);
            }
        });
    }
    function mostrarError(response) {
        let errors = response.responseJSON;
        if(errors) {
            let firstErrorKey = null;
            $.each(errors.errors, function(key, value){
                $('#dialog #'+key).addClass('is-invalid');
                $('#dialog #'+key).after('<span class="invalid-feedback" role="alert"><strong>'+ value +'</strong></span>');
                if (!firstErrorKey) {
                    firstErrorKey = key;
                }
            });
            if (firstErrorKey) {
                $('#dialog #' + firstErrorKey).focus();
            }
        }
    }
</script>
