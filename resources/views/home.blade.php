<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'Indotech') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="">
    <header>
        <x-web.container>
            <x-web.logo-text value="indotech" />
        </x-web.container>
    </header>
    <main>
        <x-web.container class="grid grid-cols-2 py-10">
            <article class="min-h-[300px] flex flex-row gap-4 py-10">
                <x-web.design-line positiony="top-14" />
                <section class="flex flex-col gap-6">
                    <x-web.h3 :value="__('visión')" />
                    <x-web.p class="w-3/4 text-xl">
                        Párrafo. Haz clic aquí para agregar tu propio texto y editarlo. Es fácil. Haz clic en "Editar texto" o doble clic aquí para agregar tu contenido y cambiar la fuente. En este espacio puedes contar tu historia y permitir que los usuarios sepan más sobre ti.
                    </x-web.p>
                </section>
            </article>
            <article class="">
                <img src="https://static.wixstatic.com/media/84770f_3cc097e7503b4ed498e350c6618ef956~mv2.jpg/v1/fill/w_1302,h_680,al_l,q_85,usm_0.66_1.00_0.01,enc_auto/84770f_3cc097e7503b4ed498e350c6618ef956~mv2.jpg" alt="">
            </article>
        </x-web.container>
    </main>
    <footer class="bg-slate-950 text-slate-50">
        <x-web.container class="grid grid-cols-2 py-10">
            <article class="min-h-[300px] flex flex-row gap-4 py-10">
                <x-web.design-line positiony="top-14" />
                <section class="flex flex-col gap-6">
                    <x-web.logo-text :value="__('indotech')" />
                    <x-web.p class="w-3/4 text-3xl">
                        Buscamos talentos innovadores para nuestro equipo. Ve todos los puestos y envía tu CV.
                    </x-web.p>
                </section>
            </article>
            <article class="flex justify-center">
                <x-web.p class="w-3/4 text-3xl text-center">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Animi nemo vero quos, quibusdam qui aliquid itaque ad ducimus, maiores dignissimos suscipit aliquam. Iusto quo reprehenderit ipsam? Et, libero dolorem! Laboriosam?
                </x-web.p>
            </article>
        </x-web.container>
    </footer>
</body>
</html>