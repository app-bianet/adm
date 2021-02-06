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
            <th style="width:100px" class="text-center">Opciones</th>
            <th style="width:150px" class="text-center">Código</th>
            <th style="width:200px" class="text-center">N° de Cuenta</th>
            <th style="width:150px" class="text-center">Banco</th>
            <th style="width:150px" class="text-center">Saldo</th>
            <th class="text-center">Descripción</th>
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
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">Código:</span>
                </div>
                <input type="text" id="cod_cuenta" name="cod_cuenta" class="form-control" placeholder="Código">
              </div>
            </div>
            <div class="form-group col-lg-6 col-md-6 col-sm-8 col-xs-8" style="padding-left:0px">
              <input type="text" id="desc_cuenta" name="desc_cuenta" class="form-control" placeholder="Descripción">
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
            <div class="form-group col-lg-4 col-md-4 col-sm-2 col-xs-2">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">Banco:</span>
                </div>
                <select class="form-control" name="idbanco" id="idbanco">
                </select>
              </div>
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">Tipo:</span>
                </div>
                <select class="form-control" name="tipo" id="tipo">
                  <option value="Corriente">Corriente</option>
                  <option value="Ahorro">Ahorro</option>
                  <option value="Palzo Fijo">Palzo Fijo</option>
                  <option value="Credito">Credito</option>
                  <option value="Otros">Otros</option>
                </select>
              </div>
            </div>
            <div class="form-group col-lg-5 col-md-5 col-sm-8 col-xs-8">
              <input type="text" id="numcuenta" name="numcuenta" class="form-control" placeholder="Nro de Cuenta">
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <input type="checkbox" id="mostrar" name="mostrar"> : <label class="checkbox-inline"> Mostrar en Documentos de Venta</label> 
            </div>
            <div class="form-group col-lg-11 col-md-11 col-sm-11 col-xs-12">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card card-header-pills">
                  <div class="nav nav-tabs nav-compact nav-justified">   
                    <a class="nav-link active" data-toggle="tab" href="#tab1"><B>Agencia</B></a>
                    <a class="nav-link" data-toggle="tab" href="#tab2"><B>Saldos</B></a>
                  </div>
                  <div class="tab-content">
                    <div role="tab-pane fade" class="tab-pane active" id="tab1">
                      <div class="card-body">
                        <div class="form-row">
                          <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <input type="text" class="form-control" name="ejecutivo" id="ejecutivo" placeholder="Ejecutivo">
                          </div>
                          <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <input type="text" class="form-control" name="telefono" id="telefono" placeholder="Telefono">
                          </div>
                          <div class="form-group col-lg-5 col-md-5 col-sm-12 col-xs-12">
                            <input type="text" class="form-control" name="email" id="email" placeholder="Email">
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <input type="text" class="form-control" name="agencia" id="agencia" placeholder="Agencia">
                          </div>
                          <div class="form-group col-lg-8 col-md-8 col-sm-12 col-xs-12">
                            <input type="text" class="form-control" name="direccion" id="direccion" placeholder="Direccion">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div role="tab-pane fade" class="tab-pane" id="tab2">
                      <div class="card-body">
                        <div class="form-row">
                          <div class="form-group col-lg-4 col-md-12 col-sm-12 col-xs-12">
                            <label>Debe:</label>
                            <input type="text" class="form-control nformat" name="saldod" id="saldod" placeholder="0.00" readonly>
                          </div>
                          <div class="form-group col-lg-4 col-md-12 col-sm-12 col-xs-12">
                            <label>Haber:</label>
                            <input type="text" class="form-control nformat" name="saldoh" id="saldoh" placeholder="0.00" readonly>
                          </div>
                          <div class="form-group col-lg-4 col-md-12 col-sm-12 col-xs-12">
                            <label>Saldo:</label>
                            <input type="text" class="form-control nformat" name="saldot" id="saldot" placeholder="0.00" readonly>
                          </div>
                        </div>
                      </div> 
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 padd-top">
              <input type="text" id="idcuenta" name="idcuenta" class="hidden">
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


