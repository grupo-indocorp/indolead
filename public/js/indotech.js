// ============= MODALES NATIVOS EXISTENTES =============
function openModal() {
    const dialog = document.querySelector("dialog");
    dialog.showModal();
}

function closeModal() {
    const dialog = document.querySelector("dialog");
    dialog.close();
}

// ============= NUEVAS FUNCIONES PARA BOOTSTRAP =============
function openBootstrapModal(modalId = 'modalArchivo') {
    $(`#${modalId}`).modal('show');
}

function closeBootstrapModal(modalId = 'modalArchivo') {
    $(`#${modalId}`).modal('hide');
}

// ============= MODAL FUNNEL (CÓDIGO ORIGINAL SIN CAMBIOS) =============
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
    if (movistar != null) {
        $('#wick').val(movistar.estado_wick);
        $('#lineas_claro').val(movistar.linea_claro);
        $('#lineas_entel').val(movistar.linea_entel);
        $('#lineas_bitel').val(movistar.linea_bitel);
        $('#tipo_cliente').val(movistar.tipo_cliente);
        $('#ejecutivo_salesforce').val(movistar.ejecutivo_salesforce);
        $('#agencia').val(movistar.agencia);
    }

    // modal
    $('#btnmodal').click(); // Llama al modal nativo existente
}

// ============= FUNCIONES AUXILIARES (CÓDIGO ORIGINAL) =============
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
    });
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
    });
    $('#contactos').html(html);
}


function editarArchivo(id) {
    $.ajax({
        url: `/files/${id}/edit`,
        method: "GET",
        success: function (result) {
            $('#contModal').html(result);
            $('#editFileModal').modal('show');

            // Manejar envío del formulario
            $('#editFileForm').on('submit', function (e) {
                e.preventDefault();
                const formData = new FormData(this);

                $.ajax({
                    url: `/files/${id}`,
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-HTTP-Method-Override': 'PUT' // Para simular PUT
                    },
                    success: function (response) {
                        $('#editFileModal').modal('hide');
                        location.reload(); // Recargar para ver cambios
                    },
                    error: function (response) {
                        console.error('Error al actualizar:', response);
                    }
                });
            });
        },
        error: function (response) {
            console.error('Error al cargar formulario:', response);
        }
    });
}

// ============= FUNCIONES DE ARCHIVOS (MODIFICADO) =============
function descargarArchivo(id) {
    if (!window.downloadRouteBase) {
        alert("Error: Configuración de ruta no encontrada");
        return;
    }
    const url = `${window.downloadRouteBase}/${id}/download`;
    console.log("URL generada:", url); // Verifica en consola
    window.location.href = url;
}

function eliminarArchivo(id) {
    if (confirm('¿Estás seguro de eliminar este archivo?')) {
        $.ajax({
            url: `/files/${id}`,
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            success: function(result) {
                // Recarga solo la tabla (mejor experiencia)
                $('#cont-tabla-archivos').load(location.href + ' #cont-tabla-archivos');
            },
            error: function(response) {
                const errorMsg = response.responseJSON?.error || "Error desconocido";
                alert(`Error al eliminar: ${errorMsg}`);
                console.error("Detalles:", response);
            }
        });
    }
}

function rellenarDescripcion(input) {
    // Obtén el nombre del archivo sin la extensión
    const nombreArchivo = input.files[0].name.replace(/\.[^/.]+$/, ""); // Elimina la extensión

    // Rellena el campo de descripción con el nombre del archivo
    document.getElementById('description').value = nombreArchivo;
}

// ============= FUNCIONES DE EDICIÓN (CÓDIGO ORIGINAL) =============
function editarCliente() {
    $('#ruc, #razon_social, #ciudad, #btn_guardar_cliente').prop('disabled', false);
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
        success: function (result) {
            $('#ruc, #razon_social, #ciudad, #btn_guardar_cliente').prop('disabled', true);
        },
        error: function (response) {
        }
    });
}

function editarMovistar() {
    $('#wick, #lineas_claro, #lineas_entel, #lineas_bitel, #tipo_cliente, #ejecutivo_salesforce, #agencia, #btn_guardar_movistar').prop('disabled', false);
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
        success: function (result) {
            $('#wick, #lineas_claro, #lineas_entel, #lineas_bitel, #tipo_cliente, #ejecutivo_salesforce, #agencia, #btn_guardar_movistar').prop('disabled', true);
        },
        error: function (response) {
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
        success: function (result) {
            $('#comentario').val('');
            listarComentario(result.comentarios);
        },
        error: function (response) {
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
        success: function (result) {
            $('#ruc, #razon_social, #ciudad').prop('disabled', true);
            $('#wick, #lineas_claro, #lineas_entel, #lineas_bitel, #tipo_cliente, #ejecutivo_salesforce, #agencia').prop('disabled', true);
            $('#nombre, #celular, #cargo, #fecha_proximo').val('');
            listarContacto(result.contactos);
        },
        error: function (response) {
        }
    });
}