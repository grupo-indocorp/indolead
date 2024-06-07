<x-sistema.modal title="Registrar Etapa" dialog_id="dialog">
    @php $mensaje = "¿Esta seguro de eliminar la etapa $etapa->nombre?"; @endphp
    <div class="alert alert-danger alert-dismissible fade show text-slate-900" role="alert">
        <span class="alert-text">
            <strong class="text-white">{{ $mensaje }}</strong>
        </span>
    </div>
    <div class="flex justify-end">
        <button type="button" class="btn bg-gradient-primary m-0" onclick="submitEtapa({{ $etapa->id }})">Eliminar</button>
    </div>
</x-sistema.modal>
<script>
    function submitEtapa(etapa_id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: `{{ url('configuracion-etapa/${etapa_id}') }}`,
            method: "DELETE",
            data: {
                view: 'destroy-etapa',
            },
            success: function( result ) {
                location.reload();
                closeModal();
            },
            error: function( data ) {
            }
        });
    }
</script>