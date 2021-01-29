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
        <table id="tbdetalle" class="table table-bordered table-hover table-sm table-striped" style="width:100% !important;">
          <thead class="bg-blue">
            <th style="width:120px" class="text-center nd">Opciones</th>
            <th style="width:150px" class="text-center">Código</th>
            <th class="text-center">Descripción</th>
            <th style="width:200px" class="text-center">Departamento</th>
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
              <label for="cod_macceso">Código</label>
              <input type="textc" id="cod_macceso" name="cod_macceso" 
              class="form-control form-control-border form-control-sm" placeholder="Código">
            </div>
            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
              <label for="departamento">Departamento</label>
              <select id="departamento" name="departamento" class="form-control selectpicker">
                <option value="ADMINISTRACION">Administración</option>
                <option value="GERENCIA">Gerencia</option>
                <option value="COMPRAS">Compras</option>
                <option value="VENTAS">Ventas</option>
                <option value="TESORERIA">Tesorería</option>
                <option value="SOPORTE">Soporte</option>
              </select>
            </div>
            <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-8">
              <label for="desc_macceso">Descripción</label>
              <input type="text" id="desc_macceso" name="desc_macceso" 
              class="form-control form-control-border form-control-sm" placeholder="Descripción">
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
            </div>
            <div class="col-12">
              <div class="card">
                <ul class="nav nav-tabs nav-compact nav-justified">   
                  <li><a class="nav-link active" data-toggle="tab" href="#cftab"><B>Accesos Configuracion</B></a></li>
                  <li><a class="nav-link" data-toggle="tab" href="#invtab"><B>Accesos Inventario</B></a></li>
                  <li><a class="nav-link" data-toggle="tab" href="#cxptab"><B>Accesos Compras</B></a></li>
                  <li><a class="nav-link" data-toggle="tab" href="#cxctab"><B>Accesos Ventas</B></a></li>
                  <li><a class="nav-link" data-toggle="tab" href="#bantab"><B>Accesos Banca</B></a></li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane fade active" id="cftab"><!--Config-->
                    <div class="card-body w-100"><!--Tablas-->
                      <table id="config" class="table table-bordered table-hover 
                      compact table-sm table-striped" style="width: 100% !important;">
                        <thead class="bg-green-active">
                          <th>Tablas</th>
                          <th>Activo</th>        
                        </thead>
                      </table>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12"><!--Botones Marcar-->
                      <button class="btn btn-success btn-xs btnmarcar" type="button" id="btnMarcaConf" onclick="MarcarTodos()">
                      <i class="fa fa-plus-circle"></i> Marcar Todos</button>
                      <button class="btn btn-danger btn-xs btnmarcar" type="button" id="btnDelConf">
                      <i class="fa fa-minus-circle"></i> Desmarcar Todos</button>
                    </div>
                  </div>

                  <div class="tab-pane fade" id="invtab"><!--Inventario-->
                    <div class="form-row">
                      <div class="card-body w-50"><!--Tablas-->
                        <table id="inventario" class="table table-bordered table-hover 
                        compact table-sm table-striped">
                          <thead class="bg-green-active">
                            <th>Tablas</th>
                            <th>Activo</th>        
                          </thead>
                        </table>
                      </div>
                      <div class="card-body w-50"><!--Operacion-->
                        <table id="opinventario" class="table table-bordered table-hover 
                        compact table-sm table-striped">
                          <thead class="bg-green-active">
                            <th>Tablas</th>
                            <th>Activo</th>        
                          </thead>
                        </table>
                      </div>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12"><!--Botones Marcar-->
                      <button class="btn btn-success btn-xs btnmarcar" type="button" id="btnMarcaInv">
                      <i class="fa fa-plus-circle"></i> Marcar Todos</button>
                      <button class="btn btn-danger btn-xs btnmarcar" type="button" id="btnDelInv">
                      <i class="fa fa-minus-circle"></i> Desmarcar Todos</button>
                    </div>
                  </div>

                  <div class="tab-pane fade" id="cxptab"><!--Compras-->
                    <div class="form-row">
                      <div class="card-body w-50"><!--Tablas-->
                        <table id="compras" class="table table-bordered table-hover 
                        compact table-sm table-striped">
                          <thead class="bg-green-active">
                            <th>Tablas</th>
                            <th>Activo</th>        
                          </thead>
                        </table>
                      </div>
                      <div class="card-body w-50"><!--Operacion-->
                        <table id="opcompras" class="table table-bordered table-hover 
                        compact table-sm table-striped">
                          <thead class="bg-green-active">
                            <th>Tablas</th>
                            <th>Activo</th>        
                          </thead>
                        </table>
                      </div>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12"><!--Botones Marcar-->
                      <button class="btn btn-success btn-xs btnmarcar" type="button" id="btnMarcaCxp">
                      <i class="fa fa-plus-circle"></i> Marcar Todos</button>
                      <button class="btn btn-danger btn-xs btnmarcar" type="button" id="btnDelCxp">
                      <i class="fa fa-minus-circle"></i> Desmarcar Todos</button>
                    </div>
                  </div>

                  <div class="tab-pane fade" id="cxctab"><!--Ventas-->
                    <div class="form-row">
                      <div class="card-body w-50"><!--Tablas-->
                        <table id="ventas" class="table table-bordered table-hover 
                        compact table-sm table-striped">
                          <thead class="bg-green-active">
                            <th>Tablas</th>
                            <th>Activo</th>        
                          </thead>
                        </table>
                      </div>
                      <div class="card-body w-50"><!--Operacion-->
                        <table id="opventas" class="table table-bordered table-hover 
                        compact table-sm table-striped">
                          <thead class="bg-green-active">
                            <th>Tablas</th>
                            <th>Activo</th>        
                          </thead>
                        </table>
                      </div>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12"><!--Botones Marcar-->
                      <button class="btn btn-success btn-xs btnmarcar" type="button" id="btnMarcaCxc">
                      <i class="fa fa-plus-circle"></i> Marcar Todos</button>
                      <button class="btn btn-danger btn-xs btnmarcar" type="button" id="btnDelCxc">
                      <i class="fa fa-minus-circle"></i> Desmarcar Todos</button>
                    </div>
                  </div>

                  <div class="tab-pane fade" id="bantab"><!--Bancos-->
                    <div class="form-row">
                      <div class="card-body w-50"><!--Tablas-->
                        <table id="bancos" class="table table-bordered table-hover 
                        compact table-sm table-striped">
                          <thead class="bg-green-active">
                            <th>Tablas</th>
                            <th>Activo</th>        
                          </thead>
                        </table>
                      </div>
                      <div class="card-body w-50"><!--Operacion-->
                        <table id="opbancos" class="table table-bordered table-hover 
                        compact table-sm table-striped">
                          <thead class="bg-green-active">
                            <th>Tablas</th>
                            <th>Activo</th>        
                          </thead>
                        </table>
                      </div>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12"><!--Botones Marcar-->
                      <button class="btn btn-success btn-xs btnmarcar" type="button" id="btnMarcaBan">
                      <i class="fa fa-plus-circle"></i> Marcar Todos</button>
                      <button class="btn btn-danger btn-xs btnmarcar" type="button" id="btnDelBan">
                      <i class="fa fa-minus-circle"></i> Desmarcar Todos</button>
                    </div>
                  </div>
                </div>

              </div>
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 padd-top">
              <input type="text" id="idmacceso" name="idmacceso" class="hidden">
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


