@extends('layouts.app')

@php
    // Obtén el logo dinámico del sistema o uno por defecto
    $sistema = \App\Models\Sistema::first();
    $logoUrl = ($sistema && $sistema->logo) ? Storage::url($sistema->logo) : asset('images/logo.png');
@endphp

@can('sistema.gestion_cliente')
    @section('content')
        <x-sistema.card-contenedor>
            <div class="p-3 pb-0">
                <div class="d-flex flex-column flex-md-row justify-content-between">
                    <div class="mb-2 mb-md-0">
                        <x-sistema.titulo title="Gestión de Clientes" />
                    </div>
                    <div>
                        @can('sistema.gestion_cliente.agregar')
                            <x-ui.button type="button" id="btnAgregarCliente">Agregar</x-ui.button>
                        @endcan
                    </div>
                </div>
                @include('sistema.cliente.gestion.section-filtro')
            </div>
            <div class="p-3" id="cont-tabla-cliente">
                @include('sistema.cliente.gestion.filtro')
            </div>
        </x-sistema.card-contenedor>
        @php
            $data_filtro = json_encode($filtro);
        @endphp
        <input type="hidden" name="data_filtro" id="data_filtro" value="{{ $data_filtro }}">

        <!-- Loader y feedback visual -->
        <div id="main-loader" aria-live="polite"
            style="display:none;position:fixed;z-index:9999;top:0;left:0;width:100vw;height:100vh;background:rgba(255,255,255,0.6);align-items:center;justify-content:center;">
            <div style="display:flex;align-items:center;justify-content:center;height:100%;">
                <img src="{{ $logoUrl }}" alt="Cargando..."
                    style="width:80px; height:auto; animation: spin 1.2s linear infinite;">
            </div>
        </div>

        <style>
        @keyframes spin {
            0% { transform: rotate(0deg);}
            100% { transform: rotate(360deg);}
        }
        </style>

        <div id="feedback-message" role="alert" aria-live="assertive"
            style="display:none;position:fixed;z-index:10000;top:20px;right:20px;padding:12px 24px;border-radius:8px;font-size:1rem;">
        </div>
    @endsection

    @section('modal')
        <div id="contModal"></div>
    @endsection

    @section('script')
        <script>
        $(function() {
            // === UTILIDADES ===
            const $loader = $('#main-loader');
            const $feedback = $('#feedback-message');

            function showLoader() { $loader.fadeIn(100); }
            function hideLoader() { $loader.fadeOut(100); }
            function showFeedback(msg, isError = false) {
                $feedback
                    .css({
                        background: isError ? '#ffdddd' : '#e6ffe6',
                        color: isError ? '#d9534f' : '#28a745'
                    })
                    .text(msg)
                    .stop(true, true)
                    .fadeIn(200)
                    .delay(2400)
                    .fadeOut(800);
            }
            // Utilidad para AJAX centralizado
            function genericAjax({url, data = {}, type = 'GET', success, errorMsg = 'Ocurrió un error.'}) {
                showLoader();
                $.ajax({
                    url,
                    type,
                    data,
                    success,
                    error: function() { showFeedback(errorMsg, true); },
                    complete: hideLoader
                });
            }
            // Opciones dinámicas para select
            function renderOptions(dataArray, valueKey, textKey) {
                let options = '<option></option>';
                dataArray.forEach(item => {
                    options += `<option value="${item[valueKey]}">${item[textKey]}</option>`;
                });
                return options;
            }

            // === INICIALIZACIÓN DE SELECT2 ===
            $('#filtro_sede_id, #filtro_equipo_id, #filtro_user_id').select2({
                placeholder: 'Seleccionar',
                allowClear: true
            });

            // === FILTROS EN CASCADA ===
            $('#filtro_sede_id').change(function() {
                const sedeId = $(this).val();
                if (sedeId) {
                    genericAjax({
                        url: `{{ url('cliente-gestion') }}/${sedeId}`,
                        data: { view: 'show-select-sede' },
                        success: function(data) {
                            $('#filtro_equipo_id').html(renderOptions(data.equipos, 'id', 'nombre'));
                            $('#filtro_user_id').html(renderOptions(data.users, 'id', 'name'));
                            filtroAutomatico();
                        }
                    });
                } else {
                    filtroAutomatico();
                }
            });

            $('#filtro_equipo_id').change(function() {
                const equipoId = $(this).val();
                const sedeId = $('#filtro_sede_id').val();
                if (equipoId) {
                    genericAjax({
                        url: `{{ url('cliente-gestion') }}/${equipoId}`,
                        data: { view: 'show-select-equipo', sede_id: sedeId },
                        success: function(data) {
                            $('#filtro_user_id').html(renderOptions(data.users, 'id', 'name'));
                            filtroAutomatico();
                        }
                    });
                } else {
                    genericAjax({
                        url: `{{ url('cliente-gestion/0') }}`,
                        data: { view: 'show-select-user', sede_id: sedeId },
                        success: function(data) {
                            $('#filtro_user_id').html(renderOptions(data.users, 'id', 'name'));
                            filtroAutomatico();
                        }
                    });
                }
            });

            // === FILTRAR TABLA AUTOMÁTICO (aún recarga página, puedes hacer AJAX si lo prefieres) ===
            function filtroAutomatico() {
                const params = {
                    filtro_etapa_id: $('#filtro_etapa_id').val(),
                    filtro_sede_id: $('#filtro_sede_id').val(),
                    filtro_equipo_id: $('#filtro_equipo_id').val(),
                    filtro_user_id: $('#filtro_user_id').val(),
                    filtro_fecha_desde: $('#filtro_fecha_desde').val(),
                    filtro_fecha_hasta: $('#filtro_fecha_hasta').val(),
                    filtro_ruc: $('#filtro_ruc').val(),
                    paginate: $('#paginate').val()
                };
                window.location.href = `/cliente-gestion?${$.param(params)}`;
            }

            // === MODAL DETALLE Y CREAR ===
            window.detalleCliente = function(cliente_id) {
                genericAjax({
                    url: `{{ url('cliente-gestion') }}/${cliente_id}/edit`,
                    data: { view: 'edit-detalle' },
                    success: function(result) {
                        $('#contModal').html(result);
                        openModal();
                    }
                });
            };
            window.closeFicha = function() {
                closeModal();
                location.reload();
            };

            window.selectFiltroEtapa = function(etapa_id = 0) {
                $('#contenedor_filtro_etapas button').css("opacity", 1);
                $('#etapa_' + etapa_id).css("opacity", 0.7);
                $('#filtro_etapa_id').val(etapa_id);
                filtroAutomatico();
            };
            // Color etapa seleccionada
            const filtro_etapa_id = $('#filtro_etapa_id').val();
            $('#etapa_' + filtro_etapa_id).css({ color: '#fff', zoom: '1.1', fontSize: '1.2rem' });

            $('#btnAgregarCliente').on('click', function() {
                genericAjax({
                    url: `{{ url('cliente/create') }}`,
                    data: { view: 'create' },
                    success: function(result) {
                        $('#contModal').html(result);
                        openModal();
                    }
                });
            });

            // Selección masiva y asignación
            $(document).on('change', '#selectAllClients', function() {
                $('tbody .form-check-input').prop('checked', this.checked);
            });
            $(document).on('click', '#btnAssignClients', function() {
                const selectedClients = [];
                $('tbody .form-check-input:checked').each(function() {
                    selectedClients.push(this.value);
                });
                if (selectedClients.length === 0) {
                    showFeedback('Seleccione un cliente, ¡Por favor!', true);
                } else {
                    genericAjax({
                        url: `{{ url('cliente-gestion/0/edit') }}`,
                        data: { view: 'edit-asignar', clients: selectedClients },
                        success: function(result) {
                            $('#contModal').html(result);
                            openModal();
                        }
                    });
                }
            });

            // Exportar CSV
            window.exportFunnel = function(empresa) {
                let filtro = $('#data_filtro').val();
                showLoader();
                $.ajax({
                    url: `/export/${empresa}/funnel`,
                    method: "POST",
                    data: { filtro: filtro },
                    xhrFields: { responseType: 'blob' },
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function(data) {
                        let blob = new Blob([data], { type: 'text/csv' });
                        let link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        link.download = 'IndotechFunnelExport.csv';
                        link.click();
                        showFeedback('Archivo exportado correctamente.');
                    },
                    error: function() {
                        showFeedback('Error al exportar el archivo.', true);
                    },
                    complete: hideLoader
                });
            };
            // Exportar Excel clásico
            window.exportCliente = function() {
                let filtro = $('#data_filtro').val();
                window.location.href = "/clientes/export?filtro=" + filtro;
            };
        });
        </script>
    @endsection
@endcan
