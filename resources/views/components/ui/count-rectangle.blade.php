<section {{ $attributes->merge(['class' => 'w-[35px] h-[25px] bg-blue-200 text-blue-600 text-base font-extrabold border-2 border-blue-200 flex justify-center items-center rounded-lg']) }} data-bs-toggle="tooltip" data-bs-original-title="{{ $toggle }}">
    {{ $slot }}
</section>
