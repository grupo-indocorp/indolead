<header class="flex-initial">
    <nav class="flex w-full justify-between">
        <div>
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm opacity-5 text-dark">{{ auth()->user()->name }}</li>
                <li class="breadcrumb-item text-sm text-dark active text-capitalize" aria-current="page">{{ str_replace('-', ' ', Request::path()) }}</li>
            </ol>
            <h6 class="font-weight-bolder mb-0 text-capitalize">{{ str_replace('-', ' ', Request::path()) }}</h6>
        </div>
        <div class="">
            <div class="hidden md:block">
                <div class="ml-4 flex items-center md:ml-6">
                    <x-ui.button type="button" class="text-xs" onclick="pendienteNotificacion()">
                        {{ count(Helpers::NotificacionRecordatorio()) }} <i class="fa-solid fa-bell"></i>
                    </x-ui.button>
                    <div class="relative ml-3" x-data="{ open:false }">
                        <div class="w-[2.4rem]">
                            <button x-on:click="open = true" type="button" class="flex max-w-xs items-center rounded-full bg-blue-950 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-blue-950" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                <img class="h-100 w-100 rounded-full" src="{{auth()->user()->profile_photo_url}}" alt="">
                            </button>
                        </div>
        
                        <div x-show="open" x-on:click.away="open=false" class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                            <a href="{{route('profile.show')}}" class="block text-blue-950 hover:text-blue-400 rounded-md px-3 py-2 text-sm font-medium" role="menuitem" tabindex="-1" id="user-menu-item-0">Perfil</a>
                            <a href="{{ url('cliente-gestion') }}" class="block text-blue-950 hover:text-blue-400 rounded-md px-3 py-2 text-sm font-medium" role="menuitem" tabindex="-1" id="user-menu-item-1">Gestión de Clientes</a>
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf
                                <a href="{{ route('logout') }}" class="block text-blue-950 hover:text-blue-400 rounded-md px-3 py-2 text-sm font-medium" role="menuitem" tabindex="-1" id="user-menu-item-2" @click.prevent="$root.submit();">Salir</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>
@section('modal')
    <div id="contModal"></div>
@endsection
<script>
    function agregarNotificacion() {
        $.ajax({
            url: `{{ url('notificacion/create') }}`,
            method: "GET",
            data: {
                view: 'create'
            },
            success: function( result ) {
                $('#contModal').html(result);
                openModal();
            },
            error: function( response ) {
                console.log('error');
            }
        });
    }
    function historialNotificacion() {
        $.ajax({
            url: `{{ url('notificacion/create') }}`,
            method: "GET",
            data: {
                view: 'historial'
            },
            success: function( result ) {
                $('#contModal').html(result);
                openModal();
            },
            error: function( response ) {
                console.log('error');
            }
        });
    }
    function pendienteNotificacion() {
        $.ajax({
            url: `{{ url('notificacion/create') }}`,
            method: "GET",
            data: {
                view: 'pendiente'
            },
            success: function( result ) {
                $('#contModal').html(result);
                openModal();
            },
            error: function( response ) {
                console.log('error');
            }
        });
    }
</script>