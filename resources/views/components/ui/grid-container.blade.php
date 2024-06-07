{{--
    Contenedor Grid - Modelo 1
    | 1  1 | 2   2 |
    | 1  1 | 3 | 4 |
    Requiere, el contenido de 4 elementos o contenedores
--}}
<section {{ $attributes->merge(['class' => 'w-full h-full grid grid-cols-1 xl:grid-cols-4 xl:grid-rows-2 gap-2 p-4']) }}>
    {{ $slot }}
</section>
