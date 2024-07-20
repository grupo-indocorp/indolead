@props(['value'])

<h3 {{ $attributes->merge(['class' => 'text-3xl text-slate-700 uppercase font-bold tracking-wider']) }}>
    {{ $value ?? $slot }}
</h3>
