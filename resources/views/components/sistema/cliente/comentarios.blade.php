@props([
    'botonHeader' => '',
    'botonFooter' => '',
    'comentarios' => false,
])
<x-sistema.card class="m-2">
    <div class="d-flex flex-row flex-wrap justify-content-between">
        <x-sistema.titulo title="Comentarios *" />
        <div class="flex flex-row gap-2">
            {{ $botonHeader }}
        </div>
    </div>
    @role('ejecutivo')
    <div class="form-group">
        <textarea class="form-control" rows="3" id="comentario" name="comentario"></textarea>
    </div>
    @endrole
    {{ $botonFooter }}
    <div class="flex-auto" id="comentarios">
        @if ($comentarios)
            @foreach ($comentarios as $comentario)
                <div class="mb-4" id="{{ $comentario['id'] }}">
                    <span class="text-slate-900 text-base font-semibold">{{ $comentario['comentario'] }}</span>
                    <div class="text-end">
                        <span class="text-slate-500 text-xs uppercase me-2">
                            <i class="text-blue-400 fa-solid fa-user"></i> {{ $comentario['usuario'] }}
                        </span>
                        <span class="text-slate-500 text-sm">
                            <i class="text-blue-400 fa-solid fa-calendar-days"></i> {{ $comentario['fecha'] }}
                        </span>
                        <span class="bg-slate-300 text-slate-700 text-xs font-semibold font-se mb-0 mx-1 px-3 py-1 rounded-lg">
                            {{ $comentario['etiqueta'] }}
                        </span>
                        <span class="bg-slate-300 text-slate-700 text-xs font-semibold font-se mb-0 mx-1 px-3 py-1 rounded-lg">
                            {{ $comentario['detalle'] }}
                        </span>
                    </div>
                </div>
                <hr>
            @endforeach
        @endif
    </div>
</x-sistema.card>
