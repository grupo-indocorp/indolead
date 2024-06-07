@props([
    'title' => '',
    'dialog_id' => 'contenedor-dialog',
    'onclickCloseModal' => 'closeModal()',
])
<dialog class="rounded-lg p-4" style="width: 95vw; min-width: 800px; max-width: 95vw" id="{{ $dialog_id }}">
    <div class="flex justify-between">
        <h5 class="uppercase text-sm font-bold">{{ $title }}</h5>
        <button class="text-red-500 text-2xl" onclick="{{ $onclickCloseModal }}">
            <i class="fa-solid fa-rectangle-xmark"></i>
        </button>
    </div>
    <div class="bg-gray-100 rounded-lg p-2">
        {{ $slot }}
    </div>
</dialog>
