@extends('layouts.app')

@can('sistema.dashboard')
    @section('content')
        <div class="container-fluid">
            <div class="row">
                <!-- Contenedor de filtros y segundo gráfico -->
                <div class="col-md-3 d-flex flex-column" style="padding: 0;">
                    <!-- Sección de filtros -->
                    <div class="flex-grow-1" style="background-color: #fff; padding: 20px; border-radius: 10px; border: 1px solid #ddd; margin: 10px;">
                        <div class="w-100 h-100">
                            <h4>Filtros</h4>
                            <form method="GET" action="{{ route('dashboard') }}" id="filtersForm">
                                <div class="form-group">
                                    <label for="equipo">Filtrar por Equipo:</label>
                                    <select name="equipo" id="equipo" class="form-control" onchange="document.getElementById('filtersForm').submit();">
                                        <option value="">Todos los equipos</option>
                                        @foreach($equipos as $equipo)
                                            <option value="{{ $equipo->id }}" {{ $equipoSeleccionado == $equipo->id ? 'selected' : '' }}>
                                                {{ $equipo->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="ejecutivo">Filtrar por Ejecutivo:</label>
                                    <select name="ejecutivo" id="ejecutivo" class="form-control" onchange="document.getElementById('filtersForm').submit();">
                                        <option value="">Todos los ejecutivos</option>
                                        @foreach($ejecutivos as $ej)
                                            <option value="{{ $ej->id }}" {{ $ejecutivoSeleccionado == $ej->id ? 'selected' : '' }}>
                                                {{ $ej->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="mes">Filtrar por Mes:</label>
                                    <select name="mes" id="mes" class="form-control" onchange="document.getElementById('filtersForm').submit();">
                                        <option value="">Todos los meses</option>
                                        @foreach($meses as $mesClave => $mesNombre)
                                            <option value="{{ $mesClave }}" {{ $mesSeleccionado == $mesClave ? 'selected' : '' }}>
                                                {{ $mesNombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Sección del gráfico 2 (debajo de los filtros) -->
                    <div class="flex-grow-1" style="background-color: #fff; padding: 20px; border-radius: 10px; border: 1px solid #ddd; margin: 10px;">
                        <div class="w-100 h-100">
                            <div class="d-flex justify-content-between">
                                <h4>Total de Clientes</h4>
                                <span style="font-size: 24px; font-weight: bold;">{{ $totalClientes }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h4>{{ $etapaCinco->nombre }}</h4>
                                <span style="font-size: 24px; font-weight: bold;">{{ $clientesEnEtapaCinco }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h4>Convertibilidad</h4>
                                <span style="font-size: 24px; font-weight: bold;">{{ $convertibilidad }}%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sección del gráfico 1 -->
                <div class="col-md-5" style="background-color: #fff; padding: 20px; border-radius: 10px; border: 1px solid #ddd; margin: 10px;">
                    <div class="w-100 h-100" style="height: calc(100vh - 40px);">
                        <div id="chart" class="h-100">
                            {!! $chart->container() !!}
                        </div>
                    </div>
                </div>

                <!-- Sección del gráfico 3 -->
                <div class="col-md-3" style="background-color: #fff; padding: 20px; border-radius: 10px; border: 1px solid #ddd; margin: 10px;">
                    <div class="w-100 h-100" style="height: calc(100vh - 40px);">
                        <div id="conversion-chart" class="h-100">
                            {!! $conversionChart->container() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scripts de Larapex Charts -->
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        {{ $chart->script() }}
        {{ $conversionChart->script() }}
    @endsection
@endcan
