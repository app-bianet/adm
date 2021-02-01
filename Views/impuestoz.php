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
        <div class="form-row">
          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-6" style="padding-left:15px; padding-right:0px">
            <div class="input-group">  
              <div class="input-group-prepend">
                <span class="input-group-text small">Código: </span>
              </div>  
              <input type="textz" id="cod_impuestoz" name="cod_impuestoz" class="form-control" placeholder="Código" readonly>
              </div>
          </div>
          <div class="form-group col-lg-5 col-md-5 col-sm-6 col-xs-6 no-padding">
            <select name="idimpuestozh" id="idimpuestozh" class="form-control">
            </select>
          </div>
        </div>
      <form name="tableForm" id="tableForm">
        <table id="tbdetalle" class="table table-bordered table-hover compact table-sm table-striped" style="width:100% !important;">
          <thead class="bg-blue">
            <th style="width:120px" class="text-center nd">Opciones</th>
            <th style="width:150px" class="text-center">Código</th>
            <th class="text-center">Descripción</th>
            <th class="text-center">Base</th>
            <th class="text-center">Retención</th>
            <th class="text-center">Sustraendo</th>
            <th style="width:80px" class="text-center nd">
              <button type="button" class="btn btn-xs btn-danger btnEliminar" 
              data-toggle="tooltip" data-placement="right" title="Eliminar">Eliminar</button>
            </th>
          </thead>      
        </table>
        </form>
      </div>
      <div class="card-body visible-op" id="formulario">
        <form id="dataForm" name="dataForm">
          <div class="form-row">
            <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-6">
              <label for="cod_impuestozx">Código</label>
              <input type="text" id="cod_concepto" name="cod_concepto" 
              class="form-control" placeholder="Código">
            </div>
            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-8">
              <label for="desc_impuestoz">Descripción</label>
              <input type="text" id="desc_concepto" name="desc_concepto" 
              class="form-control" placeholder="Descripción">
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 nomargin">
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-4 col-xs-4">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text small">Base</span>
                </div>
                  <input type="text" id="base" name="base" class="form-control nformat" placeholder="Base">
              </div> 
            </div>
            <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-6">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text small">Retención</span>
                </div>
                  <input type="text" id="retencion" name="retencion" class="form-control nformat" placeholder="Descripción">
              </div> 
            </div>
            <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-6">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text small">Sustraendo</span>
                </div>
                  <input type="text" id="sustraendo" name="sustraendo" class="form-control nformat" placeholder="Descripción">
              </div> 
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <input type="text" id="idimpuestozd" name="idimpuestozd">
              <input type="text" id="idimpuestoz" name="idimpuestoz">
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 padd-top">
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


