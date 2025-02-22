@props([
    'botonHeader' => '',
    'botonFooter' => '',
    'notificacion' => false,
])
<x-sistema.card class="m-2 mb-4 mx-0">
    <div class="d-flex flex-row flex-wrap justify-content-between">
        <x-sistema.titulo title="Agenda *" />
        <div class="flex flex-row gap-2">
            {{ $botonHeader }}
        </div>
    </div>
    <div class="form-group">
        <label for="notificaciontipo_id" class="form-control-label">Tipo de Agenda</label>
        <select class="form-control" id="notificaciontipo_id" name="notificaciontipo_id">
            @foreach ($notificaciontipos as $value)
                <option value="{{ $value->id }}">{{ $value->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="mensaje" class="form-control-label">Mensaje</label>
        <textarea class="form-control" rows="3" id="mensaje" name="mensaje"></textarea>
    </div>
    <div class="form-group">
        <label for="fecha" class="form-control-label">Fecha y Hora</label>
        <div class="row">
            <div class="col">
                <input class="form-control" type="date" value="{{ $fecha }}" id="fecha" name="fecha">
            </div>
            <div class="col">
                <input class="form-control" type="time" value="" id="hora" name="hora">
            </div>
        </div>
    </div>
    {{ $botonFooter }}
    <div class="flex-auto" id="notificacions">
        @if ($notificacion)
            @foreach ($notificacion as $item)
                <div class="mb-4" id="{{ $item->id }}">
                    <span class="text-slate-900 text-base font-semibold">{{ $item->asunto }}</span>
                    <div class="text-end">
                        <span class="text-slate-500 text-xs uppercase me-2">
                            <i class="text-blue-400 fa-solid fa-user"></i> {{ $item->user->name }}
                        </span>
                        <span class="text-slate-500 text-sm">
                            <i class="text-blue-400 fa-solid fa-calendar-days"></i> {{  now()->parse($item->fecha)->format('d-m-Y') }} {{ now()->parse($item->hora)->format(' h:i:s A') }}
                        </span>
                    </div>
                </div>
                <hr>
            @endforeach
        @endif
    </div>
</x-sistema.card>
