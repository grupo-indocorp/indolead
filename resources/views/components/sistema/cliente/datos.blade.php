@props([
    'botonHeader' => '',
    'botonFooter' => '',
    'cliente' => '',
])
<x-sistema.card class="m-2">
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
            <input class="form-control" type="text" id="ruc" name="ruc" value="" onkeyup="validarRuc()">
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
    {{ $botonFooter }}
</x-sistema.card>
<script>
    function validarRuc() {
        const dialog = document.querySelector("#dialog");
        dialog.querySelectorAll('.is-invalid, .invalid-feedback').forEach(element => {
            element.classList.contains('is-invalid') ? element.classList.remove('is-invalid') : element.remove();
        });
        $.ajax({
            url: `{{ url('gestion_cliente/0') }}`,
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
    }
</script>
