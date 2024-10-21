<section
    wire:poll.120000ms="actualizarFrase"
    x-data="{ visible: false }" 
    x-init="
        setInterval(() => {
            visible = true;
            $refs.audio.play();
            setTimeout(() => visible = false, 12000);
        }, 130000);"
    class="absolute bottom-0 right-4">
    <div x-show="visible">
        <audio x-ref="audio" hidden>
            <source src="{{ asset('img/halloween/halloween.mp3') }}" type="audio/mpeg">
        </audio>
        <div class="w-[100px]">
            <img src="{{ asset('img/halloween/calabaza_h.png') }}" alt="">
        </div>
        <p
            style="transition: all 0.5s;"
            class="text-2xl font-bold">{{ $frase }}</p>
    </div>
</section>
