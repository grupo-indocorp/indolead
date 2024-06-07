<a href="{{ $url }}" {{ $attributes->merge(['class' => 'bg-slate-900 text-slate-100 hover:text-orange-400 rounded-xl font-bold px-4 py-2']) }}>
    {{ $slot }}
</a>