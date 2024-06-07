@extends('layouts.app')
@can('sistema.gestion_cliente')
    @section('content')
        <div class="h-100 w-full">
            <div class="card h-full">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between ">
                        <h6 class="mb-0">Funnel</h6>
                        <a href="javascript:;" class="btn bg-gradient-primary btn-sm mb-0" type="button" onclick="agregarCliente()">Agregar</a>
                    </div>
                </div>
                <div class="card-body px-0 py-4 overflow-x-auto">
                    <div id="myFunnel"></div>
                </div>
            </div>
        </div>
    @endsection
    @section('modal')
        <div id="contModal"></div>
    @endsection
    
    @section('style-funnel')
        <link href="{{ asset('assets/js/plugins/dist/jkanban.css') }}" rel="stylesheet">
    @endsection
    
    @section('script-funnel')
        <script src="{{ asset('assets/js/plugins/dragula/dragula.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/dist/jkanban.js') }}"></script>
        <script>
            let etapas = @json($etapas);
            let clientes = @json($clientes);
            funnel(etapas, clientes);
            function funnel(etapas, clientes) {
                let funnel = [];
                etapas.forEach(function(etp) {
                    let lista = [];
                    clientes.forEach(function(clt) {
                        if (etp.id == clt.etapa_id) {
                            let cliente = {
                                id: clt.id,
                                title: `<div class="">
                                        <div class="flex justify-between">
                                            <span class="text-xs uppercase font-semibold">${ clt.ruc }</span>
                                            <span class="text-xs uppercase font-normal">${ clt.fecha_gestion }</span>
                                        </div>
                                        <div class="flex pt-2">
                                            <span class="text-sm uppercase font-bold">${ clt.razon_social }</span>
                                        </div>
                                        <div class="flex justify-end">
                                            <span class="text-xs text-red-400 font-bold">${ clt.dias }</span>
                                        </div>
                                    </div>`,
                                class: ["border-radius-md", clt.opacity],
                                username: clt.id
                            };
                            lista.push(cliente);
                        }
                    })
                    let etapa = {
                        id: etp.id.toString(),
                        title: etp.nombre,
                        item: lista
                    };
                    funnel.push(etapa);
                })

                var Kanban = new jKanban({
                    element: "#myFunnel",
                    // gutter: "5px",
                    // widthBoard: "300px",
                    responsivePercentage: true,
                    dragItems: true,
                    dragBoards: false,
                    boards: funnel,
                    click: function(el) {
                        let cliente_id = el.getAttribute('data-eid');
                        detalleCliente(cliente_id)
                    },
                    dragendEl: function (el) {
                        let main = $(el).parent();
                        let board_padre = $(main).parent();
                        let etapa_id = $(board_padre[0]).attr('data-id');
                        let cliente_id = el.getAttribute('data-eid');
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: `{{ url('gestion_cliente/${cliente_id}') }}`,
                            method: "PUT",
                            data: {
                                view: 'update-etapa',
                                etapa_id: etapa_id,
                            },
                            success: function( result ) {
                                cargaFunnel()
                            },
                            error: function( response ) {
                            }
                        });
                    },
                    dragendBoard : function (el) {
                    },
                });
            }
            function agregarCliente() {
                $.ajax({
                    url: `{{ url('funnel/create') }}`,
                    method: "GET",
                    data: {
                        view: 'create'
                    },
                    success: function( result ) {
                        $('#contModal').html(result);
                        openModal();
                    },
                    error: function( response ) {
                        console.log('error');
                    }
                });
            }
            function detalleCliente(cliente_id) {
                $.ajax({
                    url: `{{ url('funnel/${cliente_id}') }}`,
                    method: "GET",
                    data: {
                        view: 'detalle'
                    },
                    success: function( result ) {
                        $('#contModal').html(result);
                        openModal();
                    },
                    error: function( response ) {
                        console.log('error');
                    }
                });
            }
            function cargaFunnel() {
                $.ajax({
                    url: `{{ url('funnel/0') }}`,
                    method: "GET",
                    data: {
                        view: 'show-funnel'
                    },
                    success: function( result ) {
                        $('#myFunnel').html('');
                        funnel(result.etapas, result.clientes);
                    },
                    error: function( response ) {
                    }
                });
            }
            function closeFicha() {
                cargaFunnel();
                closeModal();
            }
        </script>
    @endsection
@endcan

