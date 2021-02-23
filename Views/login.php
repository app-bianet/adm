<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= libs()?>/css/bootstrap.min.css">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?= libs()?>/css/all.min.css">
    <link rel="stylesheet" href="<?= libs()?>/css/font-awesome.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= libs()?>/css/adminlte.min.css">
    <link rel="stylesheet" href="<?= libs()?>/css/sweetalert2.min.css">
    <link rel="stylesheet" href="<?= libs()?>/css/app.css">
    <link rel="stylesheet" href="<?= libs();?>/css/login.css">
</head>
<body>
<form id="form_login">

  <div class="login-box">
    <h1>SAMINET</h1>

    <!-- ======= Username ======= -->
    <div class="textbox">
      <i class="fa fa-user" aria-hidden="true"></i>
      <input type="text" placeholder="Usuario" name="cod_usuario" id="cod_usuario">
    </div>

    <!-- ======= Password ======= -->
    <div class="textbox">
      <i class="fa fa-lock" aria-hidden="true"></i>
      <input type="password" placeholder="Password" name="clave" id="clave">
    </div>

    <!-- ======= Sign in ======= -->
    <input class="btnlg btn" type="submit" name="" value="Iniciar Sesión" />
  </div>
</form>
    <script>
      const url_baseL="<?=base_URL()?>";
    </script>
    <script src="<?= libs()?>/js/jquery.min.js"></script>
    <script src="<?= libs()?>/js/bootstrap.min.js"></script>
    <script src="<?= libs()?>/js/sweetalert2.min.js"></script>
    <script src="<?= libs();?>/scripts/<?= $data['func'];?>"></script>
</body>
</html>