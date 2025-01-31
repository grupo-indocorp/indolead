@props([
    'botonHeader' => '',
    'botonFooter' => '',
    'cliente' => '',
])
<x-sistema.card class="m-2">
    <div class=" relative mb-3 d-flex flex-row flex-wrap justify-content-between">
        <x-sistema.titulo title="Datos Del Cliente" />
        <div class="flex flex-row gap-2">
            {{ $botonHeader }}
        </div>
    </div>
    <div class="relative mb-3">
        @if ($cliente != '')
        <input class="block px-2.5 pb-1.5 pt-0 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" type="text" id="ruc" name="ruc" placeholder="" value="{{ $cliente->ruc ?? '' }}" readonly>
        @else
        <input class="block px-2.5 pb-1.5 pt-0 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" type="text" id="ruc" name="ruc" placeholder="" onchange="validarRuc(this)">
        @endif
        <label for="ruc" class="absolute text-sm text-gray-600 duration-300 transform -translate-y-4 scale-75 top-2 left-0 z-10 origin-[0] px-0.5 py-0 peer-focus:text-blue-600 peer-focus:text-sm peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-100 peer-focus:-translate-y-4 bg-[#F1F5F9]">Ruc *</label>
    </div>
    <div class="relative mb-3">
      <input class="block px-2.5 pb-1.5 pt-0 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" type="text" id="razon_social" name="razon_social" value="{{ $cliente->razon_social ?? '' }}" @php echo ($cliente != '' ? 'disabled' : ''); @endphp placeholder=" " />
      <label for="razon_social" class="absolute text-sm text-gray-600 duration-300 transform -translate-y-4 scale-75 top-2 left-0 z-10 origin-[0] px-0.5 py-0 peer-focus:text-blue-600 peer-focus:text-sm peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-100 peer-focus:-translate-y-4 bg-[#F1F5F9]">Razón Social *</label>
  </div>    
    <div class="relative mb-2">
        <input class="block px-2.5 pb-1.5 pt-0 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" type="text" id="ciudad" name="ciudad" value="{{ $cliente->ciudad ?? '' }}" @php echo ($cliente != '' ? 'disabled' : ''); @endphp placeholder=" " />
        <label for="ciudad" class="absolute text-sm text-gray-600 duration-300 transform -translate-y-4 scale-75 top-2 left-0 z-10 origin-[0] px-0.5 py-0 peer-focus:text-blue-600 peer-focus:text-sm peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-100 peer-focus:-translate-y-4 bg-[#F1F5F9]">Ciudad *</label>
    </div> 
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