@props([
    'etapas' => [], 
    'botonHeader' => '',
    'botonFooter' => '',
])
<x-sistema.card class="m-0 p-0">
    <div class="relative mb-1 d-flex flex-row flex-wrap justify-content-between">
        <x-sistema.titulo title="Etapa" />
        <div class="flex flex-row gap-2">
            {{ $botonHeader }}
        </div>
    </div>
    <div class="form-grup">
        <select id="etapa_id" class="block px-2.5 pb-1.5 pt-1.5 w-full text-xs text-[#333333] bg-[#F1F5F9] rounded-lg border-1 border-[#D1D5DB] appearance-none peer">
            <option value="">Seleccione una etapa</option>
            @foreach ($etapas as $value)
                <option value="{{ $value->id }}">{{ $value->nombre }}</option>
            @endforeach
        </select>
    </div>
    {{ $botonFooter }}
</x-sistema.card>
