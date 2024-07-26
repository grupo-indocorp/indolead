@props(['value'])

<p {{ $attributes->merge(['class' => 'w-full text-lg md:text-xl tracking-widest leading-normal']) }}>
    {{ $value ?? $slot }}
</p>
