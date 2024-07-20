<header class="bg-cover bg-center bg-opacity-10" style="background-image: url('https://img.freepik.com/foto-gratis/gerente-ropa-lujo-gente-negocios-trabajando-su-nuevo-proyecto-aula_146671-16341.jpg?t=st=1721495035~exp=1721498635~hmac=8594f5f8e6926abaff39163d26b3803ddc786fa302c3131f80aea5f4131aa642&w=1380')">
    <div class="w-full h-[100vh] bg-gradient-to-t from-black from-10% to-slate-950 absolute opacity-80"></div>
    <x-web.container class="fixed inset-x-px z-10 py-4">
        <div class="flex flex-row gap-2">
            <x-web.logo class="w-[30px]" />
            <x-web.logo-text class="text-white font-normal" :value="__('indotech')" />
        </div>
    </x-web.container>
    <x-web.container class="grid grid-cols-1 grid-rows-[100vh] items-center justify-items-center relative z-10">
        <article class="min-h-[300px] flex flex-row gap-4">
            <section class="flex flex-col gap-10 items-center">
                <x-web.h2 class="w-3/4 text-center tracking-widest" :value="__('Líder en Asesoría y Gestión Comercial')" />
                <x-web.p class="w-full text-2xl text-white text-center" :value="__('Soluciones en telecomunicaciones y asesoría de nuestros clientes.')" />
            </section>
        </article>
    </x-web.container>
</header>
