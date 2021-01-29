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
          <input type="search" class="filtro_buscar form-control form-control-sm" id="filtro_buscar" placeholder="Buscar">
          <div class="input-group-append">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
          </div>
        </div>
      <form name="tableForm" id="tableForm">
        <table id="tbdetalle" class="table table-bordered table-hover compact table-sm table-striped" style="width:100% !important;">
          <thead class="bg-blue">
            <th style="width:120px" class="text-center nd">Opciones</th>
            <th style="width:150px" class="text-center">Código</th>
            <th class="text-center">Descripción</th>
            <th style="width:50px;font-size:10px" class="nd text-center">Inventario</th>
            <th style="width:50px;font-size:12px" class="nd text-center">Compra</th>
            <th style="width:50px;font-size:12px" class="nd text-center">Venta</th>
            <th style="width:50px;font-size:12px" class="nd text-center">Banco</th>
            <th style="width:50px;font-size:12px" class="nd text-center">Config</th>
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
              <label for="cod_operacion">Código</label>
              <input type="textc" id="cod_operacion" name="cod_operacion" 
              class="form-control form-control-border form-control-sm" placeholder="Código">
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
            </div>
            <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-8">
              <label for="desc_operacion">Descripción</label>
              <input type="text" id="desc_operacion" name="desc_operacion" 
              class="form-control form-control-border form-control-sm" placeholder="Descripción">
            </div>
            <div class="form-group col-lg-8 col-md-8 col-sm-12 col-xs-12 nomargin">
              <table id="tbopciones" class="table table-bordered table-hover compact table-sm table-striped nomargin">
                      <thead class="bg-gray">
                        <th class="nd text-center" style="width:110px">Es Inventario</th>
                        <th class="nd text-center" style="width:110px">Es Compra</th>
                        <th class="nd text-center" style="width:110px">Es Venta</th>
                        <th class="nd text-center" style="width:110px">Es Banco</th>
                        <th class="nd text-center" style="width:110px">Es Config</th>
                      </thead>
                    </table>
              </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 padd-top">
              <input type="text" id="idoperacion" name="idoperacion" class="hidden">
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


