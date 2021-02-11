<?php headerAdmin($data);?>
  <div class="content-wrapper">
    <section class="content">
      <div class="card">
      <div class="card-header">
        <span class="card-text" style="margin-right: 10px;"><b><?= $data['page_tag'];?></b></span>
        <div class="btnhead card-tools">
          <button class="btn btn-sm btn-success btnm" id="btnAgregar"> Agregar <i class="fa fa-plus-circle"></i></button>
          <button class="btn btn-sm btn-primary btnm" id="btnReporte">Reporte <i class="fa fa-file"></i></button>
          <button class="btn btn-sm bg-purple btnm" id="btnOmportar">Importar <i class="fa fa-file-excel"></i></button>
        </div>  
      </div>
      <div class="card-body table-responsive no-paddm" id="listado">
        <div class="input-group search col-8">
          <input type="search" class="filtro_buscar form-control" id="filtro_buscar" placeholder="Buscar">
          <div class="input-group-append">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
          </div>
        </div>
      <form name="tableForm" id="tableForm">
        <table id="tbdetalle" class="table table-bordered table-hover compact table-sm table-striped" style="width:100% !important;">
          <thead class="bg-blue">
            <th style="width:120px" class="text-center">Opciones</th>
            <th style="width:100px" class="text-center">Fecha</th>
            <th style="width:150px" class="text-center">Código</th>
            <th class="text-center">Dep. Origen</th>
            <th class="text-center">Dep. Destino</th>
            <th style="width:150px" class="text-center">Total</th>
            <th style="width:100px" class="text-center">Estado</th>
          </thead> 
        </table>
        </form>
      </div>
      <div class="card-body visible-op" id="formulario">
        <form id="dataForm" name="dataForm">
          <div class="form-row">
            <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-6">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span for="cod_traslado" class="input-group-text">Código</span>
                </div>
                <input type="textc" id="cod_traslado" name="cod_traslado" class="form-control" placeholder="Código">
              </div>
            </div>
            <div class="form-group col-lg-8 col-md-8 col-sm-12 col-xs-12">
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text small">Fecha :</span>
                </div>
                <input type="text" name="fechareg" id="fechareg" class="form-control date ffecha">
              </div>
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-6">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span for="estatus" class="input-group-text">Estatus</span>
                </div>
                <input type="textx" id="estatus" name="estatus" class="form-control" placeholder="Estatus" readonly>
              </div>
            </div>
            <div class="form-group col-lg-10 col-md-10 col-sm-12 col-xs-12">
              <div class="input-group">
                <div class="input-group-prepend">
                <span for="deposito" class="input-group-text">Descripción: </span>
                </div>
              <input type="text" id="desc_traslado" name="desc_traslado" class="form-control" placeholder="Descripción">
              </div>
            </div>
            <div class="form-group col-lg-5 col-md-5 col-sm-6 col-xs-6">
              <div class="input-group">
                <div class="input-group-prepend">
                <span for="deposito" class="input-group-text">Deposito de Origen: </span>
                </div>
                <select id="iddepositoi" name="iddepositoi" class="form-control selectpicker">
                </select>
              </div>
            </div>
            <div class="form-group col-lg-5 col-md-5 col-sm-6 col-xs-6">
              <div class="input-group">
                <div class="input-group-prepend">
                <span for="deposito" class="input-group-text">Deposito de Destino: </span>
                </div>
                <select id="iddeposito" name="iddeposito" class="form-control selectpicker">
                </select>
              </div>
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8">          
              <button id="btnAgregarArt" type="button" class="btn btn-primary btn-sm form-control form-control-sm" disabled> 
                Agregar Artículos <i class="fa fa-truck"></i></button>
            </div>
            <div class="table-responsive no-padd-top">
              <table id="tbdetalles" class="table table-bordered table-hover compact table-sm table-striped" 
              style="width:100% !important;">                   
                <thead class="bg-primary">
                  <th style="width:25px;" class="text-center">E</th>
                  <th style="width:150px;" class="text-center">Código</th>
                  <th style="width:350px;" class="text-center">Artículo</th>
                  <th style="width:80px;" class="text-center">Unidad</th>
                  <th style="width:90px;" class="text-center">Cantidad</th>
                  <th style="width:140px;" class="text-center">Costo</th>
                  <th style="width:150px;" class="text-center">Total Reng.</th>
                </thead>                                   
              </table>
            </div>
            <div class="no-padd-top table-responsive">
              <table class="table compact table-sm" style="width:100% !important;">
                <thead class="bg-gray">
                  <th class=""></th>
                  <th style="min-width:200px" class="text-center">Total Costo <span id="lbcod_moneda"></span></th>
                  <th style="width:10px"></th>
                </thead>
                <tfoot class=" bg-primary">
                  <th class="bg-lightblue"></th>
                  <th style="width:200px" class="text-right"><span id="totalv" class="nformat">0.00</span></th>
                  <th style="width:10px"></th>
                </tfoot>
              </table>
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 padd-top">
              <input type="text" id="idtraslado" name="idtraslado" class="hidden">
              <input type="hidden" id="idusuario" name="idusuario" value=<?php echo base64_decode($_SESSION['sidusuario']);?>>
              <input type="hidden" name="totalh" id="totalh">
              <input type="hidden" name="contador" id="contador">
              <button class="btn btn-primary btn-sm btnm" type="submit" id="btnGuardar"><i class="fa fa-arrow-circle-up"></i> Guardar</button>
              <button class="btn btn-danger btn-sm btnm" type="button" id="btnCancelar"><i class="fa  fa-arrow-circle-down"></i> Cancelar</button> 
            </div>
          </div>
        </form>
      </div>
      </div>
    </section>
  </div>
  <div class="modal fade" id="ModalCrearArticulo" tabindex="-1" role="dialog" aria-labelledby="myModal-label" aria-hidden="true">
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
                  <input type="text" name="" id="cod_articulom" class="form-control form-control-sm control" style="height: calc(1.690rem);border:none;"></td>
                  <td style="width:290px;" class="no-padding">
                  <input type="text" name="" id="desc_articulom" class="form-control form-control-sm control" style="height: calc(1.690rem);border:none;"></td>
                  <td style="width:100px;" class="no-padding">
                  <select id="idartunidad" class="form-control form-control-sm control" style="height: calc(1.690rem);border:none;"></select></td>
                  <td style="width:80px;" class="no-padding">
                  <input type="text" name="cantidadm" id="cantidadm" class="form-control text-right form-control-sm control" style="height: calc(1.690rem);border:none;"></td>
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
              <input type="text" name="" id="iddeporigen" class="control">
              <input type="text" name="" id="desc_unidad" class="control" value="0">
              <input type="text" name="" id="valorund" class="control">
              <input type="text" name="" id="tipom" class="control">
              <input type="text" name="" id="stockm" class="control">
              <input type="text" name="" id="dispdestino" class="control">
              <input type="text" name="" id="idarticulom" class="control">

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


  <div class="modal fade" id="ModalArticulo" tabindex="-1" role="dialog" aria-labelledby="myModal-label" aria-hidden="true">
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
<?php footerAdmin($data);?>


