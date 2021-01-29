<div class="modal fade" id="ModalUnidad" tabindex="-1" role="dialog" aria-labelledby="myModal-label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content"  style="width:600px;">
      <div class="modal-header">
        <h5 class="modal-title" id="Uarticulo"></h5>
      </div>
      <div class="card-body table">
        <table id="tbunidad" class="table table-bordered table-hover compact table-sm table-striped" 
        style="width:100% !important;">
          <thead class="bg-gray">
            <th class="text-center" style="width: 20%;">Opciones</th>
            <th class="text-center">Unidad</th>
            <th class="text-center" style="width: 10%;">Valor</th>
            <th class="text-center" style="width: 10%;">Es Principal</th>
          </thead>
        </table>
      </div>
      <div class="card-body form">
        <form id="formUnidad">
          <input type="text" id="idarticulou" name="idarticulou" class="hidden">  
          <input type="text" id="idartunidad" name="idartunidad" class="hidden">  
          <div class="form-row">
            <div class="form-group col-lg-7 col-md-7 col-sm-7 col-xs-12">
              <div class="input-group input-group-sm">  
                <div class="input-group-prepend">
                  <span class="input-group-text small">Unidad: </span>
                </div>  
                <select id="idunidad" name="idunidad" class="form-control">
                </select>
              </div>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
              <div class="input-group">  
                <div class="input-group-prepend input-group-sm">
                  <span class="input-group-text small">Valor: </span>
                </div>  
                <input type="text" id="valor" name="valor" class="form-control nformat" placeholder="0.00">
              </div>
            </div>
            <div class="form-group col-lg-7 col-md-7 col-sm-7 col-xs-7">
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
              <span class="input-group-addon"><label> Es Unidad Principal:</label>
                <input type="checkbox" name="principal" id="principal" class="checkbox-inline chk">
              </span>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-sm btnm" id="btnGuardarUnidad">Guardar</button>
        <button type="button" class="btn btn-success btn-sm btnm" id="btnAgregarUnidad">Agregar</button>
        <button type="button" class="btn btn-danger btn-sm btnm" id="btnCancelarUnidad">Cancelar</button>
        <button type="button" class="btn btn-secondary btn-sm btnm" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="ModalPrecio" tabindex="-1" role="dialog" aria-labelledby="myModal-label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="width:650px;">
      <div class="modal-header">
        <h5 class="modal-title" id="Particulo"></h5>
      </div>
      <div class="card-body nomargin">
        <form id="formPrecio" name="formPrecio">
          <div class="form-row">
            <input type="hidden" name="idarticulop" id="idarticulop">
            <input type="hidden" name="idartprecio" id="idartprecio">
            <div class="input-group col-lg-7 col-md-7 col-sm-7 col-xs-12">
              <div class="input-group input-group-sm">  
                <div class="input-group-prepend">
                  <span class="input-group-text small">Tipo de Precio: </span>
                </div>  
                <select id="idtipoprecio" name="idtipoprecio" class="form-control">
                </select>
              </div>
            </div>
            <div class="input-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
              <div class="input-group input-group-sm">  
                <div class="input-group-prepend">
                  <span class="input-group-text small">Moneda: </span>
                </div>  
                <select id="idmoneda" name="idmoneda" class="form-control">
                </select>
              </div>
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
            </div>
            <div class="form-group col-lg-5 col-md-6 col-sm-6 col-xs-12">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text small">Fecha Reg. :</span>
                </div>
                  <input type="text" name="fecharegp" id="fecharegp" class="form-control date ffecha">
                <div class="input-group-append input-group-text">
                  <i class="fa fa-calendar text-danger "></i>
                </div>
              </div>
            </div>
            <div class="form-group col-lg-7 col-md-7 col-sm-12 col-xs-12">
              <div class="input-group">  
                <div class="input-group-prepend input-group-sm">
                  <span class="input-group-text small">Precio Neto: </span>
                </div>  
                <input type="text" id="preciom" name="preciom" class="form-control nformat" placeholder="0.00">
              </div>
            </div>
            <div class="form-group col-lg-5 col-md-6 col-sm-6 col-xs-12">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text small">Fecha Venc.:</span>
                </div>
                  <input type="text" name="fechavenp" id="fechavenp" class="form-control date ffecha">
                <div class="input-group-append input-group-text">
                  <i class="fa fa-calendar text-danger "></i>
                </div>
              </div>
            </div>
            <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
              <div class="input-group">  
                <div class="input-group-prepend input-group-sm">
                  <span class="input-group-text small">Margen (%): </span>
                </div>  
                <input type="text" id="margenm" name="margenm" class="form-control nformat" placeholder="0.00" max="100">
              </div>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
              <span class="input-group-addon" style="text-align:right"><label>Aplica Vencimiento:</label>
                <input type="checkbox" name="vencprecio" id="vencprecio" class="checkbox-inline chk">
              </span>
            </div>
            <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-12">
            </div>
            <div class="form-group col-lg-7 col-md-7 col-sm-7 col-xs-12">
              <div class="input-group">  
                <div class="input-group-prepend input-group-sm">
                  <span class="input-group-text small">Precio + MG: </span>
                </div>  
                <input type="text" id="margent" class="form-control nformat" placeholder="0.00">
              </div>
            </div>
            <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
            </div>
            <div class="form-group col-lg-7 col-md-7 col-sm-7 col-xs-12">
              <div class="input-group">  
                <div class="input-group-prepend input-group-sm">
                  <span class="input-group-text small">Impuesto: </span>
                </div>  
                <input type="text" id="impuestot" class="form-control nformat" placeholder="0.00">
              </div>
            </div>
            <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
            </div>
            <div class="form-group col-lg-7 col-md-7 col-sm-7 col-xs-12">
              <div class="input-group">  
                <div class="input-group-prepend input-group-sm">
                  <span class="input-group-text small">Total Precio: </span>
                </div>  
                <input type="text" id="preciot" class="form-control nformat" placeholder="0.00">
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-sm btnm float-left" id="btnGuardarPrecio">Guardar</button>
        <button type="button" class="btn btn-danger btn-sm btnm" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="Iarticulo"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>

