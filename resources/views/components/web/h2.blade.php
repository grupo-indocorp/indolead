@props(['value'])

<h2 {{ $attributes->merge(['class' => 'text-6xl text-slate-950 uppercase font-ligth tracking-wider']) }}>
    {{ $value ?? $slot }}
</h2>
