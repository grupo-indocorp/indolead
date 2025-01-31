@props([
    'botonHeader' => '',
    'botonFooter' => '',
    'contactos' => false,
])
<x-sistema.card class="m-2">
    <div class="relative mb-2 d-flex-row justify-start items-center">
        <x-sistema.titulo title="Contactos" />
        <div class="flex flex-row gap-2 ml-4">
            {{ $botonHeader }}
        </div>
    </div>
    <div class="row">
        @role('ejecutivo')
        <div class="col-12">
            <div class="row">
                <div class="col-6">
                    <div class="relative  mb-2">
                        <input class="block px-2.5 pb-2 pt-1 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " type="text" id="dni" name="dni" />
                        <label for="dni" class="absolute text-sm text-gray-600 duration-300 transform -translate-y-4 scale-75 top-3 left-0 z-10 origin-[0] px-0.5 py-0.5 peer-focus:text-blue-600 peer-focus:text-sm peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-100 peer-focus:-translate-y-4 bg-[#F1F5F9]">
                            DNI:
                        </label>
                    </div>
                    <div class="relative mb-2">
                        <input class="block px-2.5 pb-2 pt-1 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " type="text" id="cargo" name="cargo" />
                        <label for="cargo" class="absolute text-sm text-gray-600 duration-300 transform -translate-y-4 scale-75 top-2 left-0 z-10 origin-[0] px-0.5 py-0.5 peer-focus:text-blue-600 peer-focus:text-sm peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-100 peer-focus:-translate-y-4 bg-[#F1F5F9]">
                            Cargo:
                        </label>
                    </div>
                    <div class="relative mb-2">
                        <input class="block px-2.5 pb-2 pt-1 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " type="text" id="celular" name="celular" />
                        <label for="celular" class="absolute text-sm text-gray-600 duration-300 transform -translate-y-4 scale-75 top-2 left-0 z-10 origin-[0] px-0.5 py-0.5 peer-focus:text-blue-600 peer-focus:text-sm peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-100 peer-focus:-translate-y-4 bg-[#F1F5F9]">
                            Celular:
                        </label>
                    </div>  
                </div>
                <div class="col-6">
                    <div class="relative mb-2">
                        <input class="block px-2.5 pb-2 pt-1 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " type="text" id="nombre" name="nombre" />
                        <label for="nombre" class="absolute text-sm text-gray-600 duration-300 transform -translate-y-4 scale-75 top-2 left-0 z-10 origin-[0] px-0.5 py-0.5 peer-focus:text-blue-600 peer-focus:text-sm peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-100 peer-focus:-translate-y-4 bg-[#F1F5F9]">
                            Nombre:
                        </label>
                    </div>

                    <div class="relative mb-2">
                        <input class="block px-2.5 pb-2 pt-1 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " type="text" id="correo" name="correo" />
                        <label for="correo" class="absolute text-sm text-gray-600 duration-300 transform -translate-y-4 scale-75 top-2 left-0 z-10 origin-[0] px-0.5 py-0.5 peer-focus:text-blue-600 peer-focus:text-sm peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-100 peer-focus:-translate-y-4 bg-[#F1F5F9]">                            Correo:
                        </label>
                    </div>
                    

                    {{ $botonFooter }}
                </div>
            </div>
        </div>
        @endrole
        <div class="col-12">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">DNI</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nombre</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Celular</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Cargo</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Correo</th>
                        </tr>
                    </thead>
                    <tbody id="contactos">
                        @if ($contactos)
                            @foreach ($contactos as $contacto)
                            <tr id="{{ $contacto['id'] }}">
                                <td class="align-middle text-uppercase text-sm">
                                    <span class="text-secondary text-xs font-weight-normal">{{ $contacto['dni'] }}</span>
                                </td>
                                <td class="align-middle text-uppercase text-sm">
                                    <span class="text-secondary text-xs font-weight-normal">{{ $contacto['nombre'] }}</span>
                                </td>
                                <td class="align-middle text-uppercase text-sm">
                                    <span class="text-secondary text-xs font-weight-normal">{{ $contacto['celular'] }}</span>
                                </td>
                                <td class="align-middle text-uppercase text-sm">
                                    <span class="text-secondary text-xs font-weight-normal">{{ $contacto['cargo'] }}</span>
                                </td>
                                <td class="align-middle text-uppercase text-sm">
                                    <span class="text-secondary text-xs font-weight-normal">{{ $contacto['correo'] }}</span>
                                </td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-sistema.card>
