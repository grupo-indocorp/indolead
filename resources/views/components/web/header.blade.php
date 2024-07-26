<header class="bg-cover bg-no-repeat bg-center bg-opacity-10" style="background-image: url('{{ asset('img/background.png') }}')">
    <div class="w-full h-[100vh] bg-gradient-to-t from-transparent to-slate-900 absolute opacity-90"></div>
    <div class="w-full h-[200px] bg-gradient-to-t from-white to-transparent absolute left-0 bottom-0"></div>
    <div class="w-full h-[85px] fixed z-20 bg-slate-900 opacity-95 blur-sm"></div>
    <x-web.container class="fixed inset-x-px z-20 py-4 flex flex-row justify-between">
        <a href="{{ url('/') }}" class="flex gap-2 items-center text-white hover:text-blue-300">
            <x-web.logo class="w-[30px]" />
            <x-web.logo-text class="font-normal" :value="__('indotech')" />
        </a>
        <div class="hidden md:flex gap-4 items-center">
            <a href="#section-nosotros" class="uppercase font-medium text-white hover:text-blue-300">nosotros</a>
            <a href="#section-contratos" class="uppercase font-medium text-white hover:text-blue-300">postula</a>
            <a href="#section-empresa" class="uppercase font-medium text-white hover:text-blue-300">contacto</a>
            <a href="{{ url('login') }}" class="border-2 border-white rounded-md px-4 py-3 uppercase font-bold bg-white hover:bg-transparent hover:text-white w-[max-content]">ingresar</a>
        </div>
        <a href="{{ url('login') }}" class="block md:hidden border-2 border-white rounded-md px-4 py-3 uppercase font-bold bg-white hover:bg-transparent hover:text-white w-[max-content]">ingresar</a>
    </x-web.container>
    <x-web.container class="grid grid-cols-1 grid-rows-[100vh] items-center justify-items-center relative z-10">
        <article class="min-h-[300px] flex flex-row gap-4">
            <section class="flex flex-col gap-10 items-center">
                <x-web.h2 class="w-3/4 text-white text-center tracking-widest" :value="__('Líder en Asesoría y Gestión Comercial')" />
                <x-web.p class="w-5/6 md:w-full text-2xl text-white text-center" :value="__('Expertos en ventas corporativas y asesoría en telecomunicaciones')" />
            </section>
        </article>
    </x-web.container>
</header>
