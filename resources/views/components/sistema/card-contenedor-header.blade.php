<div class="p-4 pb-0">
    <div class="d-flex flex-row flex-wrap justify-content-between">
        <x-sistema.titulo :$title />
        <div class="flex flex-row gap-2">
            {{ $slot }}
        </div>
    </div>
</div>