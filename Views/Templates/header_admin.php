<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $data['page_title']?></title>
  <?php require_once 'assets.php';?>
</head>
<!-- bodytag options:
  Apply one or more of the following classes to to the body tag to get the desired effect
  * sidebar-collapse * sidebar-mini -->
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="" class="nav-link"><b><?= FechaActual()?></b></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>

      <!-- Botones Usuario -->
      <li class="nav-item">
      <input id="idusuarioc" value="1" name="idusuacioc" type="hidden">
        <a role="button">
          <button type="button" id="btnMostraModalt" class="btn btn-xs btn-success">
            <i class="fas fa-key"></i> Cambiar Clave
          </button>
        </a> 
        <a role="button">
          <button type="button" class="btn btn-xs btn-danger" onclick="Salir()">
            <i class="fas fa-lock-open"></i> Cerrar Sesión
            </button>
        </a> 
        <a role="button" data-toggle="dropdown" aria-expanded="">
            <button type="button" class="btn btn-xs btn-primary btnx"><i class="fa fa-user"></i> Usuario
              <div class="dropdown-menu dropdown-menu-right">
                <div class="col-12">
                  <div class="card-body box-profile">
                    <div class="text-center">
                      <img class="profile-user-img img-fluid img-circle" src="<?php echo images().'user/'.$_SESSION['simagen'];?>" alt="User profile picture">
                      <h3 class="profile-username text-center"><?php echo $_SESSION['sdesc_usuario'];?></h3>
                      <ul class="list-group list-group-unbordered mb-12">
                        <li class="list-group-item">
                        <b>Departamento:<span class="hidden-xs"><?php echo $_SESSION['sdepartamento'];?></span></b>
                        </li>       
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </button>
          </a>     
      </li>
    </ul>
  </nav>

  <!-- /.navbar -->
<?php require_once 'sidebar.php';?>

  <!-- Modal -->
  <div class="modal fade" id="ModalCambiarClave" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content"  style="width:100%">
        <div class="modal-header">
          <h4 class="modal-title">Cambiar Clave <?php echo $_SESSION['sdesc_usuario'];?></h4>
        </div>
        <div class="card-body" id="formularioc"> 
          <form id="dataFormc" name="dataFormc">
            <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="input-group input-group-sm">
                  <div class="input-group-append col-lg-5 col-md-5 col-sm-12 col-xs-12 no-padding">
                    <span class="input-group-text">Usuario</span>
                    <input type="text" id="cod_usuarioc" class="form-control form-control-sm" readonly>
                  </div>
                  <div class="input-group-append col-lg-7 col-md-7 col-sm-12 col-xs-12 no-padding">
                    <input type="text" id="desc_usuarioc" class="form-control form-control-sm" readonly>
                  </div>
                </div>
              </div>
              <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label>Clave</label>
                <input type="password" id="clavec" name="clavec"
                class="form-control form-control-sm" placeholder="Clave" required="required">
              </div>
              <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label>Confirmar</label>
                <input type="password" name="confclavec" id="confclavec" class="form-control form-control-sm" 
                placeholder="Confirmar Clave" required="required">
              </div>
            </div>
          </div> 
          <div class="modal-footer">
            <button type="button" class="btn btn-sm btnm btn-primary pull-left" id="btnGuardarCl">Aceptar</button>
            <button type="button" class="btn btn-sm btnm btn-danger" data-dismiss="modal">Cancelar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
