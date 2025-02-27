@props([
    'data' => '',
    'onclickCloseModal' => 'closeModal()',
])
@php
    $cliente = $data['cliente'];
    $contactos = $data['contactos'];
    $comentarios = $data['comentarios'];
    $movistar = $data['movistar'];
    $ventas = $data['ventas'];
    $notificacion = $data['notificacion'];
@endphp
<x-sistema.modal title="Detalle Cliente" dialog_id="dialog" :$onclickCloseModal class="w-[95vw] max-w-5xl p-2">
    <input type="hidden" id="cliente_id" name="cliente_id" value="{{ $cliente->id }}">
    <div class="grid grid-cols-12 gap-4">
        <div class="col-span-12">
            <x-sistema.cliente.datos :$cliente>
                @role('ejecutivo')
                    <x-slot:botonHeader>
                        <button type="button" class="btn bg-gradient-secondary text-sm px-2 py-1" onclick="editCliente()"
                            id="btn_editar_cliente">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn bg-gradient-secondary text-sm px-2 py-1" onclick="saveCliente()"
                            id="btn_guardar_cliente" disabled>
                            <i class="fas fa-save"></i>
                        </button>
                    </x-slot>
                @endrole
            </x-sistema.cliente.datos>
        </div>
        <div class="col-span-12">
            <x-sistema.cliente.movistars :$movistar>
                @role('ejecutivo')
                    <x-slot:botonFooter>
                        <button type="button" class="btn bg-gradient-secondary text-sm px-2 py-1" onclick="editMovistar()"
                            id="btn_editar_movistar">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn bg-gradient-secondary text-sm px-2 py-1" onclick="saveMovistar()"
                            id="btn_guardar_movistar" disabled>
                            <i class="fas fa-save"></i>
                        </button>
                    </x-slot>
                @endrole
            </x-sistema.cliente.movistars>
        </div>
        <div class="col-span-7">
            <x-sistema.cliente.ventas />
        </div>
        <div class="col-span-5">
            <x-sistema.cliente.contactos :$contactos>
                @role('ejecutivo')
                    <x-slot:botonFooter>
                        <button type="button" class="btn bg-gradient-secondary text-sm px-2 py-1" onclick="saveContacto()"
                            id="btn_guardar_contacto">
                            <i class="fas fa-save"></i>
                        </button>
                    </x-slot>
                @endrole
            </x-sistema.cliente.contactos>
        </div>
        <div class="col-span-7">
            <x-sistema.cliente.comentarios :$comentarios>
                <x-sistema.cliente.etapas :etapas="$etapas ?? []">
                    @role('ejecutivo')
                        <x-slot:botonHeader>
                            <button type="button" class="btn bg-gradient-secondary text-sm px-2 py-1" onclick="editEtapa()"
                                id="btn_editar_etapa">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn bg-gradient-secondary text-sm px-2 py-1" onclick="saveEtapa()"
                                id="btn_guardar_etapa" disabled>
                                <i class="fas fa-save"></i>
                            </button>
                        </x-slot>
                    @endrole
                </x-sistema.cliente.etapas>
                @role('ejecutivo')
                    <x-slot:botonHeader>
                        <button type="button" class="btn bg-gradient-primary text-sm px-2 py-1" onclick="saveComentario()">
                            <i class="fas fa-save"></i>
                        </button>
                    </x-slot>
                @endrole
            </x-sistema.cliente.comentarios>
        </div>
        <div class="col-span-5">
            <x-sistema.notificacion.create :$notificacion>
                @role('ejecutivo')
                    <x-slot:botonHeader>
                        <button type="button" class="btn bg-gradient-secondary text-sm px-2 py-1" onclick="saveNotificacion()">
                            <i class="fas fa-save"></i>
                        </button>
                    </x-slot>
                @endrole
            </x-sistema.notificacion.create>
        </div>
    </div>
    <div class="flex justify-end mt-2">
        <button type="button" class="btn bg-gradient-primary" onclick="{{ $onclickCloseModal }}">Cerrar</button>
    </div>
</x-sistema.modal>



<script>
    function editCliente() {
        $('#ruc, #razon_social, #ciudad, #btn_guardar_cliente').prop('disabled', false)
    }

    function saveCliente() {
        let cliente_id = $('#cliente_id').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: `cliente-gestion/${cliente_id}`,
            method: "PUT",
            data: {
                view: 'update-cliente',
                ruc: $('#ruc').val(),
                razon_social: $('#razon_social').val(),
                ciudad: $('#ciudad').val(),
            },
            success: function(result) {
                $('#ruc, #razon_social, #ciudad, #btn_guardar_cliente').prop('disabled', true);
            },
            error: function(response) {
                mostrarError(response);
            }
        });
    }

    function saveContacto() {
        const dialog = document.querySelector("#dialog");
        dialog.querySelectorAll('.is-invalid, .invalid-feedback').forEach(element => {
            element.classList.contains('is-invalid') ? element.classList.remove('is-invalid') : element
                .remove();
        });
        let cliente_id = $('#cliente_id').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: `cliente-gestion/${cliente_id}`,
            method: "PUT",
            data: {
                view: 'update-contacto',
                dni: $('#dni').val(),
                nombre: $('#nombre').val(),
                celular: $('#celular').val(),
                cargo: $('#cargo').val(),
                correo: $('#correo').val(),
            },
            success: function(result) {
                $('#nombre').val('');
                $('#dni').val('');
                $('#celular').val('');
                $('#cargo').val('');
                $('#correo').val('');
                listContactos(result);
            },
            error: function(response) {
                mostrarError(response);
            }
        });
    }
    function mostrarContactos() {
        $("#tablaContactos").slideDown();
        $("#btnMostrarContactos").hide();
        $("#btnOcultarContactos").show();
    }
    function ocultarContactos() {
        $("#tablaContactos").slideUp();
        $("#btnOcultarContactos").hide();
        $("#btnMostrarContactos").show();
    }
    function listContactos(contactos) {
        let html = "";
        contactos.forEach(function(contacto) {
            html += `<tr id="${contacto.id}">
                        <td class="align-middle text-uppercase text-sm">
                            <span class="text-secondary text-xs font-weight-normal">${contacto.dni}</span>
                        </td>
                        <td class="align-middle text-uppercase text-sm">
                            <span class="text-secondary text-xs font-weight-normal">${contacto.nombre}</span>
                        </td>
                        <td class="align-middle text-uppercase text-sm">
                            <span class="text-secondary text-xs font-weight-normal">${contacto.celular}</span>
                        </td>
                        <td class="align-middle text-uppercase text-sm">
                            <span class="text-secondary text-xs font-weight-normal">${contacto.cargo}</span>
                        </td>
                        <td class="align-middle text-uppercase text-sm">
                            <span class="text-secondary text-xs font-weight-normal">${contacto.correo}</span>
                        </td>
                    </tr>`;
        });
        $('#contactos').html(html);
    }

    function saveComentario() {
        const dialog = document.querySelector("#dialog");
        dialog.querySelectorAll('.is-invalid, .invalid-feedback').forEach(element => {
            element.classList.contains('is-invalid') ? element.classList.remove('is-invalid') : element
                .remove();
        });
        let cliente_id = $('#cliente_id').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: `cliente-gestion/${cliente_id}`,
            method: "PUT",
            data: {
                view: 'update-comentario',
                comentario: $('#comentario').val(),
            },
            success: function(result) {
                $('#comentario').val('');
                listComentario(result);
            },
            error: function(response) {
                mostrarError(response);
            }
        });
    }
    function mostrarComentarios() {
        $("#contenedorComentarios").slideDown();
        $("#btnMostrarComentarios").hide();
        $("#btnOcultarComentarios").show();
    }
    function ocultarComentarios() {
        $("#contenedorComentarios").slideUp();
        $("#btnOcultarComentarios").hide();
        $("#btnMostrarComentarios").show();
    }
    function listComentario(comentarios) {
        let html = "";
        comentarios.forEach(function(comentario) {
            html += `<div class="mb-4" id="${comentario.id}">
                        <span class="text-slate-900 text-base font-semibold">${comentario.comentario}</span>
                        <div class="text-end">
                            <span class="text-slate-500 text-xs uppercase me-2">
                                <i class="text-blue-400 fa-solid fa-user"></i> ${comentario.usuario}
                            </span>
                            <span class="text-slate-500 text-sm">
                                <i class="text-blue-400 fa-solid fa-calendar-days"></i> ${comentario.fecha}
                            </span>
                            <span class="bg-slate-300 text-slate-700 text-xs font-semibold font-se mb-0 mx-1 px-3 py-1 rounded-lg">
                                ${comentario.etiqueta}
                            </span>
                            <span class="bg-slate-300 text-slate-700 text-xs font-semibold font-se mb-0 mx-1 px-3 py-1 rounded-lg">
                                ${comentario.detalle}
                            </span>
                        </div>
                    </div>
                    <hr>`;
        });
        $('#comentarios').html(html);
    }

    function saveNotificacion() {
        let cliente_id = $('#cliente_id').val();
        const dialog = document.querySelector("#dialog");
        dialog.querySelectorAll('.is-invalid, .invalid-feedback').forEach(element => {
            element.classList.contains('is-invalid') ? element.classList.remove('is-invalid') : element
                .remove();
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: `notificacion`,
            method: "POST",
            data: {
                view: 'store_from_fichacliente',
                notificaciontipo_id: $('#notificaciontipo_id').val(),
                mensaje: $('#mensaje').val(),
                fecha: $('#fecha').val(),
                hora: $('#hora').val(),
                cliente_id: cliente_id,
            },
            success: function(result) {
                $('#mensaje, #fecha, #hora').val('');
                listNotificacion(result);
            },
            error: function(response) {
                mostrarError(response);
            }
        });
    }
    function mostrarNotificaciones() {
        $("#contenedorNotificaciones").slideDown();
        $("#btnMostrarNotificaciones").hide();
        $("#btnOcultarNotificaciones").show();
    }
    function ocultarNotificaciones() {
        $("#contenedorNotificaciones").slideUp();
        $("#btnOcultarNotificaciones").hide();
        $("#btnMostrarNotificaciones").show();
    }
    
    // Función para listar notificaciones (sin cambios respecto a la versión original)
    function listNotificacion(notificacions) {
        let html = "";
        notificacions.forEach(function(notificacion) {
            html += `<div class="mb-4" id="${notificacion.id}">
                        <span class="text-slate-900 text-base font-semibold">${notificacion.asunto}</span>
                        <div class="text-end">
                            <span class="text-slate-500 text-sm">
                                <i class="text-blue-400 fa-solid fa-calendar-days"></i> ${notificacion.fecha} ${notificacion.hora}
                            </span>
                        </div>
                    </div>
                    <hr>`;
        });
        $('#notificacions').html(html);
    }

    function editMovistar() {
        $('#estadowick_id, #estadodito_id, #linea_claro, #linea_entel, #linea_bitel, #linea_movistar, #clientetipo_id, #ejecutivo_salesforce, #agencia_id, #btn_guardar_movistar')
            .prop('disabled', false)
    }
    selectEstadoWick({{ $data['cliente']->movistars->last()->estadowick_id ?? 0 }});

    function selectEstadoWick(estadowick_id) {
        $(`#estadowick_id option[value='${estadowick_id}']`).attr('selected', 'selected');
    }
    selectEstadoDito({{ $data['cliente']->movistars->last()->estadodito_id ?? 0 }});

    function selectEstadoDito(estadodito_id) {
        $(`#estadodito_id option[value='${estadodito_id}']`).attr('selected', 'selected');
    }
    selectClientetipo({{ $data['cliente']->movistars->last()->clientetipo_id ?? 0 }});

    function selectClientetipo(clientetipo_id) {
        $(`#clientetipo_id option[value='${clientetipo_id}']`).attr('selected', 'selected');
    }
    selectAgencia({{ $data['cliente']->movistars->last()->agencia_id ?? 0 }});

    function selectAgencia(agencia_id) {
        $(`#agencia_id option[value='${agencia_id}']`).attr('selected', 'selected');
    }

    function saveMovistar() {
        const dialog = document.querySelector("#dialog");
        dialog.querySelectorAll('.is-invalid, .invalid-feedback').forEach(element => {
            element.classList.contains('is-invalid') ? element.classList.remove('is-invalid') : element
                .remove();
        });
        let cliente_id = $('#cliente_id').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: `cliente-gestion/${cliente_id}`,
            method: "PUT",
            data: {
                view: 'update-movistar',
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
            },
            success: function(result) {
                $('#estadowick_id, #estadodito_id, #linea_claro, #linea_entel, #linea_bitel, #linea_movistar, #clientetipo_id, #ejecutivo_salesforce, #agencia_id, #btn_guardar_movistar')
                    .prop('disabled', true)
            },
            error: function(response) {
                mostrarError(response);
            }
        });
    }
    selectEtapa({{ $data['cliente']->etapas->last()->id }});

    function selectEtapa(etapa_id) {
        $(`#etapa_id option[value='${etapa_id}']`).attr('selected', 'selected');
        $('#etapa_id, #btn_guardar_etapa').prop('disabled', true)
    }

    function editEtapa() {
        $('#etapa_id, #btn_guardar_etapa').prop('disabled', false)
    }

    function saveEtapa() {
        const dialog = document.querySelector("#dialog");
        dialog.querySelectorAll('.is-invalid, .invalid-feedback').forEach(element => {
            element.classList.contains('is-invalid') ? element.classList.remove('is-invalid') : element
                .remove();
        });
        let cliente_id = $('#cliente_id').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: `cliente-gestion/${cliente_id}`,
            method: "PUT",
            data: {
                view: 'update-etapa',
                etapa_id: $("#etapa_id option:selected").val(),
                comentario: $('#comentario').val(),
            },
            success: function(result) {
                $('#comentario').val('');
                listComentario(result);
                $('#etapa_id, #btn_guardar_etapa').prop('disabled', true)
            },
            error: function(response) {
                mostrarError(response);
            }
        });
    }

    function editCargo() {
        $('#tbodyCargo tr').each(function() {
            $(this).find('#cargo_producto_nombre').prop('disabled', false);
            $(this).find('#cargo_cantidad').prop('disabled', false);
            $(this).find('#cargo_total').prop('disabled', false);
        });
        $('#btn_guardar_cargo').prop('disabled', false);
    }

    function saveCargo() {
        let cliente_id = $('#cliente_id').val();
        let dataCargo = [];
        $('#tbodyCargo tr').each(function() {
            dataCargo.push({
                producto_id: $(this).attr('id'),
                producto_nombre: $(this).find('#cargo_producto_nombre').val(),
                cantidad: $(this).find('#cargo_cantidad').val(),
                total: $(this).find('#cargo_total').val(),
            });
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: `cliente-gestion/${cliente_id}`,
            method: "PUT",
            data: {
                view: 'update-cargo',
                dataCargo: dataCargo,
            },
            success: function(result) {
                $('#tbodyCargo tr').each(function() {
                    $(this).find('#cargo_producto_nombre').prop('disabled', true);
                    $(this).find('#cargo_cantidad').prop('disabled', true);
                    $(this).find('#cargo_total').prop('disabled', true);
                });
                $('#btn_guardar_cargo').prop('disabled', true);
            },
            error: function(response) {}
        });
    }

    function mostrarError(response) {
        let errors = response.responseJSON;
        if (errors) {
            let firstErrorKey = null;
            $.each(errors.errors, function(key, value) {
                $('#dialog #' + key).addClass('is-invalid');
                $('#dialog #' + key).after('<span class="invalid-feedback" role="alert"><strong>' + value +
                    '</strong></span>');
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
