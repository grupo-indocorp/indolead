@props(['value'])

<h2 {{ $attributes->merge(['class' => 'text-7xl uppercase font-extralight tracking-wider']) }}>
    {{ $value ?? $slot }}
</h2>
