@props([
    'botonHeader' => '',
    'botonFooter' => '',
    'cliente' => '',
])
<x-sistema.card class="m-2">
    <div class="relative mb-0 d-flex flex-row flex-wrap justify-content-between">
        <x-sistema.titulo title="Datos Del Cliente" />
        <div class="flex flex-row gap-2">
            {{ $botonHeader }}
        </div>
    </div>
    <div class="col-12">
        <div class="row">
            <div class="col-6">
                <div class="relative mb-1">
                    <label for="ruc">Ruc*</label>
                    @if ($cliente != '')
                        <input class="px-1 py-0.5 w-50 text-sm border-none bg-[#F1F5F9]" type="text" id="ruc" name="ruc" placeholder="" value="{{ $cliente->ruc ?? '' }}" readonly>
                    @else
                        <input class="px-1 py-0.5 w-50 text-sm border-none bg-[#F1F5F9]" type="text" id="ruc" name="ruc" placeholder="" onchange="validarRuc(this)">
                    @endif
                </div>
                <div class="relative mb-1">
                    <label for="ciudad">Ciudad *</label>
                    <input class="px-1 py-0.5 w-50 text-sm border-none bg-[#F1F5F9]" type="text" id="ciudad" name="ciudad" value="{{ $cliente->ciudad ?? '' }}"  @php echo ($cliente != '' ? 'disabled' : ''); @endphp placeholder=" " />
                    {{ $botonFooter }}
                </div>
            </div>
            <div class="col-6">
                <div class="relative mb-1">
                    <label for="razon_social">Razón Social*</label>
                    <input class="px-1 py-0.5 w-50 text-sm border-none bg-[#F1F5F9]" type="text" id="razon_social" name="razon_social" value="{{ $cliente->razon_social ?? '' }}" @php echo ($cliente != '' ? 'disabled' : ''); @endphp placeholder=" " />
                </div>
            </div>
        </div>
    </div>
</x-sistema.card>

<script>
    function validarRuc(element) {
        const dialog = document.querySelector("#dialog");
        dialog.querySelectorAll('.is-invalid, .invalid-feedback').forEach(element => {
            element.classList.contains('is-invalid') ? element.classList.remove('is-invalid') : element
                .remove();
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
                success: function(result) {},
                error: function(response) {
                    mostrarError(response)
                }
            });
        } else {
            $('#dialog #ruc').addClass('is-invalid');
            $('#dialog #ruc').after(
                '<span class="invalid-feedback" role="alert"><strong>El "Ruc" debe tener exactamente 11 dígitos</strong></span>'
            );
        }
    }
</script>
