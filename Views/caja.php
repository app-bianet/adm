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
            <th style="width:150px" class="text-center">Código</th>
            <th class="text-center">Descripción</th>
            <th class="text-center">Moneda</th>
            <th class="text-center">Saldo</th>
            <th style="width:80px" class="text-center">
              <button type="button" class="btn btn-xs btn-danger btnEliminar">Eliminar</button>
            </th>
            <th style="width:100px" class="text-center">Estado</th>
          </thead>      
        </table>
        </form>
      </div>
      <div class="card-body visible-op" id="formulario">
        <form id="dataForm" name="dataForm">
          <div class="form-row">
            <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-6">
              <label for="cod_caja">Código</label>
              <input type="textc" id="cod_caja" name="cod_caja" 
              class="form-control" placeholder="Código">
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-2 col-xs-2">
              <label for="idmoneda">Moneda</label>
              <select name="idmoneda" id="idmoneda" class="form-control selectpicker"></select>
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-6">
              <label for="fechareg">Fecha de Registro</label>
              <div class="input-group">
                <input type="text" name="fechareg" id="fechareg" class="form-control date ffecha">
                <div class="input-group-append input-group-text"><i class="fa fa-calendar text-danger "></i></div>
              </div>
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 nomargin">
            </div>
            <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-8">
              <input type="text" id="desc_caja" name="desc_caja" class="form-control" placeholder="Descripción">
            </div>
            <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-8">
              <div class="card">
                <div class="card-header bg-primary form-control-sm">
                  <span class="card-text">Saldos</span>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                      <label for="exampleInput">Efectivo</label>
                      <input type="textx" class="form-control nformat" id="saldoefectivo" placeholder="0.00" readonly>
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                      <label for="exampleInput">Documentos</label>
                      <input type="textx" class="form-control nformat" id="saldodocumento" placeholder="0.00" readonly>
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                      <label for="exampleInput">Saldo Total</label>
                      <input type="textx" class="form-control nformat" id="saldototal" placeholder="0.00" readonly>
                    </div>
                </div>
              </div>
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 padd-top">
              <input type="text" id="idcaja" name="idcaja" class="hidden">
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


