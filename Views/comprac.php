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
      <div class="card-body no-paddm" id="listado">
        <div class="input-group search col-8">
          <input type="search" class="filtro_buscar form-control" id="filtro_buscar" placeholder="Buscar">
          <div class="input-group-append">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
          </div>
        </div>
      <form name="tableForm" id="tableForm">
        <table id="tbdetalle" class="table table-bordered table-hover compact table-sm table-striped" style="width:100% !important;">
          <thead class="bg-blue">
            <th class="text-center" style="width:120px" >Opciones</th>
            <th class="text-center" style="width:90px">F.Emisión</th>
            <th class="text-center" style="width:100px">Código</th>
            <th class="text-center">Proveedor</th>
            <th class="text-center" style="width:100px">Rif</th>
            <th class="text-center" style="min-width:120px">Cotización N°</th>
            <th class="text-center" style="width:180px">Total</th>
            <th class="text-center" style="width:60px">Estado</th>
          </thead>      
        </table>
        </form>
      </div>
      <div class="card-body visible-op" id="formulario">
        <form id="dataForm" name="dataForm">
          <div class="form-row">
            <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-6">
              <div class="input-group">
                <div class="input-group-prepend">
                <span for="cod_compra" class="input-group-text">Código:</span>
                </div>
                <input type="textc" id="cod_compra" name="cod_compra" class="form-control" placeholder="Código">
              </div>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span for="origend" class="input-group-text">Origen:</span>
                </div>
                <input type="textx" id="origend" name="origend" class="form-control" 
                placeholder="Doc. Origen" readonly value="Cotizacion">
                <div class="input-group-prepend">
                  <span for="origenc" class="input-group-text">N°:</span>
                </div>
                <input type="textx" id="origenc" name="origenc" class="form-control" placeholder="Número" readonly>
              </div>
            </div>
            <div class="form-group col-lg-5 col-md-5 col-sm-12 col-xs-12">
              <div class="input-group date">
                <div class="input-group-prepend">
                  <span class="input-group-text small">Fecha Registro:</span>
                </div>
                <input type="text" name="fechareg" id="fechareg" class="form-control date ffecha">
                <div class="input-group-prepend">
                  <span class="input-group-text small">Venc.:</span>
                </div>
                <input type="text" name="fechaven" id="fechaven" class="form-control date ffecha">
                <div class="input-group-append input-group-text">
                  <i class="fa fa-calendar text-danger "></i>
                </div>
              </div>
            </div>
            <div class="form-group col-lg-8 col-md-8 col-sm-12 col-xs-12">
              <div class="input-group">
              <input type="text" class="form-control" name="desc_proveedor" id="desc_proveedor" 
                maxlength="250" placeholder="Proveedor" autocomplete="off">
                <span class="input-group-append">
                  <button type="button" class="btn btn-xs btn-primary" id="btnNuevoProveedor">Nuevo</button>
                </span>
              </div>
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8">
              <input type="textx" name="cod_proveedor" id="cod_proveedor" class="form-control" 
              placeholder="Código" readonly>
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8">
              <input type="textx" name="rif" id="rif" class="form-control" placeholder="Rif" readonly>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-8 col-xs-8">
              <div class="input-group">
                <div class="input-group-prepend">
                <span for="" class="input-group-text">Cond. de Pago:</span>
                </div>
                <select id="idcondpago" name="idcondpago" class="form-control selectpicker" disabled="disabled">
                </select>
              </div>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8">
              <input type="text" name="numerod" id="numerod" class="form-control iop" 
              placeholder="N° de Cotización" required="required">
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8">
            </div>
            <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-6">
            <div class="input-group">
              <div class="input-group-prepend">
                <span for="estatus" class="input-group-text">Estado:</span>
              </div>
                <input type="textx" id="estatus" name="estatus" class="form-control" placeholder="Estatus" readonly>
              </div>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
            </div>
            <div class="form-group col-lg-5 col-md-5 col-sm-12 col-xs-12">
            <div class="input-group">
              <div class="input-group-prepend">
              <span for="iddepositoh" class="input-group-text">Deposito:</span>
              </div>
              <select id="iddepositoh" name="iddepositoh" class="form-control selectpicker">
              </select>
              </div>
            </div>
            <div class="form-group col-lg-10 col-md-10 col-sm-12 col-xs-12">
              <div class="input-group">
                <div class="input-group-prepend">
                <span for="desc_compra" class="input-group-text"> Descripción: </span>
                </div>
                <input type="text" id="desc_compra" name="desc_compra" class="form-control" placeholder="Descripción">
              </div>
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8">          
              <button id="btnAgregarItem" type="button" class="btn btn-primary btn-sm" disabled> 
                Agregar Artículos <i class="fa fa-truck"></i></button>
            </div>
            <div class="table-responsive no-padd-top">
              <table class="table table-bordered table-hover compact table-sm table-striped" style="width:100% !important;">
                <thead class="bg-primary">
                  <th style="width:30px;" class="text-center">R</th>
                  <th style="width:120px;" class="text-center">Código</th>
                  <th style="width:400px;" class="text-center">Artículo</th>
                  <th style="width:90px;" class="text-center">Unidad</th>
                  <th style="width:80px;" class="text-center">Cant.</th>
                  <th style="width:120px;" class="text-center">Costo Und</th>
                  <th style="width:80px;" class="text-center">% Desc.</th>
                  <th style="width:130px;" class="text-center">Descuento</th>
                  <th style="width:130px;" class="text-center">Sub Total</th>
                  <th style="width:130px;" class="text-center">Imp.</th>
                  <th style="width:140px;" class="text-center">Total Reng.</th>
                </thead>
                <tbody id="tbdetalles">
                </tbody>
              </table>
            </div>
            <div class="no-padd-top" style="width:100% !important">
              <table class="table compact table-sm table-bordered">
                <thead class="bg-gray">
                  <th style="width:300px"><h6 class="text-center">Sub Total <span class="lbcod_moneda"></span></h6></th>
                  <th style="width:170px"><h6 class="text-center">Descuento <span class="lbcod_moneda"></span></h6></th>
                  <th style="width:170px"><h6 class="text-center">I.V.A. 16% <span class="lbcod_moneda"></span></h6></th>
                  <th style="width:170px"><h6 class="text-center">Total <span class="lbcod_moneda"></span></h6></th>  
                </thead>
              <tfoot class=" bg-gray-light">
                <th style="width:100px">
                  <span class="pull-left"><h6>Totales:</h6></span>
                  <h6 class="text-right"><span id="subtotalt" class="nformat"></span></h6>
                </th>
                <th><h6 class="text-right"><span id="desct" class="nformat"></span> </h6></th>
                <th><h6 class="text-right"><span id="impuestot" class="nformat"> </span></h6></th>
                <th><h6 class="text-right"><span id="totalt" class="nformat"> </span></h6></th> 
                </tfoot>
              </table>
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 padd-top">
              <input type="control" name="idcompra" id="idcompra" class="hidden">
              <input type="control" name="idcompraop" id="idcompraop" class="hidden">
              <input type="control" name="idproveedor" id="idproveedor" class="hidden">
              <input type="controln" name="desch" id="desch" class="hidden">
              <input type="controln" name="subtotalh" id="subtotalh" class="hidden">
              <input type="controln" name="impuestoh" id="impuestoh" class="hidden">
              <input type="controln" name="totalh" id="totalh" class="hidden">
              <input type="controln" name="saldoh" id="saldoh" class="hidden"> 
              <input type="control" name="limite" id="limite" class="hidden">
              <input type="control" name="dias" id="dias" class="hidden">
              <input type="hidden" name="idusuario" id="idusuario" value=<?= base64_decode($_SESSION['sidusuario']);?> class="hidden">
              <input type="hidden" name="tipo" id="tipo" value="Cotizacion" class="hidden">
              <button class="btn btn-primary btn-sm btnm" type="submit" id="btnGuardar"><i class="fa fa-arrow-circle-up"></i> Guardar</button>
              <button class="btn btn-success btn-sm btnm" type="button" id="btnImportar"><i class="fa fa-arrow-circle-left"></i> Importar</button>
              <button class="btn btn-danger btn-sm btnm" type="button" id="btnCancelar"><i class="fa fa-arrow-circle-down"></i> Cancelar</button> 
            </div>
          </div>
        </form>
      </div>
      </div>
    </section>
  </div>

<?php 
getModal('compramodal');
footerAdmin($data);
?>


