@props([
    'botonHeader' => '',
    'botonFooter' => '',
    'ventas' => false,
])
<x-sistema.card class="m-2 mx-0">
    <div class="d-flex flex-row flex-wrap justify-content-between">
        <x-sistema.titulo title="Productos en Negociación" />
        @role('ejecutivo')
            <div class="flex flex-row gap-2" id="cont-venta-header"></div>
        @endrole
    </div>
    @role('ejecutivo')
        <div class="form-group">
            <select class="form-control uppercase" name="producto_id" id="producto_id"></select>
        </div>
    @endrole
    <div class="card">
        <div class="table-responsive">
            <table class="table" id="producto_table">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">Producto</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2" style="width: 200px;">Detalle</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2" style="width: 100px;">Cantidad</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2" style="width: 100px;">Precio</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2" style="width: 130px;">Cargo Fijo</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2" style="width: 100px;"></th>
                    </tr>
                </thead>
                <tbody num="0"></tbody>
                <tfoot></tfoot>
            </table>
        </div>
    </div>
    {{ $botonFooter }}
</x-sistema.card>
<script>
    selectProducto();
    function selectProducto() {
        $('#producto_id').html('');
        $.ajax({
            url: `{{ url('producto/0') }}`,
            method: "GET",
            data: {
                view: 'show-producto-select',
            },
            success: function( productos ) {
                let option = `<option value="0">Seleccionar...</option>`;
                productos.forEach(function (producto, index) {
                    option += `<option value="${producto.id}">${producto.nombre}</option>`;
                })
                $('#producto_id').append(option);
            },
            error: function( data ) {
                console.log(data);
            }
        });
    }
    var selectElement = document.getElementById('producto_id');
    $('#producto_id').on("change", function (event) {
        $.ajax({
            url: `{{ url('producto/0') }}`,
            method: "GET",
            data: {
                view: 'show-producto-table',
                producto_id: event.target.value,
            },
            success: function (producto) {
                let tbodyRef = $('#producto_table tbody');
                let num = tbodyRef.attr('num');
                let tr = `<tr id="${num}">
                        <td class="font-weight-bold mb-0">
                            <input type="hidden" value="${producto.id}" id="producto_id${num}">
                            <input type="hidden" value="${producto.nombre}" id="producto_nombre${num}">
                            ${producto.nombre}
                        </td>
                        <td>
                            <input class="form-control" type="text" value="" id="detalle${num}">
                        </td>
                        <td>
                            <input class="form-control" type="number" value="1" id="cantidad${num}" onkeyup="cargoFijoProducto(${num})">
                        </td>
                        <td>
                            <input class="form-control" type="number" value="0" id="precio${num}" onkeyup="cargoFijoProducto(${num})">
                        </td>
                        <td>
                            <input class="form-control" type="number" value="0" id="cargofijo${num}" disabled>
                        </td>
                        <td>
                            <button class="btn btn-icon btn-2 btn-danger" type="button" onclick="eliminarProducto(${num})">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>`;
                tbodyRef.append(tr);
                cargoFijoProducto(num);
                num++;
                tbodyRef.attr('num', num);
            }
        });
        selectProducto();
    });
    function cargoFijoProducto(num) {
        let cantidad = parseFloat($('#producto_table tbody #cantidad'+num).val());
        let precio = parseFloat($('#producto_table tbody #precio'+num).val());
        let cargofijo = cantidad * precio;
        $('#cargofijo'+num).val(cargofijo.toFixed(2));
        totalVenta();
    }
    function totalVenta() {
        let trRef = $('#producto_table tbody tr');
        let total = 0;
        $.each(trRef, function (index, tr) {
            let cargofijo = parseFloat($('#cargofijo'+tr.id).val());
            total += cargofijo;
        })
        $('#total').val(total.toFixed(2));
    }
    function eliminarProducto(num) {
        $('#producto_table tbody tr#'+num).remove();
        totalVenta();
    }
    // Listar la ultima Venta
    ultimaVenta();
    $('#producto_id').prop('disabled', false);
    function ultimaVenta() {
        let cliente_id = $('#cliente_id').val();
        let tbodyRef = $('#producto_table tbody');
        let tfootRef = $('#producto_table tfoot');
        let headerRef = $('#cont-venta-header');
        tbodyRef.html('');
        tfootRef.html('');
        headerRef.html('');
        $.ajax({
            url: `{{ url('cliente-gestion/${cliente_id}') }}`,
            method: "GET",
            data: {
                view: 'show-ultima-venta',
            },
            success: function (productos) {
                if (productos) {
                    $('#producto_id').prop('disabled', true);
                    let total = 0;
                    let venta_id = 0;
                    productos.forEach(function (producto) {
                        tbodyRef.append(`<tr>
                                <td class="font-weight-bold mb-0">${producto.nombre}</td>
                                <td class="font-weight-bold mb-0">${producto.pivot.detalle}</td>
                                <td class="font-weight-bold mb-0">${producto.pivot.cantidad}</td>
                                <td class="font-weight-bold mb-0">${producto.pivot.precio}</td>
                                <td class="font-weight-bold mb-0">${producto.pivot.total}</td>
                                <td></td>
                            </tr>`);
                        total += parseFloat(producto.pivot.total);
                        venta_id = producto.pivot.venta_id;
                    })
                    tfootRef.append(`<tr>
                            <td colspan="3"></td>
                            <td class="text-uppercase text-secondary font-weight-bolder">TOTAL</td>
                            <td>
                                <input class="form-control" type="number" value="${total.toFixed(2)}" id="total" disabled>
                            </td>
                            <td></td>
                        </tr>`);
                    headerRef.append(`<button class="btn btn-icon btn-2 btn-secondary" type="button" onclick="editarVenta(${venta_id})">
                            <i class="fa-solid fa-edit"></i>
                        </button>
                        <button class="btn btn-icon btn-2 btn-warning" type="button" onclick="nuevaVenta(${venta_id})">
                            <i class="fa-solid fa-plus"></i>
                        </button>`);
                } else {
                    nuevaVenta();
                }
            }
        });
    }
    function editarVenta(venta_id) {
        let tbodyRef = $('#producto_table tbody');
        let tfootRef = $('#producto_table tfoot');
        let headerRef = $('#cont-venta-header');
        tbodyRef.html('');
        tfootRef.html('');
        headerRef.html('');
        $.ajax({
            url: `{{ url('cliente-gestion/${venta_id}') }}`,
            method: "GET",
            data: {
                view: 'show-editar-venta',
            },
            success: function (productos) {
                let num = tbodyRef.attr('num');
                let total = 0;
                productos.forEach(function (producto) {
                    $('#producto_id').prop('disabled', false);
                    tbodyRef.append(`<tr id="${num}">
                            <td class="font-weight-bold mb-0">
                                <input type="hidden" value="${producto.id}" id="producto_id${num}">
                                <input type="hidden" value="${producto.nombre}" id="producto_nombre${num}">
                                ${producto.nombre}
                            </td>
                            <td>
                                <input class="form-control" type="text" value="${producto.pivot.detalle}" id="detalle${num}">
                            </td>
                            <td>
                                <input class="form-control" type="number" value="${producto.pivot.cantidad}" id="cantidad${num}" onkeyup="cargoFijoProducto(${num})">
                            </td>
                            <td>
                                <input class="form-control" type="number" value="${producto.pivot.precio}" id="precio${num}" onkeyup="cargoFijoProducto(${num})">
                            </td>
                            <td>
                                <input class="form-control" type="number" value="${producto.pivot.total}" id="cargofijo${num}" disabled>
                            </td>
                            <td>
                                <button class="btn btn-icon btn-2 btn-danger" type="button" onclick="eliminarProducto(${num})">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>`);
                    total += parseFloat(producto.pivot.total);
                    num++;
                })
                tbodyRef.attr('num', num);
                tfootRef.append(`<tr>
                        <td colspan="3"></td>
                        <td class="text-uppercase text-secondary font-weight-bolder">TOTAL</td>
                        <td>
                            <input class="form-control" type="number" value="${total.toFixed(2)}" id="total" disabled>
                        </td>
                        <td></td>
                    </tr>`);
                headerRef.append(`<button class="btn btn-icon btn-2 btn-primary" type="button" onclick="submitVenta(${venta_id})">
                        <i class="fa-solid fa-save"></i>
                    </button>
                    <button class="btn btn-icon btn-2 btn-danger" type="button" onclick="ultimaVenta()">
                        <i class="fa-solid fa-xmark"></i>
                    </button>`);
            }
        });
    }
    function nuevaVenta(venta_id = 0) {
        let cliente_id = $('#cliente_id').val();
        let tbodyRef = $('#producto_table tbody');
        let tfootRef = $('#producto_table tfoot');
        let headerRef = $('#cont-venta-header');
        tbodyRef.html('');
        tfootRef.html('');
        headerRef.html('');
        $('#producto_id').prop('disabled', false);
        tfootRef.append(`<tr>
                <td colspan="3"></td>
                <td class="text-uppercase text-secondary font-weight-bolder">TOTAL</td>
                <td>
                    <input class="form-control" type="number" value="0.00" id="total" disabled>
                </td>
                <td></td>
            </tr>`);
        if (cliente_id != undefined) {
            headerRef.append(`<button class="btn btn-icon btn-2 btn-primary" type="button" onclick="submitVenta(${venta_id})">
                    <i class="fa-solid fa-save"></i>
                </button>`);
        }
        if (venta_id != 0) {
            headerRef.append(`<button class="btn btn-icon btn-2 btn-danger" type="button" onclick="ultimaVenta()">
                    <i class="fa-solid fa-xmark"></i>
                </button>`);
        }
    }
    function submitVenta(venta_id = 0) {
        let cliente_id = $('#cliente_id').val();
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
            url: `cliente-gestion/${cliente_id}`,
            method: "PUT",
            data: {
                view: 'update-cargo',
                dataCargo: dataCargo,
                venta_id: venta_id,
            },
            success: function(productos) {
                ultimaVenta();
            },
            error: function( response ) {
            }
        });
    }
</script>