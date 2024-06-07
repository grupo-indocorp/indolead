<div>
    <!-- Button trigger modal -->
    <button type="button" class="btn bg-gradient-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" id="btnmodal" style="display: none">
        Modal
    </button>
      
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="cliente_id" name="cliente_id" value="">
                    <div class="row">
                        <div class="col-8">
                            <div class="card">
                                <div class="card-header p-0 mx-3 mt-3 position-relative z-index-1">
                                    <div class="row">
                                        <div class="col">
                                            <h4>Datos Del Cliente</h4>
                                        </div>
                                        <div class="col text-right">
                                            <button type="button" class="btn bg-gradient-secondary" onclick="editarCliente()" id="btn_editar_cliente">Editar</button>
                                            <button type="button" class="btn bg-gradient-secondary" onclick="guardarCliente()" id="btn_guardar_cliente" disabled>Guardar</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body pt-2">
                                    <div class="form-group">
                                        <label for="ruc" class="form-control-label">Ruc</label>
                                        <input class="form-control" type="text" id="ruc" name="ruc" required disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="razon_social" class="form-control-label">Razón Social</label>
                                        <input class="form-control" type="text" id="razon_social" name="razon_social" required disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="ciudad" class="form-control-label">Ciudad</label>
                                        <input class="form-control" type="text" id="ciudad" name="ciudad" required disabled>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="card">
                                <div class="card-header p-0 mx-3 mt-3 position-relative z-index-1">
                                    <h4>Contactos</h4>
                                </div>
                                <div class="card-body pt-2">
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="nombre" class="form-control-label">Nombre:</label>
                                                <input class="form-control" type="text" id="nombre" name="nombre" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="celular" class="form-control-label">Celular:</label>
                                                <input class="form-control" type="text" id="celular" name="celular" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="cargo" class="form-control-label">Cargo:</label>
                                                <input class="form-control" type="text" id="cargo" name="cargo" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="fecha_proximo" class="form-control-label">Fecha Próximo:</label>
                                                <input class="form-control" type="date" id="fecha_proximo" name="fecha_proximo" required>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="table-responsive">
                                                <table class="table align-items-center mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nombre</th>
                                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Celular</th>
                                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Cargo</th>
                                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Fecha Próximo</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="contactos"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="card">
                                <div class="card-header p-0 mx-3 mt-3 position-relative z-index-1">
                                    <h4>Comentarios</h4>
                                </div>
                                <div class="card-body pt-2">
                                    <div class="form-group">
                                        <textarea class="form-control" rows="3" id="comentario" name="comentario" required></textarea>
                                    </div>
                                    <button type="button" class="btn bg-gradient-secondary" onclick="guardarComentario()">Agregar</button>
                                    <div class="flex-auto">
                                        <ul class="flex flex-col rounded-lg" id="comentarios"></ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card">
                                <div class="card-header p-0 mx-3 mt-3 position-relative z-index-1">
                                    <h4>DATOS ADICIONALES</h4>
                                </div>
                                <div class="card-body pt-2">
                                    <div class="form-group">
                                        <label for="wick" class="form-control-label">Wick</label>
                                        <input class="form-control" type="text" id="wick" name="wick" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="lineas_claro" class="form-control-label">Lineas Claro</label>
                                        <input class="form-control" type="text" id="lineas_claro" name="lineas_claro" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="lineas_entel" class="form-control-label">Lineas Entel</label>
                                        <input class="form-control" type="text" id="lineas_entel" name="lineas_entel" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="lineas_bitel" class="form-control-label">Lineas Bitel</label>
                                        <input class="form-control" type="text" id="lineas_bitel" name="lineas_bitel" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="tipo_cliente" class="form-control-label">Tipo Cliente</label>
                                        <input class="form-control" type="text" id="tipo_cliente" name="tipo_cliente" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="ejecutivo_salesforce" class="form-control-label">Ejecutivo Salesforce</label>
                                        <input class="form-control" type="text" id="ejecutivo_salesforce" name="ejecutivo_salesforce" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="agencia" class="form-control-label">Agencia</label>
                                        <input class="form-control" type="text" id="agencia" name="agencia" disabled>
                                    </div>
                                    <button type="button" class="btn bg-gradient-secondary" onclick="editarMovistar()" id="btn_editar_movistar">Editar</button>
                                    <button type="button" class="btn bg-gradient-secondary" onclick="guardarMovistar()" id="btn_guardar_movistar" disabled>Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Salir</button>
                    <button type="button" class="btn bg-gradient-primary" onclick="guardarModal()">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>
