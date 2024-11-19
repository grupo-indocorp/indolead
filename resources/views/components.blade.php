<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Component</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2" defer></script>
</head>
<body class="h-screen bg-gray-200">
    <div x-data="{ showSidebar: false }" class="flex h-screen">
        <aside class="w-16 bg-gray-800 text-white flex flex-col">
            <div class="p-4 flex items-center justify-center bg-gray-900">
                <h1 class="text-lg font-bold">LOGO</h1>
            </div>
            <div class="flex-1 overflow-y-auto">
                <ul class="p-4 space-y-4">
                    @for ($i = 0; $i < 15; $i++)
                        <li class="flex items-center space-x-2">
                            <span class="text-xl">🏠</span>
                        </li>
                    @endfor
                </ul>
            </div>
            <div class="p-4 bg-gray-900 text-center text-sm">
                <p>🛫</p>
            </div>
        </aside>

        {{-- sidebar en modal - responsivo --}}
        <aside x-show="showSidebar"
            class="w-screen h-screen bg-black bg-opacity-95 text-white flex flex-col fixed p-4"
            x-transition>
            <section class="flex items-center justify-between">
                <h1 class="text-lg font-bold">LOGO</h1>
                <button
                    @click="showSidebar = false" 
                    class="focus:outline-none self-end">
                    <svg class="w-6 h-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </section>
            <section class="flex-1 overflow-y-auto">
                <ul class="p-4 space-y-4">
                    @for ($i = 0; $i < 5; $i++)
                        <li class="flex items-center justify-center space-x-2">
                            <span class="text-xl">🏠</span>
                        </li>
                    @endfor
                </ul>
            </section>
            <section class="flex items-center justify-center">
                <h6 class="text-lg font-bold">FOOTER</h6>
            </section>
        </aside>

        <div class="flex-1 flex flex-col">
            <header class="h-10vh bg-transparent shadow flex items-center justify-between px-4">
                <div>
                    <button @click="showSidebar = true"
                        class="text-gray-700 focus:outline-none visible md:hidden">
                        <svg class="w-6 h-6"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
                <div>
                    <h2 class="text-lg font-bold">Header</h2>
                    <div>Opciones</div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-4 bg-green-600">
                <div class="space-y-4">
                    <div class="p-4 bg-white shadow rounded">
                        <p>Contenido 1</p>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
