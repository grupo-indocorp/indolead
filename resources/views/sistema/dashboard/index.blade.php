@extends('layouts.app')

@can('sistema.dashboard')
    @section('content')
        <!-- Dependencias CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

        <div class="container-fluid p-1">
            @if($fechaSeleccionada || $equipoSeleccionado || $ejecutivoSeleccionado)
                <div class="mb-3 p-3" style="background: white; border: 1px solid #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                    <span class="text-muted me-2" style="font-weight: 500;">Filtros aplicados:</span>
                    @if($equipoSeleccionado)
                        <span class="badge rounded-pill me-2" style="background: #6c757d; color: white; padding: 8px 12px;">
                            <i class="fas fa-users me-1"></i>
                            {{ $equipos->find($equipoSeleccionado)->nombre }}
                        </span>
                    @endif
                    @if($ejecutivoSeleccionado)
                        <span class="badge rounded-pill me-2" style="background: #6c757d; color: white; padding: 8px 12px;">
                            <i class="fas fa-user-tie me-1"></i>
                            {{ $ejecutivos->find($ejecutivoSeleccionado)->name }}
                        </span>
                    @endif
                    @if($fechaSeleccionada)
                        <span class="badge rounded-pill me-2" style="background: #6c757d; color: white; padding: 8px 12px;">
                            <i class="fas fa-calendar-alt me-1"></i>
                            {{ $fechaSeleccionada->format('m/Y') }}
                        </span>
                    @endif
                </div>
            @endif

            <div class="row">
                <!-- Sección Filtros -->
                <div class="col-md-2 d-flex flex-column pe-0">
                    <div class="shadow-sm mb-3" style="background-color: #ffffff; padding: 5px; border-radius: 10px; border: 1px solid #ddd;">
                        <div class="card-body p-3">
                            <h5 class="card-title mb-3 text-muted fw-medium">
                                <i class="fas fa-filter me-2"></i>Filtros
                            </h5>
                            <form method="GET" action="{{ route('dashboard') }}" id="autoSubmitForm">
                                <!-- Equipo -->
                                <div class="mb-2">
                                    <label class="form-label text-muted mb-1 fs-6">Equipo</label>
                                    <select name="equipo" id="equipo" class="form-select fs-6">
                                        <option value="">Todos</option>
                                        @foreach($equipos as $equipo)
                                            <option value="{{ $equipo->id }}" {{ $equipoSeleccionado == $equipo->id ? 'selected' : '' }}>
                                                {{ $equipo->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <!-- Ejecutivo -->
                                <div class="mb-2">
                                    <label class="form-label text-muted mb-1 fs-6">Ejecutivo</label>
                                    <select name="ejecutivo" id="ejecutivo" class="form-select fs-6">
                                        <option value="">Todos</option>
                                        @if($equipoSeleccionado)
                                            @foreach($ejecutivos as $ej)
                                                <option value="{{ $ej->id }}" {{ $ejecutivoSeleccionado == $ej->id ? 'selected' : '' }}>
                                                    {{ $ej->name }}
                                                </option>
                                            @endforeach
                                        @else
                                            <option value="" disabled class="small">Seleccione un equipo</option>
                                        @endif
                                    </select>
                                </div>
                                
                                <!-- Selector de Fecha -->
                                <div class="mb-2">
                                    <label class="form-label text-muted mb-1 fs-6">Periodo</label>
                                    <div class="input-group">
                                        <input type="text" 
                                            class="form-control datepicker fs-6" 
                                            name="fecha"
                                            value="{{ $fechaSeleccionada ? $fechaSeleccionada->format('m/Y') : '' }}"
                                            placeholder="MM/AAAA"
                                            autocomplete="off">
                                        <span class="input-group-text bg-white">
                                            <i class="fas fa-calendar-alt text-muted"></i>
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Limpiar filtros -->
                                <div class="text-center mt-2">
                                    <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-secondary w-100">
                                        <i class="fas fa-times me-1"></i>Limpiar filtros
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Métricas -->
                    <div class="shadow-sm mb-3" style="background-color: #ffffff; padding: 5px; border-radius: 10px; border: 1px solid #ddd;">
                        <div class="card-body p-3">
                            <h5 class="card-title mb-2 text-muted fw-medium">
                                <i class="fas fa-chart-line me-2"></i>Métricas
                            </h5>
                            
                            <div class="d-grid gap-2">
                                <!-- Total Clientes -->
                                <div class="metric-item p-2 bg-light rounded-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-muted mb-1 fs-6">Total Clientes</span>
                                        <strong class="text-dark">{{ $totalClientes }}</strong>
                                    </div>
                                </div>
                    
                                <!-- Etapa Cinco -->
                                <div class="metric-item p-2 bg-light rounded-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-muted mb-1 fs-6"">{{ $etapaCinco->nombre }}</span>
                                        <strong class="text-dark">{{ $clientesEnEtapaCinco }}</strong>
                                    </div>
                                </div>
                    
                                <!-- Convertibilidad -->
                                <div class="metric-item p-2 bg-light rounded-2">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="text-muted mb-1 fs-6"">Convertibilidad</span>
                                        <strong class="text-dark">{{ $convertibilidad }}%</strong>
                                    </div>
                                    <div class="progress" style="height: 4px;">
                                        <div class="progress-bar bg-success" style="width: {{ $convertibilidad }}%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gráficos -->
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <div class="shadow-sm mb-3" style="background-color: #ffffff; padding: 5px; border-radius: 10px; border: 1px solid #ddd;">
                                <div class="card-body">
                                    <h5 class="card-title text-muted"><i class="fas fa-chart-pie me-1"></i> Distribución por Etapas</h5>
                                    <div class="mt-3">
                                        {!! $chart->container() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <div class="shadow-sm mb-3" style="background-color: #ffffff; padding: 5px; border-radius: 10px; border: 1px solid #ddd;"> <!-- Ajuste aquí -->
                                <div class="card-body">
                                    <h5 class="card-title text-muted"><i class="fas fa-percentage me-1"></i> Tasa de Conversión</h5>
                                    <div class="mt-3">
                                        {!! $conversionChart->container() !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.es.min.js"></script>
        
        <script>
            // Inicializar Datepicker
            $('.datepicker').datepicker({
                language: 'es',
                format: 'mm/yyyy',
                startView: 'months',
                minViewMode: 'months',
                autoclose: true
            }).on('changeDate', function(e) {
                $('#autoSubmitForm').submit();
            });

            // Enviar el formulario al cambiar el ejecutivo
            document.getElementById('ejecutivo').addEventListener('change', function() {
                document.getElementById('autoSubmitForm').submit();
            });

            // Limpiar ejecutivo y enviar el formulario al cambiar el equipo
            document.getElementById('equipo').addEventListener('change', function() {
                document.getElementById('ejecutivo').value = ''; // Limpiar el ejecutivo
                document.getElementById('autoSubmitForm').submit(); // Enviar el formulario
            });
        </script>

        {{ $chart->script() }}
        {{ $conversionChart->script() }}

        <style>
            /* Asegúrate de que los gráficos tengan bordes suaves */
            .apexcharts-slice {
                stroke-linejoin: round; /* Bordes redondeados */
                stroke-width: 0; /* Elimina el borde */
            }

            /* Ajusta el contenedor del gráfico */
            .apexcharts-canvas {
                border-radius: 8px; /* Bordes redondeados para el contenedor */
                overflow: hidden; /* Evita que los bordes se vean afuera */
            }

            .card {
                transition: transform 0.2s, box-shadow 0.2s;
            }
            
            .card:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            }
            
            .form-control:focus, .form-select:focus {
                border-color: #6c757d;
                box-shadow: 0 0 0 2px rgba(108,117,125,0.2);
            }
        </style>
    @endsection
@endcan