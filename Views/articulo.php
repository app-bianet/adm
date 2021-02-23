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
            <th style="width:150px" class="text-center">Opciones</th>
            <th style="width:150px" class="text-center">Código</th>
            <th class="text-center">Descripción</th>
            <th style="width:200px" class="text-center">Categoría</th>
            <th style="width:150px" class="text-center">Referencia</th>
            <th style="width:150px" class="text-center">Stock</th>
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
            <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-6">
              <div class="input-group">  
                <div class="input-group-prepend">
                  <span class="input-group-text small">Código: </span>
                </div>  
                <input type="textc" id="cod_articulo" name="cod_articulo" 
                class="form-control" placeholder="Código">
              </div>
            </div>
            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
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
                <div class="nav nav-tabs nav-compact nav-pills nav-justified">   
                  <a class="nav-link active btn" data-toggle="tab" href="#tab1"><B>General</B></a>
                  <a class="nav-link btn" data-toggle="tab" href="#tab2"><B>Precios</B></a>
                  <a class="nav-link btn" data-toggle="tab" href="#tab3"><B>Caracteristicas</B></a>
                  <a class="nav-link btn" data-toggle="tab" href="#tab4"><B>Parametros Adicionales</B></a>
                </div>
                  <div class="tab-content">
                    <div role="tab-pane fade" class="tab-pane active" id="tab1">
                      <div class="form-group">
                        <div class="row">
                          <div class="form-group col-lg-5 col-md-5 col-sm-12 col-xs-12">
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
                                    <option value="General"> General </option>
                                    <option value="Servicio"> Servício </option>
                                    <option value="Uso Interno"> Uso Interno </option>
                                    <option value="Produccion"> Producción </option>
                                    <option value="Otro"> Otro </option>
                                  </select>
                              </div>
                            </div>
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
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <div class="row">
                                <div class="input-group col-lg-9 col-md-9 col-sm-9 col-xs-9">
                                  <div class="input-group">  
                                    <div class="input-group-prepend">
                                      <span class="input-group-text small">Impuesto: </span>
                                    </div>  
                                    <select name="idimpuesto" id="idimpuesto" class="form-control">
                                    </select>
                                  </div>
                                </div>
                                <div class="input-group col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                  <input type="text" name="tasa" id="tasa" class="form-control nformat" disabled>
                                </div>
                              </div>
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            </div>
                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <div class="input-group">  
                                <div class="input-group-prepend">
                                  <span class="input-group-text small">Costo Neto: </span>
                                </div>  
                                <input type="text" id="costo" name="costo" class="form-control nformat" placeholder="0.00">
                              </div>
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            </div>
                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <div class="input-group">  
                                <div class="input-group-prepend">
                                  <span class="input-group-text small">Impuesto: </span>
                                </div>  
                                <input type="text" id="costoimp" class="form-control nformat" placeholder="0.00">
                              </div>
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            </div>
                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <div class="input-group">  
                                <div class="input-group-prepend">
                                  <span class="input-group-text small">Total Costo: </span>
                                </div>  
                                <input type="text" id="costot" class="form-control nformat" placeholder="0.00">
                              </div>
                            </div>
                          </div> 
                          <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            </div>
                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <span class="input-group-addon"><label>Maneja Lotes:</label>
                              <input type="checkbox" name="lotes" id="lotes" class="chk">
                              </span>
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            </div>
                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <span class="input-group-addon"><label>Lotes con Vencimiento:</label>
                                <input type="checkbox" name="lotesv" id="lotesv" class="chk">
                              </span>
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            </div>
                            <div class="input-group col-lg-11 col-md-11 col-sm-11 col-xs-11">
                              <div class="input-group">  
                                <div class="input-group-prepend">
                                  <span class="input-group-text small">Comisión(%): </span>
                                </div>  
                                <input type="text" id="comision" name="comision" class="form-control nformat" placeholder="0.00">
                              </div>
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            </div>
                          </div>
                        </div> 
                      </div>
                    </div>
                    <div role="tab-pane fade" class="tab-pane" id="tab2">
                      <div class="form-group">
                        <div class="row">
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card-body">
                              <table id="tbtipoprecio" class="table table-responsive table-bordered 
                              table-hover compact table-sm table-striped paneltb">
                                <thead class="bg-gray">
                                  <th class="nd text-center nd" style="width:80px">Opciones</th>
                                  <th class="nd text-center nd" style="width:30px">Moneda</th>
                                  <th class="nd text-center nd" style="width:200px">Tipo de Precio</th>
                                  <th class="nd text-center nd" style="width:180px">Precio Neto</th>
                                  <th class="nd text-center nd" style="width:80px">Margen</th>
                                  <th class="nd text-center nd" style="width:160px">Margen+Precio</th>
                                  <th class="nd text-center nd" style="width:160px">Impuesto</th>
                                  <th class="nd text-center nd" style="width:180px">Total Precio</th>
                                  <th class="nd text-center nd" style="width:80px">Registro</th>
                                  <th class="nd text-center nd" style="width:80px">Venc.</th>
                                </thead>
                              </table> 
                              <button type="button" id="btnPrecio" class="btn btn-xs btn-primary btnl">Agregar Precio</button>                        
                            </div>                     
                          </div>
                        </div>
                      </div>
                    </div>
                    <div role="tab-pane fade" class="tab-pane" id="tab3">
                      <div class="form-group">
                        <div class="row">
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">  
                          </div>  
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <button type="button" id="btnMostrarUnidad" class="btn btn-primary btnl btn-xs">
                              <span class="fa fa-cubes"></span> Unidades</button>
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <table id="tblListadoDep" class="table table-bordered 
                                table-hover compact table-sm table-striped paneltb" style="width:100%">
                                <thead class="bg-gray">
                                  <th style="width:10%" class="text-center">Reng</th>
                                  <th style="width:65%"class="nd text-center">Deposito</th>
                                  <th style="width:25%" class="text-center">Stock</th>
                                </thead>
                              </table>
                            </div>
                          </div>
                          <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <label> Tipos de Existencia:</label>
                              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                </div>
                                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                  <div class="input-group">  
                                    <div class="input-group-prepend">
                                      <span class="input-group-text small">Stock Pedido: </span>
                                    </div>  
                                    <input type="text" id="stockped" name="stockped" class="form-control nformat" placeholder="0.00">
                                  </div>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                </div>
                                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                  <div class="input-group">  
                                    <div class="input-group-prepend">
                                      <span class="input-group-text small">Stock Maximo: </span>
                                    </div>  
                                    <input type="text" id="stockmax" name="stockmax" class="form-control nformat" placeholder="0.00">
                                  </div>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                </div>
                                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                  <div class="input-group">  
                                    <div class="input-group-prepend">
                                      <span class="input-group-text small">Stock Minimo: </span>
                                    </div>  
                                    <input type="text" id="stockmin" name="stockmin" class="form-control nformat" placeholder="0.00">
                                  </div>
                                </div>
                              </div>
                          </div>
                          <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <label> Parametros de Medida:</label>
                              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                </div>
                                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                  <div class="input-group">  
                                    <div class="input-group-prepend">
                                      <span class="input-group-text small">Ancho: </span>
                                    </div>  
                                    <input type="text" id="ancho" name="ancho" class="form-control nformat" placeholder="0.00">
                                  </div>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                </div>
                                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                  <div class="input-group">  
                                    <div class="input-group-prepend">
                                      <span class="input-group-text small">Alto: </span>
                                    </div>  
                                    <input type="text" id="alto" name="alto" class="form-control nformat" placeholder="0.00">
                                  </div>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                </div>
                                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                  <div class="input-group">  
                                    <div class="input-group-prepend">
                                      <span class="input-group-text small">Peso: </span>
                                    </div>  
                                    <input type="text" id="peso" name="peso" class="form-control nformat" placeholder="0.00">
                                  </div>
                                </div>
                              </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div role="tab-pane fade" class="tab-pane" id="tab4">
                      <div class="form-group"> 
                        <div class="row">
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">  
                          </div>  
                          <div class="form-group col-lg-5 col-md-5 col-sm-12 col-xs-12">
                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <span class="input-group-addon" style="border-radius:0px;"><label>Cod. Barras:</label></span>
                              <div class="btn-group" role="group">
                                  <button class="btn btn-success btn-sm btnl" 
                                  type="button" onclick="generarBarcode()"><i class="fa fa-tasks"></i> Generar</button>
                                  <button class="btn btn-primary btn-sm btnl" 
                                  type="button" onclick="imprimirBarcode()"><i class="fa fa-print"></i> Imprimir</button>
                              </div>
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            </div>
                            <div class="input-group col-lg-9 col-md-8 col-sm-12 col-xs-12">
                              <input type="text" class="form-control" name="ref" id="ref"
                              placeholder="Codigo de Barras" maxlength="50">
                            </div>
                            <div id="print" class="input-group col-lg-9 col-md-8 col-sm-12 col-xs-12">
                              <svg id="barcode" style="width:100%;border:1.5px solid #ccc; max-height:100px; border-radius:5px"></svg>
                            </div>
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                              <span class="imagena" id="imagenah"><label for="imagena">Cargar Imagen</label>
                              <input type="file" name="imagena" id="imagena">
                              <input type="hidden" name="imagenactual" id="imagenactual">
                              <img class="img-fluid img-bshadow mb-3" src="" id="imagenmuestra"></span>  
                          </div>
                          <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <span class="input-group-addon" style="text-align:right">
                              <button type="button" class="btn btn-xs btnm btn-primary">Seriales</button>
                              <label>Seriales:</label>
                              <input type="checkbox" name="seriales" id="seriales" class="chk"></span>
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
  
<?php 
getModal('articuloModal');
footerAdmin($data);?>