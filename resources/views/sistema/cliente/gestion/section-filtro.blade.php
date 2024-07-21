<div class="w-full flex flex-col py-2 gap-4">
    <div id="contenedor_filtro_etapas">
        @php
            $title_todo = 'Todo ('.$count_total.')';
        @endphp
        <x-sistema.boton :title="$title_todo" style="background-color: #f16731" class="text-slate-900 rounded-md px-2 py-1 m-1 font-bold hover:cursor-pointer hover:bg-slate-300 hover:text-slate-900" onclick="selectFiltroEtapa()" id="etapa_0" />
        @php
            $total = 0;
        @endphp
        @foreach ($data_etapas as $item)
        @php
            $title = $item['nombre'].'('.$item['clientes_solo_count'].')';
            $total += $item['clientes_solo_count'];
        @endphp
            <x-sistema.boton :$title style="background-color: {{ $item['color'] }};"
                class="text-slate-900 rounded-md px-2 py-1 m-1 font-bold hover:cursor-pointer hover:bg-slate-300 hover:text-slate-900"
                onclick="selectFiltroEtapa({{ $item['id'] }})" id="etapa_{{ $item['id'] }}" />
        @endforeach
    </div>
    <form action="{{ route('cliente-gestion.index') }}" method="GET" class="m-0">
        <div class="w-full flex justify-between">
            <div class="flex flex-col">
                <div class="flex gap-1">
                    <div class="form-group">
                        <input type="hidden" name="filtro_etapa_id" id="filtro_etapa_id" value="{{ request('filtro_etapa_id') ?? 0 }}">
                    </div>
                    @role(['sistema', 'gerente general', 'gerente comercial', 'asistente comercial', 'capacitador', 'planificacion'])
                        <div class="form-group flex flex-col">
                    @else
                        <div class="form-group flex flex-col" style="display: none;">
                    @endrole
                            <label for="filtro_sede_id" class="form-control-label">Sede:</label>
                            <select class="form-control" name="filtro_sede_id" id="filtro_sede_id" style="width: 250px;">
                                <option></option>
                                @foreach ($sedes as $item)
                                    <option value="{{ $item->id }}" @if ($item->id == request('filtro_sede_id')) selected @endif>{{ $item->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    @role(['sistema', 'gerente general', 'gerente comercial', 'asistente comercial', 'jefe comercial', 'capacitador', 'planificacion'])
                        <div class="form-group flex flex-col">
                    @else
                        <div class="form-group flex flex-col" style="display: none;">
                    @endrole
                            <label for="filtro_equipo_id" class="form-control-label">Equipos:</label>
                            <select class="form-control" name="filtro_equipo_id" id="filtro_equipo_id" style="width: 250px;">
                                <option></option>
                                @foreach ($equipos as $item)
                                    <option value="{{ $item->id }}" @if ($item->id == request('filtro_equipo_id')) selected @endif>{{ $item->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    @role(['sistema', 'gerente general', 'gerente comercial', 'asistente comercial', 'jefe comercial', 'supervisor', 'capacitador', 'planificacion'])
                        <div class="form-group flex flex-col">
                    @else
                        <div class="form-group flex flex-col" style="display: none;">
                    @endrole
                            <label for="filtro_user_id" class="form-control-label">Ejecutivo:</label>
                            <select class="form-control" name="filtro_user_id" id="filtro_user_id" onchange="filtroAutomatico()"  style="width: 250px;">
                                <option></option>
                                @foreach ($users as $item)
                                    <option value="{{ $item->id }}" @if ($item->id == request('filtro_user_id')) selected @endif>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                </div>
                <div class="flex gap-1">
                    <div class="form-group">
                        <label for="filtro_fecha_desde" class="form-control-label">Desde:</label>
                        <input class="form-control" type="date" value="{{ request('filtro_fecha_desde') }}" id="filtro_fecha_desde" name="filtro_fecha_desde" onchange="filtroAutomatico()" >
                    </div>
                    <div class="form-group">
                        <label for="filtro_fecha_hasta" class="form-control-label">Hasta:</label>
                        <input class="form-control" type="date" value="{{ request('filtro_fecha_hasta') }}" id="filtro_fecha_hasta" name="filtro_fecha_hasta" onchange="filtroAutomatico()" >
                    </div>
                </div>
            </div>
            <div class="flex gap-2 items-center">
                @role (['ejecutivo'])
                    <div class="flex gap-4">
                        <div class="flex flex-col items-center">
                            <span class="text-blue-600 text-base font-bold">Nuevos</span>
                            <x-ui.count-rectangle>
                                <x-slot:toggle>Clientes Nuevos</x-slot>
                                {{ $countClienteNuevo }}
                            </x-ui.count-rectangle>
                        </div>
                        <div class="flex flex-col items-center">
                            <span class="text-blue-600 text-base font-bold">Gestionados</span>
                            <x-ui.count-rectangle>
                                <x-slot:toggle>Clientes Gestionados</x-slot>
                                {{ $countClienteGestionado }}
                            </x-ui.count-rectangle>
                        </div>
                    </div>
                @endrole
                <div class="form-group">
                    <label for="filtro_ruc" class="form-control-label">Ruc:</label>
                    <input class="form-control" type="search" value="{{ request('filtro_ruc') }}" id="filtro_ruc" name="filtro_ruc" placeholder="Buscar por RUC">
                </div>
            </div>
        </div>
        {{-- <button type="submit" class="btn bg-gradient-info m-0">Aplicar Filtros</button> --}}
        @can('sistema.gestion_cliente.asignar')
            <a href="javascript:;" class="btn bg-gradient-warning m-0" id="btnAssignClients" type="button">Asignar</a>
        @endcan
        @can('sistema.gestion_cliente.exportar')
            @if ($config['excel']['indotech'])
                <a href="javascript:;" class="btn bg-gradient-primary m-0" onclick="exportCliente()" type="button">Descargar</a>
                <a href="javascript:;" class="btn bg-gradient-primary m-0" onclick="exportFunnel('indotech')" type="button">Funnel Indotech</a>
            @endif
            @if ($config['excel']['secodi'])
                <a href="javascript:;" class="btn bg-gradient-primary m-0" onclick="exportFunnel('secodi')" type="button">Funnel Secodi</a>
            @endif
        @endcan
    </form>
</div>
