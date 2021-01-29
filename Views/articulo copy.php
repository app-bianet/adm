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
          <input type="search" class="filtro_buscar form-control " id="filtro_buscar" placeholder="Buscar">
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
            <th style="width:200px" class="text-center">Categoría</th>
            <th style="width:150px" class="text-center">Referencia</th>
            <th style="width:150px" class="text-center">Stock</th>
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
            <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-6">
              <div class="input-group">  
                <div class="input-group-prepend">
                  <span class="input-group-text small">Código: </span>
                </div>  
                <input type="textc" id="cod_articulo" name="cod_articulo" 
                class="form-control" placeholder="Código">
              </div>
            </div>
            <div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-1">
            </div>
            <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
              <div class="input-group">  
                <div class="input-group-prepend">
                  <span class="input-group-text small">Origen: </span>
                </div>  
                  <select id="origen" name="origen" class="form-control">
                    <option value="Nacional">Nacional</option>
                    <option value="Importado">Importado</option>
                    <option value="Produccion">Produccion</option>
                  </select>
              </div>
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
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
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <input type="text" id="desc_articulo" name="desc_articulo" 
              class="form-control form-control-border " placeholder="Descripción">
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 nomargin">
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <div class="card card-header-pills">
                <ul class="nav nav-tabs nav-compact nav-pills nav-justified">   
                  <li><a class="nav-link" data-toggle="tab" href="#tab1"><B>General</B></a></li>
                  <li><a class="nav-link active" data-toggle="tab" href="#tab2"><B>Precios</B></a></li>
                  <li><a class="nav-link" data-toggle="tab" href="#cxpta3"><B>Caracteristicas</B></a></li>
                  <li><a class="nav-link" data-toggle="tab" href="#cxpta4"><B>Parametros Adicionales</B></a></li>
                </ul>
                  <div class="tab-content">
                    <div role="tabpanel" class="tab-pane" id="tab1">
                      <div class="form-group">
                        <div class="row">
                          <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            </div>
                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <div class="input-group input-group-sm">  
                                <div class="input-group-prepend">
                                  <span class="input-group-text small">Origen: </span>
                                </div>  
                                  <select id="origen" name="origen" class="form-control">
                                    <option value="Nacional">Nacional</option>
                                    <option value="Importado">Importado</option>
                                    <option value="Produccion">Produccion</option>
                                  </select>
                              </div>
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            </div>
                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <div class="input-group input-group-sm">  
                                <div class="input-group-prepend">
                                  <span class="input-group-text small">Tipo: </span>
                                </div>  
                                  <select id="tipo" name="tipo" class="form-control">
                                    <option value="general">Generak</option>
                                    <option value="servicio">Servicio</option>
                                    <option value="uso interno">Uso Interno</option>
                                    <option value="produccion">Produccion</option>
                                  </select>
                              </div>
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            </div>
                          </div>   
                          <div class="form-group col-lg-5 col-md-5 col-sm-12 col-xs-12">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            </div>
                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <div class="input-group">  
                                <div class="input-group-prepend">
                                  <span class="input-group-text small">Categoría: </span>
                                </div>  
                                <select name="idcategoria" id="idcategoria" class="form-control"></select>
                              </div>
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            </div>
                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <div class="input-group">  
                                <div class="input-group-prepend">
                                  <span class="input-group-text small">Línea: </span>
                                </div>  
                                <select name="idlinea" id="idlinea" class="form-control"></select>
                              </div>
                            </div>
                          </div> 
                          <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            </div>
                            <div class="row">
                              <div class="input-group col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                <div class="input-group">  
                                  <div class="input-group-prepend">
                                    <span class="input-group-text small">Impuesto: </span>
                                  </div>  
                                  <select name="idimpuesto" id="idimpuesto" class="form-control">
                                  </select>
                                </div>
                              </div>
                              <div class="input-group col-lg-3 col-md-3 col-sm-4 col-xs-4 no-paddm">
                                <input type="text" name="idimpuesto" id="idimpuesto" class="form-control">
                              </div>
                            </div>
                          </div>
                        </div> 
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padd-top nomargin">
                          <div class="row">
                            <div class="input-group col-lg-3 col-md-3 col-sm-6 col-xs-6">
                              <div class="input-group">  
                                <div class="input-group-prepend">
                                  <span class="input-group-text small">Código: </span>
                                </div>  
                                <input type="textc" id="cod_articulo" name="cod_articulo" 
                                class="form-control" placeholder="Código">
                              </div>
                            </div>
                            <div class="input-group col-lg-3 col-md-3 col-sm-6 col-xs-6">
                              <div class="input-group">  
                                <div class="input-group-prepend">
                                  <span class="input-group-text small">Código: </span>
                                </div>  
                                <input type="textc" id="cod_articulo" name="cod_articulo" 
                                class="form-control" placeholder="Código">
                              </div>
                            </div>
                            <div class="input-group col-lg-3 col-md-3 col-sm-6 col-xs-6">
                              <div class="input-group">  
                                <div class="input-group-prepend">
                                  <span class="input-group-text small">Código: </span>
                                </div>  
                                <input type="textc" id="cod_articulo" name="cod_articulo" 
                                class="form-control" placeholder="Código">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 padd-top">
              <input type="text" id="idarticulo" name="idarticulo" class="hidden">
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


