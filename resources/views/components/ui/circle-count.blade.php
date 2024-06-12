<section {{ $attributes->merge(['class' => 'w-[80px] h-[80px] bg-white text-orange-600 text-4xl font-extrabold border-8 border-orange-500 flex justify-center items-center rounded-full']) }} data-bs-toggle="tooltip" data-bs-original-title="{{ $toggle }}">
    {{ $slot }}
</section>