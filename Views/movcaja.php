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
            <th class="text-center">Opciones</th>
            <th class="text-center">fechareg</th>
            <th style="width:150px" class="text-center">Código</th>
            <th class="text-center">Caja</th>
            <th class="text-center">Tipo</th>
            <th class="text-center">Forma</th>
            <th class="text-center" style="font-size:small;">N° de Mov.</th>
            <th class="text-center">Monto</th>
            <th class="text-center">Estado</th>
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
                  <span for="cod_movcaja" class="input-group-text">Código:</span>
                </div>
                <input type="text" id="cod_movcaja" name="cod_movcaja" class="form-control" placeholder="Código">
              </div>
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-6">
              <div class="input-group">
                <div class="input-group-prepend">
                <span for="origen" class="input-group-text">Origen:</span>
                </div>
                <input type="textx" id="origen" name="origen" class="form-control" placeholder="Origen" readonly>
              </div>
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-6">
              <div class="input-group">
                <div class="input-group-prepend">
                <span for="estatus" class="input-group-text">Estatus:</span>
                </div>
                <input type="textx" id="estatus" name="estatus" class="form-control" placeholder="Estatus" readonly>
              </div>
            </div>
            <div class="form-group col-lg-1 col-md-1 col-sm-12 col-xs-12">
            </div>
            <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text small">Fecha Registro:</span>
                </div>
                <input type="text" name="fechareg" id="fechareg" class="form-control date ffecha">
                <div class="input-group-append input-group-text">
                  <i class="fa fa-calendar text-danger "></i>
                </div>
              </div>
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
              <div class="input-group">
                <div class="input-group-prepend">
                <span for="estatus" class="input-group-text">Caja:</span>
                </div>
                  <input type="textx" id="cod_caja" class="form-control" placeholder="Cod. de Caja" readonly>
              </div>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-6">
              <select name="idcaja" id="idcaja" class="form-control selectop">
              </select>
            </div>
            <div class="form-group col-lg-1 col-md-1 col-sm-12 col-xs-12">
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-4 col-xs-4">
              <div class="input-group">
                <div class="input-group-prepend">
                <span for="forma" class="input-group-text">Forma:</span>
                </div>
                <select id="forma" name="forma" class="form-control selectop">
                  <option value="Efectivo">Efectivo</option>
                  <option value="Cheque">Cheque</option>
                  <option value="Tarjeta">Tarjeta</option>
                </select>
              </div>
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-4 col-xs-4">
              <div class="input-group">
                <div class="input-group-prepend">
                <span for="tipo" class="input-group-text">Tipo:</span>
                </div>
                <select id="tipo" name="tipo" class="form-control selectop">
                  <option value="Ingreso">Ingreso</option>
                  <option value="Egreso">Egreso</option>
                </select>
              </div>
            </div>
            <div class="form-group col-lg-7 col-md-7 col-sm-12 col-xs-12"> 
              <select class="form-control selectpicker" name="idbanco" id="idbanco" placeholder="Banco" disabled>
              </select>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-8 col-xs-8">
              <div class="input-group">
                <div class="input-group-prepend">
                <span for="numeroc" class="input-group-text">N° Doc. Banco</span>
              </div>
                <input type="textx" name="numeroc" id="numeroc" class="form-control idbanco" placeholder="N° Documento de Banco" readonly>
              </div>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
              <div class="input-group">  
                <div class="input-group-prepend">
                  <span class="input-group-text small">Tipo de Op.: </span>
                </div>  
                <select name="idoperacion" id="idoperacion" class="form-control selectop"></select>
              </div>
            </div>
            <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
              <input type="text" name="numerod" id="numerod" class="form-control opi" placeholder="N° de Operacion" >
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
              <div class="input-group">
                <div class="input-group-prepend">
                <span for="monto" class="input-group-text">Monto:</span>
                </div>
                <input type="text" id="monto" name="monto" class="form-control nformat" placeholder="0.00">
              </div>
            </div>
            <div class="form-group col-lg-9 col-md-9 col-sm-12 col-xs-12">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span for="desc_movcaja" class="input-group-text">Descripción</span>
                </div>
                  <input type="text" name="desc_movcaja" id="desc_movcaja" class="form-control" maxlength="250" placeholder="Descripción">
              </div>       
            </div>
            <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
              <label class="checkbox-inline" for="saldoinicial">
              <input type="checkbox" id="saldoinicial" name="saldoinicial" class="checkbox-inline chk"> Es Saldo Inicial </label>   
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 padd-top">
                <input type="text" name="idmovcaja" id="idmovcaja" class="hidden">
                <input type="textx" name="saldototal" id="saldototal" class="hidden">
                <input type="hidden" id="montod" name="montod">
                <input type="hidden" id="montoh" name="montoh">
                <input name="idusuario" id="idusuario" value=<?= base64_decode($_SESSION['sidusuario']);?> class="hidden">
              <button class="btn btn-primary btn-sm btnm" type="submit" id="btnGuardar"><i class="fa fa-arrow-circle-up"></i> Guardar</button>
              <button class="btn btn-success btn-sm btnm" type="button" id="btnEditar"><i class="fa fa-arrow-circle-left"></i>  Editar </button>
              <button class="btn btn-danger btn-sm btnm" type="button" id="btnCancelar"><i class="fa  fa-arrow-circle-down"></i> Cancelar</button> 
            </div>
          </div>
        </form>
      </div>
      </div>
    </section>
  </div>
<?php footerAdmin($data);?>


