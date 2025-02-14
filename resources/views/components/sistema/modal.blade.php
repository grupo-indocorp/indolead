@props([
    'title' => '',
    'dialog_id' => 'dialog',
    'onclickCloseModal' => 'closeModal()',
])
<dialog {{ $attributes->merge(['id' => $dialog_id, 'class' => 'rounded-lg p-2 w-[95vw] max-w-5xl']) }}>
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

