@props([
    'onclickCloseModal' => 'closeModal()',
])
<x-sistema.modal title="Agregar Cliente" dialog_id="dialog">
    <div class="row p-1">
        <div class="col-10 p-0">
            <div class="row p-0 m-2">
                <div class="col-12">
                    <div class="row">
                        <div class="col-6 p-0">
                            <x-sistema.cliente.datos></x-sistema.cliente.datos>
                            <x-sistema.cliente.contactos></x-sistema.cliente.contactos>
                        </div>
                        <div class="col-6 p-0">
                            <x-sistema.cliente.ventas></x-sistema.cliente.ventas>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-10">
                            <x-sistema.cliente.comentarios></x-sistema.cliente.comentarios>
                        </div>
                        <div class="col-2">
                            <x-sistema.cliente.etapas></x-sistema.cliente.etapas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-2 p-0">
            <x-sistema.cliente.movistars></x-sistema.cliente.movistars>
        </div>
    </div>
    <div class="flex justify-end mt-2 gap-2">
        <x-ui.button class="bg-slate-700" type="button" onclick="{{ $onclickCloseModal }}">Cancelar</x-ui.button>
        <x-ui.button type="button" onclick="submitCliente(this)">Agregar</x-ui.button>
    </div>
</x-sistema.modal>
<script>
    function submitCliente(button) {
        limpiarError();
        capturarToken();
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
        $.ajax({
            url: `{{ url('cliente') }}`,
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
                mostrarError(response)
                button.disabled = false;
            }
        });
        
    }
</script>
