<x-sistema.modal class="" style="width: 500px;" title="Notificaciones">
    <div class="p-2">
        <div class="timeline timeline-one-side">
            @foreach ($notificaciones as $notificacion)
                <div class="timeline-block">
                    <span class="timeline-step bg-black text-slate-400" data-bs-toggle="tooltip" data-bs-original-title="Editar">
                        <a href="javascript:;" class="cursor-pointer" onclick="editarNotificacion({{ $notificacion->id }})">
                            <i class="fa-solid fa-calendar-pen"></i>
                        </a>
                    </span>
                    <div class="timeline-content mb-2">
                        @php
                            $fechaActual = date('Y-m-d');
                            $class = 'text-dark';
                            if ($notificacion->fecha <= $fechaActual) {
                                $class = 'text-red-600';
                            }
                        @endphp
                        <h6 class="{{ $class }} text-sm font-bold m-0"><b class="uppercase">{{ substr($notificacion->user->name, 0, 15) }}</b> a creado: {{ $notificacion->asunto }}</h6>
                        <span class="{{ $class }} text-xs font-medium">{{ $notificacion->fecha }}</span>
                        <span class="{{ $class }} text-xs font-medium">{{ $notificacion->hora }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-sistema.modal>
@section('modal')
    <div id="contModal"></div>
@endsection
<script>
    function editarNotificacion(notificacion_id) {
        $.ajax({
            url: `{{ url('notificacion/${notificacion_id}/edit') }}`,
            method: "GET",
            data: {
                view: 'edit',
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