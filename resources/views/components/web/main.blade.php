{{-- nosotros --}}
<x-web.container id="section-nosotros" class="grid grid-cols-1 grid-rows-[80vh] md:grid-rows-[40vh] items-center">
    <article class="min-h-[190px] flex flex-row gap-4">
        <x-web.design-line positiony="top-20" />
        <section class="flex flex-col justify-between">
            <x-web.h5 :value="__('nosotros')" />
            <x-web.p class="md:w-3/4" :value="__('Indotech es un distribuidor autorizado de Movistar a nivel corporativo, especializado en la venta de servicios de telecomunicaciones como telefonía fija, móvil, CAEQ, servicios avanzados y multipunto. Nos destacamos por brindar un servicio de excelencia para satisfacer a nuestros clientes internos y externos.')" />
        </section>
    </article>
</x-web.container>

{{-- vision --}}
<x-web.container id="section-vision" class="grid grid-cols-1 md:grid-cols-2 grid-rows-[50vh] md:grid-rows-[80vh] items-center">
    <article class="min-h-[200px] flex flex-row gap-4">
        <x-web.design-line positiony="bottom-3" />
        <section class="flex flex-col justify-between">
            <x-web.h5 :value="__('visión')" />
            <x-web.p class="w-3/4" :value="__('Ser el principal socio estratégico comercial de empresas que necesiten mejorar su participación en el mercado nacional para el año 2025.')" />
        </section>
    </article>
    <article class="hidden md:flex justify-center">
        <img src="{{ asset('img/vision.png') }}" alt="" class="w-[700px] opacity-50 hover:opacity-100">
    </article>
</x-web.container>

{{-- mision --}}
<x-web.container id="section-mision" class="grid grid-cols-1 md:grid-cols-2 grid-rows-[80vh] items-center">
    <article class="hidden md:flex justify-center">
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
    <x-web.container class="grid grid-cols-1 md:grid-cols-2 grid-rows-2 md:grid-rows-[60vh] items-center">
        <article class="min-h-[350px] flex flex-row gap-4 py-10 md:py-0">
            <x-web.design-line positiony="bottom-20" background="bg-white" />
            <section class="flex flex-col justify-between">
                <x-web.h5 class="text-white font-extralight" :value="__('únete a indotech')" style="font-size: 1rem;" />
                <x-web.h4 class="text-white font-light" :value="__('Buscamos asesores de ventas coorporativas')" />
                <x-web.p class="w-3/4 mt-10 font-extralight" :value="__('¿Tienes experiencia en ventas y estás buscando una oportunidad para crecer? En Indotech, estamos buscando Asesores de Ventas Corporativas apasionados y con experiencia en ventas.')" />
            </section>
        </article>
        <article class="grid grid-cols-2 md:grid-cols-3 grid-rows-3 md:grid-rows-2 gap-8">
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
<x-web.container id="section-empresa" class="grid grid-cols-1 md:grid-rows-[60vh] items-center">
    <article class="min-h-[350px] flex flex-row gap-4 py-10 md:py-0">
        <x-web.design-line positiony="bottom-2" />
        <section class="w-full flex flex-col justify-between gap-4">
            <x-web.h5 class="mb-10" :value="__('Nuestra Información')" />
            <x-web.p class="md:w-3/4 ">
                <strong>Whatsapp:</strong> <br>
                <a href="https://api.whatsapp.com/send?phone=51920045271&text=%C2%A1Hola!%0A%0AEstoy%20interesado%20en%20trabajar%20con%20Indotech.%20%C2%BFPodr%C3%ADan%20darme%20m%C3%A1s%20informaci%C3%B3n%20sobre%20las%20oportunidades%20disponibles%20y%20c%C3%B3mo%20puedo%20unirme%20a%20su%20equipo%3F%0A%0A%C2%A1Gracias!"
                    target="blank">
                    +51 920045271
                </a>
            </x-web.p>
            <x-web.p class="md:w-3/4 text-md md:text-xl">
                <strong>Correo Electrónico:</strong> <br>
                <span>reclutamiento@indotechsac.com</span>
            </x-web.p>
            <x-web.p class="text-md md:text-xl">
                <strong>Nuestras Oficinas:</strong> <br>
                <span>- Jr. Tacna Nro. 561 - 3er Piso Ofi. 302 - Huancayo - Huancayo - Júnin </span> <br>
                <span>- Av. Luis Espejo Nro. 1097 - 6to Piso Ofi. 601 - Santa Catalina - La Victoria - Lima</span>
            </x-web.p>
        </section>
    </article>
</x-web.container>
