@props([
    'botonHeader' => '',
    'botonFooter' => '',
    'comentarios' => false,
])
<x-sistema.card class="m-2">
    <!-- Encabezado -->
    <div class="d-flex flex-row flex-wrap justify-content-between">
        <x-sistema.titulo title="Comentarios *" />
        <div class="flex flex-row gap-2">
            {{ $botonHeader }}
        </div>
    </div>

    <!-- Área de texto para nuevos comentarios (solo para ejecutivos) -->
    @role('ejecutivo')
    <div class="form-group mb-4">
        <textarea class="form-control" rows="3" id="comentario" name="comentario" placeholder="Escribe tu comentario..."></textarea>
    </div>
    @endrole

    <!-- Botón de pie de página -->
    {{ $botonFooter }}

    <!-- Lista de comentarios -->
    <div class="flex-auto" id="comentarios">
        @if ($comentarios)
            @foreach ($comentarios as $comentario)
                <div class="mb-4 p-4 bg-white rounded-lg shadow-sm">
                    <!-- Contenido del comentario -->
                    <div class="flex justify-between items-start mb-4">
                        <span class="text-base font-semibold text-slate-900">{{ $comentario['comentario'] }}</span>
                    </div>

                    <!-- Detalles del comentario -->
                    <div class="flex flex-wrap justify-end gap-2 text-sm">
                        <!-- Usuario -->
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-lg">
                            <i class="text-blue-400 fa-solid fa-user"></i> {{ $comentario['usuario'] }}
                        </span>

                        <!-- Etiqueta -->
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded-lg">
                            <i class="text-green-400 fa-solid fa-tag"></i> {{ $comentario['etiqueta'] }}
                        </span>

                        <!-- Detalle adicional -->
                        <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded-lg">
                            <i class="text-purple-400 fa-solid fa-info-circle"></i> {{ $comentario['detalle'] }}
                        </span>
                        <!-- Detalle fecha -->
                        <span class="px-2 py-1 text-slate-600">
                            <i class="text-blue-400 fa-solid fa-calendar-days"></i> {{ $comentario['fecha'] }}
                        </span>
                    </div>
                </div>
            @endforeach
        @else
            <p class="text-gray-500 text-center py-4">No hay comentarios para mostrar.</p>
        @endif
    </div>
</x-sistema.card>