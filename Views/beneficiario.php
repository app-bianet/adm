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
            <th class="text-center" style="width:100px">Rif</th>
            <th class="text-center" style="width:120px">Saldo</th>
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
              <label for="cod_beneficiario">Código</label>
              <input type="textc" id="cod_beneficiario" name="cod_beneficiario" 
              class="form-control" placeholder="Código">
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-2 col-xs-2">
              <label for="idmoneda">Tabulador de I.S.L.R.</label>
              <select name="idimpuestoz" id="idimpuestoz" class="form-control selectpicker"></select>
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
            <div class="form-group col-lg-2 col-md-2 col-sm-4 col-xs-4">
              <input type="text" id="rif" name="rif" class="form-control" placeholder="Rif">
            </div>
            <div class="form-group col-lg-6 col-md-6 col-sm-8 col-xs-8">
              <input type="text" id="desc_beneficiario" name="desc_beneficiario" class="form-control" placeholder="Descripción">
            </div>
            <div class="form-row col-lg-12 col-md-12 col-sm-12 col-xs-12 nomargin">
            </div>
            <div class="form-group col-lg-5 col-md-5 col-sm-8 col-xs-8">
              <input type="text" id="direccion" name="direccion" class="form-control" placeholder="Dirección">
            </div>
            <div class="form-group col-lg-3 col-md-3 col-sm-2 col-xs-2">
              <input type="text" id="telefono" name="telefono" class="form-control" placeholder="Teléfono">
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 padd-top">
              <input type="text" id="idbeneficiario" name="idbeneficiario" class="hidden">
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


