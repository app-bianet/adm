<div class="modal fade" id="modalProveedor" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" id="myModalTitle">Seleccionar Proveedor</h6>
      </div>
      <div class="modal-body table no-padd-top">
        <table id="tbproveedor" class="table table-bordered table-hover
         compact table-sm table-striped table-responsive" style="width:100% !important;">
          <thead class="bg-primary">
            <th class="text-center">Add</th>
            <th class="text-center">Código</th>
            <th class="text-center">Descripción</th>
            <th class="text-center">Rif</th>
            <th class="text-center">Cond. Pago</th>
          </thead>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" id="btnCerrarModalp">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalCrearArticulo" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"> Seleccionar Artículos</h5>
      </div>
      <div class="modal-body">
        <div class="no-padd-top table-responsive">
          <table id="" class="table table-bordered table-hover compact table-sm table-striped" style="width:100%;">
            <thead class="bg-primary">
              <tr>
                <th style="text-align:center; width:100px;" class="nd">Código</th>
                <th style="text-align:center; width:290px;">Artículo</th>
                <th style="text-align:center; width:90px;" class="nd">Unidad</th>
                <th style="text-align:center; width:80px;" class="nd">Cantidad</th>
              </tr>
            </thead>
            <tbody>
              <tr class="">
                <td style="width:100px;" class="no-padding">
                  <input id="cod_articulom" class="form-control form-control-sm control" style="height: calc(1.650rem);border:none;"></td>
                <td style="width:290px;" class="no-padding">
                  <input id="desc_articulom" class="form-control form-control-sm control" style="height: calc(1.650rem);border:none;"></td>
                <td style="width:100px;" class="no-padding">
                  <select id="idartunidad" class="form-control form-control-sm control" style="height: calc(1.650rem);border:none;"></select></td>
                <td style="width:80px;" class="no-padding">
                  <input id="cantidadm" class="form-control text-right form-control-sm control" style="height: calc(1.650rem);border:none;"></td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
              </tr>
            </tfoot>
          </table>
          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 hidden">
            <input type="text" name="" id="costom" class="control"> 
            <input type="text" name="" id="desc_unidad" class="control" value="0">
            <input type="text" name="" id="valorund" class="control">
            <input type="text" name="" id="tipom" class="control">
            <input type="text" name="" id="stockm" class="control">
            <input type="text" name="" id="tasam" class="control">
            <input type="text" name="" id="idarticulom" class="control">
            <input type="text" name="" id="iddepositom" class="control">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-sm btnm" id="btnAceptarM">Aceptar</button>
        <button type="button" class="btn btn-danger btn-sm btnm" data-dismiss="modal" id="btnCancelarM">Cancelar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalArticulo" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"> Seleccionar Artículos</h5>
      </div>
      <div class="modal-body no-padd-top">
        <table id="tbarticulos" class="table table-bordered table-hover compact table-sm table-striped table-responsive" style="width:100%">
          <thead class="btn-primary">
            <th style="text-align:center;" class="nd">Add</th>
            <th style="text-align:center;">Cod. Artículo</th>
            <th style="text-align:center;">Descripción</th>
            <th style="text-align:center;">Referencia</th>
            <th style="text-align:center;" class="nd">Stock</th>
            <th style="text-align:center;" class="nd">Costo</th>
          </thead>
        </table>
      </div>
      <div class="modal-footer" style="padding:6px">
        <button type="button" class="btn btn-danger btn-sm btnm" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalProveedorNuevo" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="width:550px;">
      <div class="modal-header">
        <h5 class="modal-title"> Registrar Proveedor</h5>
      </div>
      <div class="modal-body">
        <form id="dataProveeedor">
          <div class="row">
            <div class="form-group col-lg-5 col-md-5 col-sm-6 col-xs-6">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span for="cod_proveedori" class="input-group-text">Código:</span>
                </div>
                  <input type="text" id="cod_proveedori" name="cod_proveedori" class="form-control" placeholder="Código">
              </div>    
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-6">  
              <div class="input-group">
                <div class="input-group-prepend">
                  <span for="rifi" class="input-group-text">Rif:</span>
                </div>
                  <input type="text" id="rifi" name="rifi" class="form-control" placeholder="Rif">
              </div>         
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
              <div class="input-group">
                <div class="input-group-prepend">
                  <span for="desc_proveedori" class="input-group-text">Descripción:</span>
                </div>
                  <input type="text" id="desc_proveedori" name="desc_proveedori" class="form-control" placeholder="Descripción">
              </div>  
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
              <div class="input-group">
                <div class="input-group-prepend">
                  <span for="direccion" class="input-group-text">Dirección:</span>
                </div>
                  <input type="text" id="direccion" name="direccion" class="form-control" placeholder="Dirección">
              </div> 
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer no-padd-top">
        <button type="button" class="btn btn-success btn-sm btnm" id="btnGuardarProveedor">Aceptar</button>
        <button type="button" class="btn btn-danger btn-sm btnm" id="btnCerrarP">Cancelar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalImportar" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"> Importar Documentos</h5>
          <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12 float-left">
            <div class="input-group">
              <div class="input-group-prepend">
              <span for="" class="input-group-text">Importar Desde:</span>
              </div>
              <select id="tipodoc" name="tipodoc" class="form-control">
                <option value="Cotizacion">Cotización</option>
                <option value="Pedido">Pedido</option>
                <option value="Factura">Factura</option>
              </select>
            </div>
          </div>
          <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12 no-paddm">
            <div class="input-group">
              <div class="input-group-prepend">
              <span for="estatusdoc" class="input-group-text">Estado:</span>
              </div>
              <select id="estatusdoc" name="estatusdoc" class="form-control">
                <option selected="selected" value="sinp">Sin Procesar</option>
                <option value="todos">Todos</option>
              </select>
            </div>
          </div>
      </div>
      <div class="modal-body no-padd-top table-responsive">
        <table id="tbdocumento" class="table table-bordered table-hover compact table-sm table-striped table-responsive" style="width:100%">
          <thead class="btn-primary">
            <th style="width:25px;"  class="text-center">Add</th>
            <th style="width:80px;"  class="text-center">Emisión</th>
            <th style="width:110px;" class="text-center">Estado</th>
            <th style="width:100px;" class="text-center">Código</th>
            <th style="width:400px;" class="text-center">Proveedor</th>
            <th style="width:95px;"  class="text-center">Rif</th>
            <th style="width:100px;" class="text-center">N° Doc.</th>
            <th style="width:150px;" class="text-center">Monto</th>
          </thead>
        </table>
      </div>
      <div class="modal-footer" style="padding:6px">
        <button type="button" class="btn btn-danger btn-sm btnm" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>




