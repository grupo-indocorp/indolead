@props(['value'])

<h5 {{ $attributes->merge(['class' => 'text-2xl text-slate-700 uppercase font-bold tracking-wider']) }}>
    {{ $value ?? $slot }}
</h5>
