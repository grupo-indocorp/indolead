@props(['value'])

<h2 {{ $attributes->merge(['class' => 'text-7xl text-white uppercase font-extralight tracking-wider']) }}>
    {{ $value ?? $slot }}
</h2>
