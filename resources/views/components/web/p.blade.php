@props(['value'])

<p {{ $attributes->merge(['class' => 'text-xl tracking-widest leading-normal']) }}>
    {{ $value ?? $slot }}
</p>
