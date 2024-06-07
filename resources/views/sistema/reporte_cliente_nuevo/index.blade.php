@extends('layouts.app')

@section('content')
    <x-sistema.card-contenedor>
        <div class="p-4 pb-0">
            <div class="d-flex flex-row justify-content-between">
                <x-sistema.titulo title="Reporte de Clientes Nuevos"/>
                {{-- <a href="javascript:;" class="btn bg-gradient-primary m-0" onclick="agregarCliente()" type="button">Descargar</a> --}}
            </div>
            <div>
                <a href="javascript:;" onclick="filtroReporteClienteNuevo('desactive')" class="btn bg-gradient-warning">Mostrar EJECUTIVOS</a>
                <a href="javascript:;" onclick="filtroReporteClienteNuevo('active')" class="btn bg-gradient-danger">Mostrar Solo EQUIPOS</a>
                <div class="form-group">
                    <label for="filtro-mensual" class="form-control-label">Mes</label>
                    <input class="form-control" type="month" value="{{ $month }}" min="{{ $minMonth }}" max="{{ $currentMonth }}"
                        id="filtro-mensual" onchange="filtroReporteClienteNuevo()">
                </div>
            </div>
        </div>
        <div class="p-4">
            <div class="relative overflow-x-auto">
                <table class="w-full bg-white text-sm text-left text-slate-700 rounded-2xl">
                    <thead class="uppercase">
                        <tr>
                            <th class="border-b border-gray-700 p-2">Etiquetas de Fila</th>
                            @php $startOfMonthThead = $startOfMonth->copy(); $endOfMonthThead = $endOfMonth->copy(); @endphp
                            @while ($startOfMonthThead->lte($endOfMonthThead))
                                <th class="border-b border-gray-700 p-2">{{ $startOfMonthThead->day }}</th>
                                @php $startOfMonthThead->addDay(); @endphp
                            @endwhile
                            <th class="border-b border-gray-700 p-2">Total General</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($equipos as $equipo)
                            @php $totalClientePorEquipo_mensual = 0; @endphp
                            <tr>
                                <td class="font-bold p-2" style="background-color: #eecb31">{{ $equipo->nombre }}</td>
                                @php $startOfMonthTbody = $startOfMonth->copy(); $endOfMonthTbody = $endOfMonth->copy(); @endphp
                                @while ($startOfMonthTbody->lte($endOfMonthTbody))
                                    @php
                                        $totalClientePorEquipo_diario = 0;
                                        foreach ($equipo->users as $ejecutivo) {
                                            $clientesEjecutivo = App\Models\Cliente::where('user_id', $ejecutivo->id)->whereBetween('created_at', [$startOfMonthTbody->copy()->startOfDay(), $startOfMonthTbody->copy()->endOfDay()])->count();
                                            $totalClientePorEquipo_diario += $clientesEjecutivo;
                                        }
                                        $totalClientePorEquipo_mensual += $totalClientePorEquipo_diario;
                                    @endphp
                                    <td class="font-bold p-2" style="background-color: #eecb31">{{ $totalClientePorEquipo_diario }}</td>
                                    @php $startOfMonthTbody->addDay(); @endphp
                                @endwhile
                                <td class="font-bold p-2" style="background-color: #eecb31">{{ $totalClientePorEquipo_mensual }}</td>
                            </tr>
                            @if ($mostrarEjecutivos)
                                @foreach ($equipo->users as $ejecutivo)
                                    <tr>
                                        <td class="p-2">{{ $ejecutivo->name }}</td>
                                        @php $totalClientePorEjecutivo_mensual = 0; @endphp
                                        @php $startOfMonthTbody = $startOfMonth->copy(); $endOfMonthTbody = $endOfMonth->copy(); @endphp
                                        @while ($startOfMonthTbody->lte($endOfMonthTbody))
                                            @php
                                                $totalClientePorEjecutivo_diario = App\Models\Cliente::where('user_id', $ejecutivo->id)->whereBetween('created_at', [$startOfMonthTbody->copy()->startOfDay(), $startOfMonthTbody->copy()->endOfDay()])->count();
                                            @endphp
                                            <td class="p-2">{{ $totalClientePorEjecutivo_diario }}</td>
                                            @php $startOfMonthTbody->addDay(); @endphp
                                            @php $totalClientePorEjecutivo_mensual += $totalClientePorEjecutivo_diario; @endphp
                                        @endwhile
                                        <td class="p-2">{{ $totalClientePorEjecutivo_mensual }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </x-sistema.card-contenedor>
    <script>
        function filtroReporteClienteNuevo(text='desactive') {
            let mes = $('#filtro-mensual').val();
            let url = "{{ url('reporte_cliente_nuevo') }}";
            let fullUrl = url + '?mes=' + mes + '&mostrarEquipos=' + text;
            window.location.href = fullUrl;
        }
    </script>
@endsection