@props(['positiony'])

<article class="relative h-[inherit]">
    <div class="static w-[3px] h-full bg-blue-400 rounded-xl"></div>
    <div class="absolute w-[4px] h-[100px] bg-white rounded-xl {{ $positiony ?? 'bottom-0' }}"></div>
</article>
