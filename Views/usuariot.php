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
            <th style="width:220px" class="text-center">Acceso</th>
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
          <div class="row">
            <div class="form-row col-sm-9">
              <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-6">
                <label for="cod_usuario">Código</label>
                <input type="textc" id="cod_usuario" name="cod_usuario" 
                class="form-control form-control-border" placeholder="Código">
              </div>
              <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label for="idmacceso"> Perfil de Acceso:</label>
                  <select class="form-control dt" name="idmacceso" id="idmacceso">
                    <option class="hidden">macceso</option>
                  </select>
              </div>
              <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-6">
                <label> Registro:</label>
                  <div class="input-group date">
                  <input type="text" class="form-control ffecha" name="fechareg" id="fechareg" require>
                    <div class="input-group-append">
                      <div class="input-group-text">
                      <i class="fa fa-calendar"></i></div>
                    </div>
                  </div>
              </div>
              <div class="form-group col-lg-6 col-md-6 col-sm-10 col-xs-10">
                <input type="text" id="desc_usuario" name="desc_usuario" 
                class="form-control" placeholder="Descripción" require>
              </div>
              <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <input type="password"  name="clave" id="clave" class="form-control" 
                placeholder="Clave" required="required" value="">
              </div>
              <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <input type="password" name="confclave" id="confclave" class="form-control" 
                placeholder="Confirmar Clave" required="required">
              </div>
              <div class="form-group col-lg-5 col-md-5 col-sm-12 col-xs-12">
                <input type="text" name="direccion" id="direccion" class="form-control" placeholder="Dirección" >
              </div>
              <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <input type="text" name="telefono" id="telefono" class="form-control" placeholder="Teléfono">
              </div>
              <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <input type="text" name="email" id="email" class="form-control" placeholder="Email">
              </div>
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              </div>
            </div>
              <div class="form-row col-sm-3">
                <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <span class="imagena" id="imagenah"><label for="imagena">Cargar Imagen</label>
                  <input type="file" name="imagena" id="imagena">
                  <input type="hidden" name="imagenactual" id="imagenactual">
                  <img class="img-fluid img-bordered-sm mb-3" src="" id="imagenmuestra"></span>      
                </div>
              </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 padd-top">
              <input type="text" id="idusuario" name="idusuario" class="hidden">
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


