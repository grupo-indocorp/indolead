@props([
    'botonHeader' => '',
    'botonFooter' => '',
    'notificacion' => false,
])
<x-sistema.card>
    <div class="relative mb-3 d-flex flex-row flex-wrap justify-content-between">
        <x-sistema.titulo title="Agenda *" />
        <div class="flex flex-row gap-2">
            {{ $botonHeader }}
        </div>
    </div>
    <div class="relative mb-3">
        <label for="notificaciontipo_id" class="absolute text-sm text-[#333333] duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-[#F1F5F9] px-2">
            Tipo de Agenda
        </label>
        <select
            id="notificaciontipo_id"
            name="notificaciontipo_id"
            class="inline-block px-4 pb-1.5 pt-1.5 text-xs text-[#333333] bg-[#F1F5F9] rounded-lg border border-[#D1D5DDB] appearance-none"
            style="text-align: left; text-align-last: left;"
        >
            @foreach ($notificaciontipos as $value)
                <option value="{{ $value->id }}">{{ $value->nombre }}</option>
            @endforeach
        </select>
    </div>
    
    
    <div class="relative mb-3">
        <label for="mensaje" class="absolute text-sm text-gray-600 duration-300 transform -translate-y-4 scale-75 top-2 left-0 z-10 origin-[0] px-0.5 py-0.5 peer-focus:text-blue-600 peer-focus:text-sm peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-100 peer-focus:-translate-y-4 bg-[#F1F5F9]">Mensaje</label>
        <textarea class="form-control" rows="3" id="mensaje" name="mensaje"></textarea>
    </div>
    <div class="relative mb-1">
        <label for="fecha" class="absolute text-sm text-gray-600 duration-300 transform -translate-y-4 scale-75 top-2 left-0 z-10 origin-[0] px-0.5 py-0.5 peer-focus:text-blue-600 peer-focus:text-sm peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-100 peer-focus:-translate-y-4 bg-[#F1F5F9]">Fecha y Hora</label>
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


