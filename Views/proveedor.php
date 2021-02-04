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
          <input type="search" class="filtro_buscar form-control " id="filtro_buscar" placeholder="Buscar">
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
            <th style="width:120px" class="text-center">Rif</th>
            <th style="width:250px" class="text-center">Tipo de Proveedor</th>
            <th style="width:250px" class="text-center">Tipo de Operacion</th>
            <th style="width:250px" class="text-center">Contacto</th>
            <th style="width:160px" class="text-center">Telefono</th>
            <th style="width:160px" class="text-center">Movil</th>
            <th style="width:250px" class="text-center">email</th>
            <th style="width:130px" class="text-center">Limite</th>
            <th style="width:150px" class="text-center">Saldo</th>
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
                  <span class="input-group-text small">Código: </span>
                </div>  
                <input type="textc" id="cod_proveedor" name="cod_proveedor" 
                class="form-control" placeholder="Código">
              </div>
            </div>
            <div class="form-group col-lg-7 col-md-7 col-sm-12 col-xs-12">
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
            <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
              <input type="text" id="rif" name="rif" 
              class="form-control form-control-border " placeholder="Rif">
            </div>
            <div class="form-group col-lg-10 col-md-10 col-sm-12 col-xs-12">
              <input type="text" id="desc_proveedor" name="desc_proveedor" 
              class="form-control form-control-border " placeholder="Descripción">
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <input type="text" id="direccion" name="direccion" 
              class="form-control form-control-border " placeholder="Dirección">
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
              <div class="input-group">  
                <div class="input-group-prepend">
                  <span class="input-group-text small">Tipo: </span>
                </div>  
                <select name="idtipoproveedor" id="idtipoproveedor" class="form-control"></select>
              </div>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
              <div class="input-group">  
                <div class="input-group-prepend">
                  <span class="input-group-text small">Tipo de Op.: </span>
                </div>  
                <select name="idoperacion" id="idoperacion" class="form-control"></select>
              </div>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
              <div class="input-group">  
                <div class="input-group-prepend">
                  <span class="input-group-text small">Tab. de ISLR: </span>
                </div>  
                <select name="idimpuestoz" id="idimpuestoz" class="form-control"></select>
              </div>
            </div>
            <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
              <div class="input-group">  
                <div class="input-group-prepend input-group-sm">
                  <span class="input-group-text small">Zona: </span>
                </div>  
                <select name="idzona" id="idzona" class="form-control"></select>
              </div>
            </div>
            <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-6">
              <div class="input-group">  
                <div class="input-group-prepend">
                  <span class="input-group-text small">Ciudad: </span>
                </div>  
                <input type="text" id="ciudad" name="ciudad" 
                class="form-control" placeholder="Ciudad">
              </div>
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-6">
              <div class="input-group">  
                <input type="text" id="codpostal" name="codpostal" 
                class="form-control" placeholder="Codigo Postal">
              </div>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-6">
              <div class="input-group">  
                <div class="input-group-prepend">
                  <span class="input-group-text small">Contacto: </span>
                </div>  
                <input type="text" id="contacto" name="contacto" 
                class="form-control" placeholder="Persona de Contacto">
              </div>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-6">
              <div class="input-group">  
                <input type="text" id="telefono" name="telefono" 
                class="form-control" placeholder="Teléfono">
              </div>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-6">
              <div class="input-group">  
                <input type="text" id="movil" name="movil" 
                class="form-control" placeholder="Teléfono Movil">
              </div>
            </div>
            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
              <div class="input-group">  
                <div class="input-group-prepend">
                  <span class="input-group-text small">Email: </span>
                </div>  
                <input type="text" id="email" name="email" 
                class="form-control" placeholder="Persona de Contacto">
              </div>
            </div>
            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
              <div class="input-group">  
                <div class="input-group-prepend">
                  <span class="input-group-text small">Web: </span>
                </div>  
                <input type="text" id="web" name="web" 
                class="form-control" placeholder="Página Web">
              </div>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
              <div class="input-group">  
                <div class="input-group-prepend input-group-sm">
                  <span class="input-group-text small">Cond. de Pago: </span>
                </div>  
                <select name="idcondpago" id="idcondpago" class="form-control"></select>
              </div>
            </div>
            <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-6">
              <div class="input-group">  
                <div class="input-group-prepend">
                  <span class="input-group-text small">Límite: </span>
                </div>  
                <input type="text" id="limite" name="limite" 
                class="form-control nformat" placeholder="0.00">
              </div>
            </div>
            <div class="form-group col-lg-2 col-md-2 col-sm-4 col-xs-4">
              <div class="input-group">
                <div class="input-group-append"> 
                  <span class="input-group-text text-sm-left small">Cont: 
                    <input type="checkbox" name="aplicareten" id="aplicareten" class=" input-group-prepend">
                  </span>
                </div>
                <input type="text" class="form-control nformat" placeholder="%" name="montofiscal" 
                id="montofiscal">
              </div>        
            </div>
            <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-6">
              <div class="input-group">  
                <div class="input-group-prepend">
                  <span class="input-group-text small">Saldo: </span>
                </div>  
                <input type="textn" id="saldo" name="saldo" 
                class="form-control nformat" placeholder="0.00" readonly>
              </div>
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 padd-top">
              <input type="text" id="idproveedor" name="idproveedor" class="hidden">
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


