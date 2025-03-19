@extends('layouts.app')

@section('content')
<x-ui.grid-container>
    <x-ui.grid-item class="col-span-1 xl:col-span-2 xl:row-span-2">
        <div class="h-full flex flex-col justify-between">
            <h4 class="text-sm text-slate-500">Accesos Directos</h4>
            <h3 class="w-full xl:w-4/5 text-4xl text-slate-900 font-extrabold tracking-normal">Accesos Directos a la Configuración del Sistema</h3>
            <ul class="h-[400px] overflow-y-scroll bg-slate-300 text-slate-900 drop-shadow-2xl rounded-md p-4 py-2">
                @foreach ($links as $item)
                    <li>
                        @php $link = $item['link']; @endphp
                        <a href="{{ url($link) }}" class="rounded-lg p-1 my-3 bg-slate-900 text-yellow-500 flex items-center gap-4 hover:cursor-pointer hover:bg-slate-950 hover:text-green-500">
                            <div class="bg-slate-800 p-1 text-xl rounded-md">
                                @if ($item['icon'] != '')
                                    {!! $item['icon'] !!}
                                @else
                                    <i class="fa-solid fa-satellite-dish"></i>
                                @endif
                            </div>
                            <div class="w-full flex justify-between items-center">
                                <h5 class="text-sm text-slate-100 font-bold m-0 uppercase">{{ $item['title'] }}</h5>
                                <div class="p-1 text-xl">
                                    <i class="fa-solid fa-arrow-right"></i>
                                </div>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </x-ui.grid-item>
    <x-ui.grid-item class="col-span-1 xl:col-span-2 xl:row-span-1">
        <h3 class="w-full xl:w-4/5 text-4xl text-slate-900 font-extrabold tracking-normal">Evaporación</h3>
        <ul class="h-[240px] overflow-y-scroll bg-slate-300 text-slate-900 drop-shadow-2xl rounded-md p-4 py-2">
            @foreach ($links_evaporacion as $item)
                <li>
                    @php $link = $item['link']; @endphp
                    <a href="{{ url($link) }}" class="rounded-lg p-1 my-3 bg-slate-900 text-yellow-500 flex items-center gap-4 hover:cursor-pointer hover:bg-slate-950 hover:text-green-500">
                        <div class="bg-slate-800 p-1 text-xl rounded-md">
                            @if ($item['icon'] != '')
                                {!! $item['icon'] !!}
                            @else
                                <i class="fa-solid fa-satellite-dish"></i>
                            @endif
                        </div>
                        <div class="w-full flex justify-between items-center">
                            <h5 class="text-sm text-slate-100 font-bold m-0 uppercase">{{ $item['title'] }}</h5>
                            <div class="p-1 text-xl">
                                <i class="fa-solid fa-arrow-right"></i>
                            </div>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    </x-ui.grid-item>
    <x-ui.grid-item class="col-span-1 xl:col-span-1 xl:row-span-1">
        ...
    </x-ui.grid-item>
    <x-ui.grid-item class="col-span-1 xl:col-span-1 xl:row-span-1">
        ...
    </x-ui.grid-item>
</x-ui.grid-container>
@endsection
