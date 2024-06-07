// =============MODAL GOBLAL=============
function openModal() {
    const dialog = document.querySelector("dialog");
    // dialog.querySelectorAll('.is-invalid, .invalid-feedback').forEach(element => {
    //     element.classList.contains('is-invalid') ? element.classList.remove('is-invalid') : element.remove();
    // });
    // dialog.querySelectorAll('input').forEach(function(input) {
    //     input.value = '';
    // });
    // dialog.querySelectorAll('textarea').forEach(function(textarea) {
    //     textarea.value = '';
    // });
    dialog.showModal();
}
function closeModal() {
    const dialog = document.querySelector("dialog");
    dialog.close();
}

// =============MODAL FUNNEL=============
function modalCliente(result) {
    let cliente = result.cliente;
    let contactos = result.contactos;
    let comentarios = result.comentarios;
    let movistar = result.movistar;

    // cliente
    $('#cliente_id').val(cliente.id);
    $('#ruc').val(cliente.ruc);
    $('#razon_social').val(cliente.razon_social);
    $('#ciudad').val(cliente.ciudad);

    // contacto
    listarContacto(contactos);

    // comentarios
    listarComentario(comentarios);

    // movistar
    if (movistar!=null) {
        $('#wick').val(movistar.estado_wick);
        $('#lineas_claro').val(movistar.linea_claro);
        $('#lineas_entel').val(movistar.linea_entel);
        $('#lineas_bitel').val(movistar.linea_bitel);
        $('#tipo_cliente').val(movistar.tipo_cliente);
        $('#ejecutivo_salesforce').val(movistar.ejecutivo_salesforce);
        $('#agencia').val(movistar.agencia);
    }

    // modal
    $('#btnmodal').click();
}
function listarComentario(comentarios) {
    let html = "";
    comentarios.forEach(function (comentario) {
        html += `<li class="flex p-2 mb-4 border-0 rounded-t-inherit rounded-xl bg-gray-50" id="${comentario.id}">
                    <div class="flex flex-col">
                        <h5 class="mb-2 leading-normal text-m">${comentario.usuario}</h5>
                        <span class="font-semibold text-slate-700 sm:ml-2">${comentario.comentario}</span>
                        <span class="text-slate-700 sm:ml-2">${comentario.fecha}</span>
                    </div>
                </li>`;
    })
    $('#comentarios').html(html);
}
function listarContacto(contactos) {
    let html = "";
    contactos.forEach(function (contacto) {
        html += `<tr id="${contacto.id}">
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
                        <span class="text-secondary text-xs font-weight-normal">${contacto.fecha_proximo}</span>
                    </td>
                </tr>`;
    })
    $('#contactos').html(html);
}
function editarCliente() {
    $('#ruc, #razon_social, #ciudad, #btn_guardar_cliente').prop('disabled', false)
}
function guardarCliente() {
    let cliente_id = $('#cliente_id').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: `funnel/${cliente_id}`,
        method: "PUT",
        data: {
            view: 'update-cliente',
            ruc: $('#ruc').val(),
            razon_social: $('#razon_social').val(),
            ciudad: $('#ciudad').val(),
        },
        success: function( result ) {
            $('#ruc, #razon_social, #ciudad, #btn_guardar_cliente').prop('disabled', true);
        },
        error: function( response ) {
        }
    });
}
function editarMovistar() {
    $('#wick, #lineas_claro, #lineas_entel, #lineas_bitel, #tipo_cliente, #ejecutivo_salesforce, #agencia, #btn_guardar_movistar').prop('disabled', false) 
}
function guardarMovistar() {
    let cliente_id = $('#cliente_id').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: `funnel/${cliente_id}`,
        method: "PUT",
        data: {
            view: 'update-movistar',
            wick: $('#wick').val(),
            lineas_claro: $('#lineas_claro').val(),
            lineas_entel: $('#lineas_entel').val(),
            lineas_bitel: $('#lineas_bitel').val(),
            tipo_cliente: $('#tipo_cliente').val(),
            ejecutivo_salesforce: $('#ejecutivo_salesforce').val(),
            agencia: $('#agencia').val(),
        },
        success: function( result ) {
            $('#wick, #lineas_claro, #lineas_entel, #lineas_bitel, #tipo_cliente, #ejecutivo_salesforce, #agencia, #btn_guardar_movistar').prop('disabled', true);
        },
        error: function( response ) {
        }
    });
}
function guardarComentario() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: `funnel`,
        method: "POST",
        data: {
            view: 'store-comentario',
            cliente_id: $('#cliente_id').val(),
            comentario: $('#comentario').val()
        },
        success: function( result ) {
            $('#comentario').val('');
            listarComentario(result.comentarios);
        },
        error: function( response ) {
        }
    });
}
function guardarModal() {
    let cliente_id = $('#cliente_id').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: `funnel/${cliente_id}`,
        method: "PUT",
        data: {
            view: 'update-modal',
            // cliente
            ruc: $('#ruc').val(),
            razon_social: $('#razon_social').val(),
            ciudad: $('#ciudad').val(),
            // contacto
            nombre: $('#nombre').val(),
            celular: $('#celular').val(),
            cargo: $('#cargo').val(),
            fecha_proximo: $('#fecha_proximo').val(),
            // movisar
            wick: $('#wick').val(),
            lineas_claro: $('#lineas_claro').val(),
            lineas_entel: $('#lineas_entel').val(),
            lineas_bitel: $('#lineas_bitel').val(),
            tipo_cliente: $('#tipo_cliente').val(),
            ejecutivo_salesforce: $('#ejecutivo_salesforce').val(),
            agencia: $('#agencia').val(),
        },
        success: function( result ) {
            $('#ruc, #razon_social, #ciudad').prop('disabled', true);
            $('#wick, #lineas_claro, #lineas_entel, #lineas_bitel, #tipo_cliente, #ejecutivo_salesforce, #agencia').prop('disabled', true);
            $('#nombre, #celular, #cargo, #fecha_proximo').val('');
            listarContacto(result.contactos);
        },
        error: function( response ) {
        }
    });
}