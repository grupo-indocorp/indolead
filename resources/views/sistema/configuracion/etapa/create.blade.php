<x-sistema.modal class="" style="width: 500px;" title="Registrar Etapa">
    <div class="form-group">
        <div class="row">
            <div class="col-2">
                <label for="name" class="form-control-label">Nombre</label>
            </div>
            <div class="col-10">
                <input class="form-control" type="text" value="" id="nombre" name="nombre">
            </div>
        </div>
    </div>
    <div class="flex justify-end">
        <button type="button" class="btn bg-gradient-primary m-0" onclick="submitEtapa()">Guardar</button>
    </div>
</x-sistema.modal>
<script>
    function submitEtapa() {
        limpiarError();
        capturarToken();

        $.ajax({
            url: `{{ url('configuracion-etapa') }}`,
            method: "POST",
            data: {
                view: 'store-etapa',
                nombre: $('#nombre').val(),
            },
            success: function( result ) {
                location.reload();
                closeModal();
            },
            error: function( data ) {
                let errors = data.responseJSON;
                if(errors) {
                    $.each(errors.errors, function(key, value){
                        $('#dialog #'+key).addClass('is-invalid');
                        $('#dialog #'+key).after('<span class="invalid-feedback" role="alert"><strong>'+ value +'</strong></span>');
                    });
                }
            }
        });
    }
</script>
