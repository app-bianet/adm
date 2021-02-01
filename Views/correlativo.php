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
          <table id="tbdetalle" class="table table-bordered table-hover table-sm table-striped display nowrap" style="width:100%">
            <thead class="bg-blue">
              <th style="width:120px" class="text-center nd">Opciones</th>
              <th style="width:150px" class="text-center">Código</th>
              <th class="text-center">Descripción</th>
              <th class="text-center">Operación</th>
              <th class="text-center" style="width:100px;">Tabla</th>
              <th class="text-center nd" style="width:50px;">Prefijo</th>  
              <th class="text-center nd" style="width:50px;">Cadena</th>
              <th class="text-center nd" style="width:50px;font-size:12px">Correlativo</th>
              <th class="text-center nd" style="width:50px;">Largo</th>
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
              <label for="cod_correlativo">Código</label>
              <input type="textc" id="cod_correlativo" name="cod_correlativo" 
              class="form-control form-control-border form-control-sm" placeholder="Código">
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-6">
              <label for="tabla">Tabla</label>
              <input type="text" id="tabla" name="tabla" class="form-control" placeholder="Tabla" required=required>
            </div>
            <div class="form-group col-lg-4 col-md-3 col-sm-10 col-xs-10">
              <label>Grupo:</label>
                <select name="grupo" id="grupo" class="form-control">
                  <option value="inventario">Inventario</option>
                  <option value="compras">Compras</option>
                  <option value="ventas">Ventas</option>
                  <option value="bancos">Banco</option>
                  <option value="configuracion">Configuracion</option>
                </select>
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 nomargin">
            </div>

              <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-6">
                <label>Prefijo:</label>
                <input type="text" id="precadena" name="precadena" class="form-control" placeholder="Prefijo">
              </div>
              <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-6">
                <label>Cadena:</label>
                <input type="text" id="cadena" name="cadena" class="form-control" placeholder="Codena" required=required>
              </div>
              <div class="form-group col-lg-2 col-md-2 col-sm-10 col-xs-10">
                <label>Correlativo:</label>
                <input type="text" id="cod_num" name="cod_num" class="form-control" placeholder="Correlativo" required=required>
              </div>
              <div class="form-group col-lg-2 col-md-2 col-sm-10 col-xs-10">
                <label>Largo:</label>
                <input type="text" id="largo" name="largo" class="form-control" placeholder="Largo" required=required>
              </div>


            <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-8">
              <label for="desc_correlativo">Operación</label>
              <input type="text" id="desc_correlativo" name="desc_correlativo" 
              class="form-control form-control-border form-control-sm" placeholder="Descripción">
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 padd-top">
              <input type="text" id="idcorrelativo" name="idcorrelativo" class="hidden">
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

