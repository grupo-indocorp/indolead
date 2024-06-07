<button {{ $attributes->merge(['class' => 'bg-slate-900 text-slate-100 hover:text-sky-300 rounded-xl font-semibold px-4 py-2']) }}>
    {{ $slot }}
</button>