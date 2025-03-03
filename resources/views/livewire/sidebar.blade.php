<aside class="h-screen">
    <div class="bg-white min-h-full rounded">
        <div class="w-auto px-3">
            <ul class="p-0 m-0">
                @if (is_array($links) || is_object($links))
                    @foreach ($links as $link)
                        @can($link['can'])
                            <li class="py-3 text-xl">
                                <span class="" data-bs-toggle="tooltip" data-bs-original-title="{{ $link['nombre'] }}">
                                    <a href="{{ url($link['url']) }}" class="cursor-pointer">
                                        <i class="fa-solid {{ $link['icon'] }}"></i>
                                    </a>
                                </span>
                            </li>
                        @endcan
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
</aside>