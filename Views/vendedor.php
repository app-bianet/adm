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
            <th class="text-center nd" style="width:120px" >Opciones</th>
            <th class="text-center" style="width:150px" >Código</th>
            <th class="text-center">Descripción</th>
            <th class="nd text-center" style="width:80px;font-size:12px">Vendedor</th>
            <th class="nd text-center" style="width:80px;font-size:12px">Comis. %</th>
            <th class="nd text-center" style="width:80px;font-size:12px">Cobrador</th>
            <th class="nd text-center" style="width:80px;font-size:12px">Comis. %</th>
            <th style="width:80px" class="text-center nd">
            <button type="button" class="btn btn-xs btn-danger btnEliminar" 
            data-toggle="tooltip" data-placement="right" title="Eliminar">Eliminar</button>
            </th>
            <th style="width:100px" class="text-center nd">Estado</th>
          </thead>      
        </table>
        </form>
      </div>
      <div class="card-body visible-op" id="formulario">
        <form id="dataForm" name="dataForm">
          <div class="form-row">
            <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-6">
              <label for="cod_vendedor">Código</label>
              <input type="textc" id="cod_vendedor" name="cod_vendedor" 
              class="form-control form-control-border" placeholder="Código">
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
              <label for="fechareg">Fecha de Registro</label>
              <div class="input-group date">
                <input type="text" class="form-control ffecha" name="fechareg" id="fechareg">
                <div class="input-group-append input-group-text">
                  <i class="fa fa-calendar"></i>
                </div>
              </div>
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 nomargin">
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8">
              <input type="text" id="rif" name="rif" 
              class="form-control form-control-border" placeholder="Rif">
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-8 col-xs-8">
              <input type="text" id="desc_vendedor" name="desc_vendedor" 
              class="form-control form-control-border" placeholder="Descripción">
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-8 col-xs-8">
              <input type="text" id="telefono" name="telefono" 
              class="form-control form-control-border" placeholder="Teléfono">
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 nomargin">
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-4 col-xs-4 no-paddm">
              <label class="checkbox-inline">
              <input type="checkbox" id="esvendedor" name="esvendedor" 
              class="checkbox-inline chk"> Es vendedor</label>   
            </div>
            <div class="form-group col-lg-3 col-md-2 col-sm-6 col-xs-6">
              <div class="input-group input-group-sm">
                <div class="input-group-prepend"><span class="input-group-text small"> Comisión por Ventas(%):</span>
                </div>          
                <input type="text" class="form-control nformatm" name="comisionv" id="comisionv">
              </div>
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 nomargin">
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-4 col-xs-4">
              <label class="checkbox-inline">
              <input type="checkbox" id="escobrador" name="escobrador" 
              class="checkbox-inline chk"> Es Cobrador</label>   
            </div>
            <div class="form-group col-lg-3 col-md-2 col-sm-6 col-xs-6">
              <div class="input-group input-group-sm">
                <div class="input-group-prepend"><span class="input-group-text small"> Comisión por Cobros(%):</span>
                </div>          
                <input type="text" class="form-control nformatm" name="comisionc" id="comisionc">
              </div>
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 padd-top">
              <input type="text" id="idvendedor" name="idvendedor" class="hidden">
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


