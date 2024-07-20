@props(['value'])

<h1 {{ $attributes->merge(['class' => 'uppercase font-bold text-xl tracking-wider']) }}>
    {{ $value ?? $slot }}
</h1>
