@props([
    'botonHeader' => '',
    'botonFooter' => '',
    'cliente' => '',
])
<x-sistema.card class="m-2 mb-4">
    <div class="d-flex flex-row flex-wrap justify-content-between">
        <x-sistema.titulo title="Datos Del Cliente" />
        <div class="flex flex-row gap-2">
            {{ $botonHeader }}
        </div>
    </div>
    <div class="form-group">
        <label for="ruc" class="form-control-label">Ruc *</label>
        @if ($cliente != '')
            <input class="form-control" type="text" id="ruc" name="ruc" value="{{ $cliente->ruc ?? '' }}" disabled>
        @else
            <input class="form-control" type="text" id="ruc" name="ruc" value="" onchange="validarRuc(this)">
        @endif
    </div>
    <div class="form-group">
        <label for="razon_social" class="form-control-label">Razón Social *</label>
        <input class="form-control" type="text" id="razon_social" name="razon_social" value="{{ $cliente->razon_social ?? '' }}" @php echo ($cliente != '' ? 'disabled' : ''); @endphp>
    </div>
    <div class="form-group">
        <label for="ciudad" class="form-control-label">Ciudad *</label>
        <input class="form-control" type="text" id="ciudad" name="ciudad" value="{{ $cliente->ciudad ?? '' }}" @php echo ($cliente != '' ? 'disabled' : ''); @endphp>
    </div>
    @role(['sistema', 'administrador'])
        <div class="form-check form-switch">
            <label class="form-check-label" for="generado_bot">Generado por Bot</label>
            <input class="form-check-input" type="checkbox" id="generado_bot" @if($cliente->generado_bot ?? false) checked @endif @php echo ($cliente != '' ? 'disabled' : ''); @endphp>
        </div>
    @endrole
    {{ $botonFooter }}
</x-sistema.card>
<script>
    function validarRuc(element) {
        const dialog = document.querySelector("#dialog");
        dialog.querySelectorAll('.is-invalid, .invalid-feedback').forEach(element => {
            element.classList.contains('is-invalid') ? element.classList.remove('is-invalid') : element.remove();
        });
        let ruc = element.value;
        if (ruc.length >= 11) {
            $.ajax({
                url: `{{ url('cliente-gestion/0') }}`,
                method: "GET",
                data: {
                    view: 'show-validar-ruc',
                    ruc: $('#ruc').val(),
                },
                success: function( result ) {
                },
                error: function( response ) {
                    mostrarError(response)
                }
            });
        } else {
            $('#dialog #ruc').addClass('is-invalid');
            $('#dialog #ruc').after('<span class="invalid-feedback" role="alert"><strong>El "Ruc" debe tener exactamente 11 dígitos</strong></span>');
        }
    }
</script>
