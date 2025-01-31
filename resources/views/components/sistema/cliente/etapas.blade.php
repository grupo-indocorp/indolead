@props([
    'botonHeader' => '',
    'botonFooter' => '',
])
<x-sistema.card class="m-0 p-0">
    <div class="d-flex flex-row flex-wrap justify-content-between">
        <x-sistema.titulo title="Etapa *" />
        <div class="flex flex-row gap-2">
            {{ $botonHeader }}
        </div>
    </div>
    <div class="form-group">
        <select class="block px-2.5 pb-1.5 pt-1.5 w-full text-xs text-[#333333] bg-[#F1F5F9] rounded-lg border-1 border-[#D1D5DB] appearance-none peer" id="etapa_id">
            <option></option>
            @foreach ($etapas as $value)
                <option value="{{ $value->id }}">{{ $value->nombre }}</option>
            @endforeach
        </select>
        {{-- <div class="flex flex-col items-center">
            @php $width = 100; @endphp
            @foreach ($etapas as $value)
                @php $width -= 5; @endphp
                <div class="p-2 rounded text-center font-medium" style="background-color: {{ $value->opacity }}; width: {{ $width }}%;" id="{{ $value->id }}">{{ $value->nombre }}</div>
            @endforeach
        </div> --}}
    </div>
    {{ $botonFooter }}
</x-sistema.card>
