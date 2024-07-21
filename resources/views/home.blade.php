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
    {{-- header --}}
    {{-- <x-web.header /> --}}
    <header class="bg-cover bg-center bg-opacity-10" style="background-image: url('https://images.pexels.com/photos/1166644/pexels-photo-1166644.jpeg')">
        <div class="w-full h-[100vh] bg-gradient-to-t from-white to-slate-300 absolute opacity-50"></div>
        <div class="w-full h-[250px] bg-gradient-to-t from-white absolute left-0 bottom-0"></div>
        {{-- <x-web.container class="fixed inset-x-px z-10 py-4"> --}}
        <x-web.container class="absolute inset-x-px z-20 py-4 flex flex-row justify-between">
            <div class="flex gap-2 items-center">
                <x-web.logo class="w-[30px]" />
                <x-web.logo-text class="font-normal" :value="__('indotech')" />
            </div>
            <div class="flex gap-4 items-center">
                <a href="#section-nosotros" class="uppercase font-medium text-slate-900 hover:text-blue-500">Nosotros</a>
                <a href="#section-contratos" class="uppercase font-medium text-slate-900 hover:text-blue-500">contratos</a>
                <a href="#section-empresa" class="uppercase font-medium text-slate-900 hover:text-blue-500">contacto</a>
                <a href="{{ url('login') }}" class="border-2 border-white rounded-md px-4 py-3 uppercase font-bold bg-white hover:bg-transparent hover:text-black w-[max-content]">login</a>
            </div>
        </x-web.container>
        <x-web.container class="grid grid-cols-1 grid-rows-[100vh] items-center justify-items-center relative z-10">
            <article class="min-h-[300px] flex flex-row gap-4">
                <section class="flex flex-col gap-10 items-center">
                    <x-web.h2 class="w-3/4 text-center tracking-widest" :value="__('Líder en Asesoría y Gestión Comercial')" />
                    <x-web.p class="w-full text-2xl text-center" :value="__('Soluciones en telecomunicaciones y asesoría de nuestros clientes.')" />
                </section>
            </article>
        </x-web.container>
    </header>

    {{-- nosotros --}}
    <x-web.container id="section-nosotros" class="grid grid-cols-1 grid-rows-[40vh] items-center">
        <article class="min-h-[190px] flex flex-row gap-4">
            <x-web.design-line positiony="top-20" />
            <section class="flex flex-col justify-between">
                <x-web.h5 :value="__('nosotros')" />
                <x-web.p class="w-3/4" :value="__('Indotech es un distribuidor autorizado de Movistar a nivel corporativo, especializado en la venta de servicios de telecomunicaciones como telefonía fija, móvil, CAEQ, servicios avanzados y multipunto. Nos destacamos por brindar un servicio de excelencia para satisfacer a nuestros clientes internos y externos.')" />
            </section>
        </article>
    </x-web.container>

    {{-- vision --}}
    <x-web.container id="section-vision" class="grid grid-cols-2 grid-rows-[80vh] items-center">
        <article class="min-h-[200px] flex flex-row gap-4">
            <x-web.design-line positiony="bottom-3" />
            <section class="flex flex-col justify-between">
                <x-web.h5 :value="__('visión')" />
                <x-web.p class="w-3/4" :value="__('Ser el principal socio estratégico comercial de empresas que necesiten mejorar su participación en el mercado nacional para el año 2025.')" />
            </section>
        </article>
        <article class="flex justify-center">
            <img src="{{ asset('img/vision.png') }}" alt="" class="w-[700px] opacity-50 hover:opacity-100">
        </article>
    </x-web.container>
    
    {{-- mision --}}
    <x-web.container id="section-mision" class="grid grid-cols-2 grid-rows-[80vh] items-center">
        <article class="flex justify-center">
            <img src="{{ asset('img/mision.png') }}" alt="" class="w-[800px] opacity-50 hover:opacity-100">
        </article>
        <article class="min-h-[310px] flex flex-row gap-4">
            <section class="flex flex-col justify-between items-end">
                <x-web.h5 :value="__('misión')" />
                <x-web.p class="w-3/4 text-right" :value="__('Somos una empresa de ventas corporativas en las principales ciudades del Perú. Ofrecemos productos y servicios con un estándar de gestión de ventas diferenciado, comprometidos con el desarrollo de nuestros colaboradores en un entorno de trabajo en equipo, perseverancia y responsabilidad.')" />
            </section>
            <x-web.design-line positiony="top-20" />
        </article>
    </x-web.container>

    {{-- contratos --}}
    <section id="section-contratos" class="bg-black text-white">
        <x-web.container class="grid grid-cols-2 grid-rows-[60vh] items-center">
            <article class="min-h-[350px] flex flex-row gap-4">
                <x-web.design-line positiony="bottom-20" background="bg-white" />
                <section class="flex flex-col justify-between">
                    <x-web.h5 class="text-white font-extralight" :value="__('únete a indotech')" style="font-size: 1rem;" />
                    <x-web.h4 class="text-white font-light" :value="__('Buscamos asesores de ventas coorporativas')" />
                    <x-web.p class="w-3/4 mt-10 font-extralight" :value="__('¿Tienes experiencia en ventas y estás buscando una oportunidad para crecer? En Indotech, estamos buscando Asesores de Ventas Corporativas apasionados y con experiencia en ventas.')" />
                </section>
            </article>
            <article class="grid grid-cols-3 grid-rows-2 gap-8">
                <div class="flex flex-col items-center">
                    <img src="{{ asset('img/comisiones.svg') }}" alt="" class="w-[150px] h-[100px]">
                    <x-web.p class="text-center font-light" :value="__('Comisiones Ilimitadas.')" style="font-size: 0.8rem;" />
                </div>
                <div class="flex flex-col items-center">
                    <img src="{{ asset('img/bonos.svg') }}" alt="" class="w-[150px] h-[100px]">
                    <x-web.p class="text-center font-light" :value="__('Bonos e Incentivos.')" style="font-size: 0.8rem;" />
                </div>
                <div class="flex flex-col items-center">
                    <img src="{{ asset('img/horarios.svg') }}" alt="" class="w-[150px] h-[100px]">
                    <x-web.p class="text-center font-light" :value="__('Horarios Flexibles.')" style="font-size: 0.8rem;" />
                </div>
                <div class="flex flex-col items-center">
                    <img src="{{ asset('img/premiaciones.svg') }}" alt="" class="w-[150px] h-[100px]">
                    <x-web.p class="text-center font-light" :value="__('Premiaciones.')" style="font-size: 0.8rem;" />
                </div>
                <div class="flex flex-col items-center">
                    <img src="{{ asset('img/capacitaciones.svg') }}" alt="" class="w-[150px] h-[100px]">
                    <x-web.p class="text-center font-light" :value="__('Capacitaciones Constantes.')" style="font-size: 0.8rem;" />
                </div>
                <div class="flex flex-col items-center">
                    <img src="{{ asset('img/convenios.svg') }}" alt="" class="w-[150px] h-[100px]">
                    <x-web.p class="text-center font-light" :value="__('Convenios Corporativos.')" style="font-size: 0.8rem;" />
                </div>
            </article>
        </x-web.container>
    </section>

    {{-- boton de whatsapp --}}
    <section class="bg-black text-white">
        <x-web.container class="grid grid-cols-1 grid-rows-[20vh] justify-items-center items-center">
            <a href="https://api.whatsapp.com/send?phone=51920045271&text=%C2%A1Hola!%0A%0AEstoy%20interesado%20en%20trabajar%20con%20Indotech.%20%C2%BFPodr%C3%ADan%20darme%20m%C3%A1s%20informaci%C3%B3n%20sobre%20las%20oportunidades%20disponibles%20y%20c%C3%B3mo%20puedo%20unirme%20a%20su%20equipo%3F%0A%0A%C2%A1Gracias!"
                class="border-2 border-white rounded-md px-4 py-3 uppercase font-bold hover:bg-white hover:text-black w-[max-content]" target="blank">únete ahora</a>
        </x-web.container>
    </section>

    {{-- información de la empresa --}}
    <x-web.container id="section-empresa" class="grid grid-cols-1 grid-rows-[60vh] items-center">
        <article class="min-h-[350px] flex flex-row gap-4">
            <x-web.design-line positiony="bottom-2" />
            <section class="flex flex-col justify-between gap-4">
                {{-- <x-web.logo-text class="mb-10" :value="__('indotech')" /> --}}
                <x-web.h5 class="mb-10" :value="__('Nuestra Información')" />
                <x-web.p class="w-3/4">
                    <strong>Whatsapp:</strong> <br>
                    <a href="https://api.whatsapp.com/send?phone=51920045271&text=%C2%A1Hola!%0A%0AEstoy%20interesado%20en%20trabajar%20con%20Indotech.%20%C2%BFPodr%C3%ADan%20darme%20m%C3%A1s%20informaci%C3%B3n%20sobre%20las%20oportunidades%20disponibles%20y%20c%C3%B3mo%20puedo%20unirme%20a%20su%20equipo%3F%0A%0A%C2%A1Gracias!"
                        target="blank">
                        +51 920045271
                    </a>
                </x-web.p>
                <x-web.p class="w-3/4">
                    <strong>Correo Electrónico:</strong> <br>
                    <span>recursoshumanos@indotechsac.com</span>
                </x-web.p>
                <x-web.p class="w-full">
                    <strong>Nuestras Oficinas:</strong> <br>
                    <span>- Jr. Tacna Nro. 561 - 3er Piso Ofi. 302 - Huancayo - Huancayo - Júnin </span> <br>
                    <span>- Av. Luis Espejo Nro. 1097 - 6to Piso Ofi. 601 - Santa Catalina - La Victoria - Lima</span>
                </x-web.p>
            </section>
        </article>
    </x-web.container>

    {{-- footer --}}
    <footer>
        <x-web.container class="grid grid-cols-1 grid-rows-[10vh] items-center">
            <x-web.h5 class="capitalize font-normal" style="font-size: 1.2rem;">
                Desarrollado por <a href="{{ url('/') }}" class="lowercase font-medium text-slate-900 hover:text-blue-500">Indotechsac.com</a>
            </x-web.h5>
        </x-web.container>
    </footer>
</body>
</html>