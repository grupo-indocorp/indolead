<x-sistema.modal title="Detalle" dialog_id="dialog">
    <section class="flex flex-col gap-2">
        <section class="flex flex-col">
            <div class="flex gap-4">
                <span class="text-lg text-slate-900 font-bold">{{ $cuentafinanciera->cliente->ruc }}</span>
                <span class="text-lg text-blue-500 font-bold">{{ $cuentafinanciera->cliente->razon_social }}</span>
            </div>
            <span class="font-bold">{{ $cuentafinanciera->user->name }}</span>
        </section>
    
        <section class="grid grid-cols-3 gap-2">
            <x-sistema.card>
                <div class="flex gap-2">
                    <span class="text-base font-bold">CUENTA FINANCIERA:</span>
                    <div class="form-group w-full">
                        <select class="form-control uppercase"
                            name="cuenta_financiera"
                            id="cuenta_financiera">
                            @foreach ($cantidadCuentafinancieras as $item)
                                <option value="{{ $item->id }}"
                                    @if ($item->id === $cuentafinanciera->id) selected @endif>
                                    {{ $item->cuenta_financiera }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <table>
                    <tr>
                        <td>F. de Evaluación:</td>
                        <td colspan="3"></td>
                    </tr>
                    <tr>
                        <td>Descuento:</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Estado:</td>
                        <td></td>
                        <td>Ciclo:</td>
                        <td></td>
                    </tr>
                </table>
            </x-sistema.card>
            <x-sistema.card>
                <div class="flex flex-col">
                    <span class="text-base font-bold">COMENTARIO:</span>
                    <p> Lorem ipsum dolor sit amet consectetur adipisicing elit. Minus velit voluptate facilis. Nemo ipsam adipisci alias facere molestiae, eos dignissimos, aspernatur tempora unde aperiam nobis quam. Beatae porro laboriosam a.</p>
                </div>
            </x-sistema.card>
            <x-sistema.card>
                <div class="form-group">
                    <label for="observacion_calidad" class="form-control-label">OBSERVACIÓN</label>
                    <textarea class="form-control" rows="3" id="observacion_calidad" name="observacion_calidad"></textarea>
                </div>
            </x-sistema.card>
        </section>
    
        <section class="grid grid-cols-3 gap-2">
            <x-sistema.card>
                <p>Factura 1</p>
                <table>
                    <tr>
                        <td>F. Emisión:</td>
                        <td></td>
                        <td>F. Venc.:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Monto:</td>
                        <td></td>
                        <td>Deuda:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Estado:</td>
                        <td></td>
                    </tr>
                </table>
            </x-sistema.card>
            <x-sistema.card>
                <p>Factura 2</p>
                <table>
                    <tr>
                        <td>F. Emisión:</td>
                        <td></td>
                        <td>F. Venc.:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Monto:</td>
                        <td></td>
                        <td>Deuda:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Estado:</td>
                        <td></td>
                    </tr>
                </table>
            </x-sistema.card>
            <x-sistema.card>
                <p>Factura 3</p>
                <table>
                    <tr>
                        <td>F. Emisión:</td>
                        <td></td>
                        <td>F. Venc.:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Monto:</td>
                        <td></td>
                        <td>Deuda:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Estado:</td>
                        <td></td>
                    </tr>
                </table>
            </x-sistema.card>
        </section>
    
        <section id="productosCuentafinanciera"></section>
    </section>
</x-sistema.modal>
<script>
    function detalleCuentafinanciera(cuentafinanciera_id) {
        $.ajax({
            url: `{{ url('cuentas-financieras/${cuentafinanciera_id}') }}`,
            method: "GET",
            data: {
                view: 'show-cuentafinanciera',
            },
            success: function( result ) {
                $('#contenedorModal').html(result);
                openModal();
            },
            error: function( response ) {
                console.log('error');
            }
        });
    }
    // cuenta_financiera
     $(document).ready(function () {
        $('#cuenta_financiera').on('change', function () {
            let cuentafinanciera_id = $(this).val();
            $.ajax({
                url: `{{ url('cuentas-financieras/${cuentafinanciera_id}') }}`,
                method: "GET",
                data: {
                    view: 'show-cuentafinanciera-productos',
                },
                success: function( result ) {
                    $('#productosCuentafinanciera').html(result);
                },
                error: function( response ) {
                    console.log('error');
                }
            });
        });

        $('#cuenta_financiera').trigger('change');
    });
</script>
