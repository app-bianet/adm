<?php
    ob_start();
    session_start();
class Usuario extends Controllers{

  public function __construct(){
    if (!isset($_SESSION['tidusuario'])){

    } else{
      if($_SESSION['usuariof']!=1)  {
        header("Location:".base_URL()."error403");
      } 
    }
    ob_end_flush();     
    parent::__construct();
  }

  public function usuario(){
    $data['page_tag']="Usuario";
    $data['page_title']=".:: Usuario ::.";
    $data['page_name']="usuario";
    $data['func']="functions_usuario.js";
    $this->views->getView($this,"usuario",$data);
  }

  public function Insertar(){

    $idusuario=isset($_POST["idusuario"])? limpiarCadena($_POST["idusuario"]):"";
    $idmacceso=isset($_POST["idmacceso"])? limpiarCadena($_POST["idmacceso"]):"";
    $cod_usuario=isset($_POST["cod_usuario"])? limpiarCadena($_POST["cod_usuario"]):"";
    $desc_usuario=isset($_POST["desc_usuario"])? limpiarCadena($_POST["desc_usuario"]):"";
    $direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
    $telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
    $email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
    $clave=isset($_POST["clave"])? limpiarCadena($_POST["clave"]):"";
    $imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";
    $fechareg=isset($_POST["fechareg"])? limpiarCadena($_POST["fechareg"]):"";
    
    $rutaimg=$_SERVER['DOCUMENT_ROOT'].'/Bianet/Files/images/user/';


    if (!file_exists($_FILES['imagena']['tmp_name']) || !is_uploaded_file($_FILES['imagena']['tmp_name'])){
      $imagen=$_POST["imagenactual"];
    } else {
      $ext = explode(".", $_FILES["imagena"]["name"]);
      $_FILES['imagena']['tmp_name']==$rutaimg.$cod_usuario.'.'.end($ext)?
        unlink($rutaimg.$cod_usuario.'.'.end($ext)):''; 
      if (
        $_FILES['imagena']['type'] == "image/jpg" || 
        $_FILES['imagena']['type'] == "image/jpeg" || 
        $_FILES['imagena']['type'] == "image/png"){
        $imagen = $cod_usuario.'.'.end($ext);
        move_uploaded_file($_FILES["imagena"]["tmp_name"], $rutaimg.$imagen);
      }
    }
  
      if ($idusuario==0) {
        $request=$this->model->InsertDt($idmacceso,$cod_usuario,$desc_usuario,$direccion,$telefono,$email,
        ($clave),$imagen,formatDate($fechareg));
        $option=1;
      } else {
        $request=$this->model->EditarDt($idusuario,$idmacceso,$cod_usuario,$desc_usuario,$direccion,$telefono,$email,
        ($clave),$imagen,formatDate($fechareg));
        error_log(formatDate($fechareg));
        $option=2;
      }

    if($request > 0){
      if ($option==1) {
        $arrRspta=array("status"=>true,"msg"=>"Registro Ingresado Correctamente!");
      } else {
        $arrRspta=array("status"=>true,"msg"=>"Registro Actualizado Correctamente!");
      }
    } else if ($request=="existe"){
      $arrRspta=array("status"=>false,"msg"=>"El Código <b>".$cod_usuario."</b> ya se encuentra Registrado! 
      <br>No es posible ingresar <b>Registros Duplicados!</b>");
    } else {
      $arrRspta=array("status"=>false,"msg"=>"No es posible Ingresar el Registro!");
    }
    echo json_encode($arrRspta,JSON_UNESCAPED_UNICODE);
  }

  public function Eliminar(){
    $request='';

    if (empty($_POST['eliminar_reg'])) {
      $arrRspta=array("status"=>false,"msg"=>"No Seleccionó ningún Registro para Eliminar!");
    } else {
      $idusuario=$_POST['eliminar_reg'];

      foreach($idusuario as $valor){

        $request=$this->model->EliminarDt($valor);
      }
      if($request > 0){
          $arrRspta=array("status"=>true,"msg"=>"Registros Eliminados Correctamente!");
      } else if ($request=="existe"){
          $arrRspta=array("status"=>false,"msg"=>"No es Posible Eliminar Registros Relacionados!");
      }else {
          $arrRspta=array("status"=>false,"msg"=>"No es Posible Eliminar algunos Registros!");
      } 
    }  
    echo json_encode($arrRspta,JSON_UNESCAPED_UNICODE);
  }

  public function Mostrar(){
    if (isset($_POST['idusuario'])) {
    $idusuario=intval(limpiarCadena($_POST['idusuario']));
      if ($idusuario>0) {
        $arrData=$this->model->ShowDt($idusuario);
        if (empty($arrData)){
          $arrRspta=array('status'=>false,'msg'=>'No Existen Registros!');
        } else {
          $arrRspta=$arrData;
        }
        echo json_encode($arrRspta,JSON_UNESCAPED_UNICODE);
      }
    } else{
      header("Location:".base_URL()."Error404");
    }
    die();  
  }

  public function Activar(){
    if (isset($_POST['idusuario'])) {
      $idusuario=intval(limpiarCadena($_POST['idusuario']));
      $estatus=intval(1);
      $request=$this->model->EstatusDt($idusuario,$estatus);
      if($request>0){
        $arrRspta=array("status"=>true,"msg"=>"Registro Activado Correctamente!");
      }else {
        $arrRspta=array("status"=>false,"msg"=>"Error al Activar el Registro!");
      }
      echo json_encode($arrRspta,JSON_UNESCAPED_UNICODE);
    } else{
      header("Location:".base_URL()."Error404");
    }
  }

  public function Desactivar(){
    if (isset($_POST['idusuario'])) {
      $idusuario=intval(limpiarCadena($_POST['idusuario']));
      $estatus=intval(0);
      $request=$this->model->EstatusDt($idusuario,$estatus);
      if($request>0){
        $arrRspta=array("status"=>true,"msg"=>"Registro Desactivado Correctamente!");
      }else {
        $arrRspta=array("status"=>false,"msg"=>"Error al Desactivar el Registro!");
      }
      echo json_encode($arrRspta,JSON_UNESCAPED_UNICODE);
    } else{
      header("Location:".base_URL()."Error404");
    }
  }

  public function Listar(){
    if (isset($_POST["security"])) {
      $arrData=$this->model->SelectDt();
      $al='style="text-align:';
      $w='; width:';
      for ($i=0; $i<count($arrData);$i++) { 
        if($arrData[$i]['estatus']==1){
          $arrData[$i]['estatus']='<small class="badge badge-success">Activo</small>';
          $arrData[$i]['opciones']=
          '<small '.$al.'center'.$w.'100px;" class="small btn-group">
          <button type="button" class="btn btn-primary btn-xs" onclick="mostrar('.$arrData[$i]['idusuario'].')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil"></i></button>'.
          '<button type="button" class="btn btn-success btn-xs" onclick="desactivar('.$arrData[$i]['idusuario'].')" data-toggle="tooltip" data-placement="right" title="Desactivar"><i class="fa fa-check"></i></button>
          </small>';
        } else {
          $arrData[$i]['estatus']='<small class="badge badge-danger">Inactivo</small>';
          $arrData[$i]['opciones']=
          '<small '.$al.'center'.$w.'100px;" class="small btn-group">
          <button type="button" class="btn btn-primary btn-xs" onclick="mostrar('.$arrData[$i]['idusuario'].')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil"></i></button>'.
          '<button type="button" class="btn btn-warning btn-xs" onclick="activar('.$arrData[$i]['idusuario'].')" data-toggle="tooltip" data-placement="right" title="Activar"><i class="fa fa-exclamation-triangle"></i></button>
          </small>';   
        }
        $arrData[$i]['acceso']=$arrData[$i]['cod_macceso'].'-'.$arrData[$i]['desc_macceso'];
        $arrData[$i]['eliminar']='<input type="checkbox" name="eliminar_reg[]" value="'.$arrData[$i]['idusuario'].'">';
      }
      echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
      die();
    } else{
      header("Location:".base_URL()."Error403");
    }
  }

  public function Select(){
    if (isset($_POST["security"])) {
      $arrData=$this->model->ListDt();
      for ($i=0; $i<count($arrData);$i++) { 
        echo '<option value="'.$arrData[$i]['idusuario'].'">'.$arrData[$i]['cod_usuario'].'-'.$arrData[$i]['desc_usuario'].'</option>';
      }
    } else {
      header("Location:".base_URL()."Error403");
    }
  }

  public function ActualizarClave(){
  //   // if (isset($_POST['idusuario'])) {
  //   //   $idusuario=intval(limpiarCadena($_POST['idusuario']));
  //   //   $clave=hashpw($_POST['clave']);

  //   //   $request=$this->model->EditarClave($idusuario,$clave);
  //   //   if($request>0){
  //   //     $arrRspta=array("status"=>true,"msg"=>"Clave Actualizada Exitosamente!");
  //   //   }else {
  //   //     $arrRspta=array("status"=>false,"msg"=>"Error al Actualizar la Clave!");
  //   //   }
  //   //   echo json_encode($arrRspta,JSON_UNESCAPED_UNICODE);
  //   // } else{
  //   //   header("Location:".base_URL()."Error404");
  //   // }
  //  $clave=hashpw('132632');
  //  error_log($clave);
  }

  public function SessionIn(){
    $passpublic=$_POST['clave'];
    $cod_usuario=limpiarCadena($_POST['cod_usuario']);
    $arrData=$this->model->Verificar($cod_usuario);
     for ($i=0; $i<count($arrData);$i++){
       if($arrData[$i]['estatus']==1){
         if (password_verify($passpublic,$arrData[$i]['clave'])) {
          $_SESSION['tidusuario']=$arrData[$i]['idusuario'];
          $_SESSION['tcod_usuario']=$arrData[$i]['cod_usuario'];
          $_SESSION['tdesc_usuario']=$arrData[$i]['desc_usuario'];
          $_SESSION['tidmacceso']=$arrData[$i]['idmacceso'];
          $_SESSION['tdepartamento']=$arrData[$i]['departamento'];
          $_SESSION['timagenu']=$arrData[$i]['imagen'];
          $_SESSION['temail']=$arrData[$i]['email'];
          $_SESSION['testatus']=$arrData[$i]['estatus'];

          $Marcados = $this->model->ListarMarcados($_SESSION['tidmacceso']);
          $valores=array();	
       
          for ($i = 0; $i < count($Marcados); $i++) {
            array_push($valores,$Marcados[$i]['idacceso']);
          }

          //Determinamos los accesos del usuario
          in_array(1,$valores)?$_SESSION['config']=1:$_SESSION['config']=0;
          in_array(2,$valores)?$_SESSION['macceso']=1:$_SESSION['macceso']=0;
          in_array(3,$valores)?$_SESSION['usuariof']=1:$_SESSION['usuariof']=0;
          in_array(4,$valores)?$_SESSION['empresa']=1:$_SESSION['empresa']=0;
          in_array(5,$valores)?$_SESSION['operacion']=1:$_SESSION['operacion']=0;
          in_array(6,$valores)?$_SESSION['correlativo']=1:$_SESSION['correlativo']=0;
          in_array(7,$valores)?$_SESSION['impuesto']=1:$_SESSION['impuesto']=0;
          in_array(8,$valores)?$_SESSION['impuestoz']=1:$_SESSION['impuestoz']=0;
          in_array(9,$valores)?$_SESSION['pais']=1:$_SESSION['pais']=0;
          in_array(10,$valores)?$_SESSION['moneda']=1:$_SESSION['moneda']=0;
              
          in_array(20,$valores)?$_SESSION['escritorio']=1:$_SESSION['escritorio']=0;
    
          in_array(40,$valores)?$_SESSION['inventario']=1:$_SESSION['inventario']=0;
          in_array(41,$valores)?$_SESSION['articulo']=1:$_SESSION['articulo']=0;
          in_array(42,$valores)?$_SESSION['categoria']=1:$_SESSION['categoria']=0;
          in_array(43,$valores)?$_SESSION['linea']=1:$_SESSION['linea']=0;
          in_array(44,$valores)?$_SESSION['unidad']=1:$_SESSION['unidad']=0;
          in_array(45,$valores)?$_SESSION['deposito']=1:$_SESSION['deposito']=0;
          in_array(50,$valores)?$_SESSION['opinventario']=1:$_SESSION['opinventario']=0;
          in_array(51,$valores)?$_SESSION['ajustei']=1:$_SESSION['ajustei']=0;
          in_array(52,$valores)?$_SESSION['traslado']=1:$_SESSION['traslado']=0;
          in_array(53,$valores)?$_SESSION['ajustep']=1:$_SESSION['ajustep']=0;
          in_array(58,$valores)?$_SESSION['rinventario']=1:$_SESSION['rinventario']=0;
            
          in_array(60,$valores)?$_SESSION['compras']=1:$_SESSION['compras']=0;
          in_array(61,$valores)?$_SESSION['proveedor']=1:$_SESSION['proveedor']=0;
          in_array(62,$valores)?$_SESSION['tipoproveedor']=1:$_SESSION['tipoproveedor']=0;
          in_array(64,$valores)?$_SESSION['condpago']=1:$_SESSION['condpago']=0;
          in_array(66,$valores)?$_SESSION['zona']=1:$_SESSION['zona']=0;
          in_array(70,$valores)?$_SESSION['opcompras']=1:$_SESSION['opcompras']=0;
          in_array(71,$valores)?$_SESSION['comprac']=1:$_SESSION['comprac']=0;
          in_array(72,$valores)?$_SESSION['comprap']=1:$_SESSION['comprap']=0;
          in_array(73,$valores)?$_SESSION['compraf']=1:$_SESSION['compraf']=0;
          in_array(74,$valores)?$_SESSION['comprasr']=1:$_SESSION['comprasr']=0;
          in_array(75,$valores)?$_SESSION['pago']=1:$_SESSION['pago']=0;
          in_array(76,$valores)?$_SESSION['documentoc']=1:$_SESSION['documentoc']=0;
  
          in_array(80,$valores)?$_SESSION['ventas']=1:$_SESSION['ventas']=0;
          in_array(81,$valores)?$_SESSION['cliente']=1:$_SESSION['cliente']=0;
          in_array(82,$valores)?$_SESSION['tipocliente']=1:$_SESSION['tipocliente']=0;
          in_array(83,$valores)?$_SESSION['tipoprecio']=1:$_SESSION['tipoprecio']=0;
          in_array(84,$valores)?$_SESSION['vendedor']=1:$_SESSION['vendedor']=0;
          in_array(85,$valores)?$_SESSION['turnopv']=1:$_SESSION['turnopv']=0;
          in_array(86,$valores)?$_SESSION['condpago']=1:$_SESSION['condpago']=0;	
          in_array(87,$valores)?$_SESSION['zona']=1:$_SESSION['zona']=0;	
          in_array(90,$valores)?$_SESSION['opventas']=1:$_SESSION['opventas']=0;
          in_array(91,$valores)?$_SESSION['ventac']=1:$_SESSION['ventac']=0;
          in_array(92,$valores)?$_SESSION['ventap']=1:$_SESSION['ventap']=0;
          in_array(93,$valores)?$_SESSION['ventaf']=1:$_SESSION['ventaf']=0;
          in_array(94,$valores)?$_SESSION['ventasr']=1:$_SESSION['ventasr']=0;
          in_array(95,$valores)?$_SESSION['cobro']=1:$_SESSION['cobro']=0;
          in_array(96,$valores)?$_SESSION['documentov']=1:$_SESSION['documentov']=0;
          in_array(97,$valores)?$_SESSION['tpventa']=1:$_SESSION['tpventa']=0;
            
          in_array(100,$valores)?$_SESSION['bancos']=1:$_SESSION['bancos']=0;
          in_array(101,$valores)?$_SESSION['banco']=1:$_SESSION['banco']=0;
          in_array(102,$valores)?$_SESSION['caja']=1:$_SESSION['caja']=0;
          in_array(103,$valores)?$_SESSION['cuenta']=1:$_SESSION['cuenta']=0;
          in_array(104,$valores)?$_SESSION['ipago']=1:$_SESSION['ipago']=0;	
          in_array(105,$valores)?$_SESSION['beneficiario']=1:$_SESSION['beneficiario']=0;
          in_array(110,$valores)?$_SESSION['opbancos']=1:$_SESSION['opbancos']=0;
          in_array(111,$valores)?$_SESSION['movcaja']=1:$_SESSION['movcaja']=0;
          in_array(112,$valores)?$_SESSION['movbanco']=1:$_SESSION['movbanco']=0;
          in_array(113,$valores)?$_SESSION['depbanco']=1:$_SESSION['depbanco']=0;
          in_array(114,$valores)?$_SESSION['odpago']=1:$_SESSION['odpago']=0;
          in_array(117,$valores)?$_SESSION['conciliacion']=1:$_SESSION['conciliacion']=0;
          in_array(119,$valores)?$_SESSION['rbanco']=1:$_SESSION['rbanco']=0;			


          $arrRspta=array("status"=>true,"msg"=>"Bienvenido ".$_SESSION['tdesc_usuario']."!","icon"=>"success");

         } else {
           $arrRspta=array("status"=>false,"msg"=>"Usuario o Clave Incorrecta!","icon"=>"error");
           session_unset();
           session_destroy();
         }          
       } else {
         $arrRspta=array("status"=>false,"msg"=>"No Es Posible Iniciar Sesion<br>\n
         El Usuario de encuentra <b>Inactivo</b>!","icon"=>"info");
         session_unset();
         session_destroy();
       }
   }   
  echo json_encode($arrRspta,JSON_UNESCAPED_UNICODE);
  } 


  
  public function SessionOut(){
    // if (isset($_POST["security"])) {
    //   session_unset();//Destruìmos la sesión
    //   $_SESSION = array(); // Destroy the variables 
    //   unset($_SESSION);
    //   session_destroy(); // Destroy the session 
    //   setcookie('PHPSESSID', ", time()-3600,'/', ", 0, 0);//Destroy the cookie 
    // } else {
    //   header("Location:".base_URL()."Error403");
    // }
  }

}
