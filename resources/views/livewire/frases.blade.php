@php
    $number = mt_rand(1, 7);
    $audio = mt_rand(1, 8);
@endphp
<section
    wire:poll.300000ms="actualizarFrase"
    x-data="{ visible: false }" 
    x-init="
        setInterval(() => {
            visible = true;
            $refs.audio.play();
            setTimeout(() => visible = false, 15000);
        }, 320000);"
    class="absolute bottom-0 right-4">
    <div x-show="visible">
        <audio x-ref="audio" hidden>
            <source src="{{ asset('img/halloween/'.$audio.'.mp3') }}" type="audio/mpeg">
        </audio>
        <div class="w-[300px]">
            <span style="transition: all 0.5s;" class="text-2xl font-bold inline-block  text-slate-700 rounded-xl p-1 tracking-wide leading-snug">
                {{ $frase }}
            </span>
        </div>
        <div class="w-[200px]">
            <img src="{{ asset('img/halloween/'.$number.'.gif') }}" alt="">
        </div>
    </div>
</section>
