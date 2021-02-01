<?php
class Usuario extends Controllers{

  public function __construct(){
    session_start();
    ob_start();
    if (!isset($_SESSION['sidusuario'])){
      header("Location:".base_URL()."login");
      session_unset();
      session_destroy();
    } else{
      if($_SESSION['usuariotb']!=1)  {
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
    if(isset($_POST["security"])){
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
        hashpw($clave),$imagen,formatDate($fechareg));
        $option=1;
      } else {
        $request=$this->model->EditarDt($idusuario,$idmacceso,$cod_usuario,$desc_usuario,$direccion,$telefono,$email,
        hashpw($clave),$imagen,formatDate($fechareg));
        $option=2;
      }

      if($request==1){
        if ($option==1) {
          $arrRspta=array("status"=>true,"msg"=>"Registro Ingresado Correctamente!");
        } else {
          $arrRspta=array("status"=>true,"msg"=>"Registro Actualizado Correctamente!");
        }
      } else if ($request=="1062"){
        $arrRspta=array("status"=>false,"msg"=>"El Código <b>".$cod_usuario."</b> ya se encuentra Registrado! 
        <br>No es posible ingresar <b>Registros Duplicados!</b>");
      } else {
        $arrRspta=array("status"=>false,"msg"=>$request);
      }
    echo json_encode($arrRspta,JSON_UNESCAPED_UNICODE);
    } else{
      header("Location:".base_URL()."Error404");
    }
  }

  public function Eliminar(){
    if (isset($_POST["security"])) {
      $request = '';
      if (empty($_POST['eliminar_reg'])) {
        $arrRspta = array("status" => false, "msg" => "No Seleccionó ningún Registro para Eliminar!");
      } else {
        $idusuario = $_POST['eliminar_reg'];
        foreach ($idusuario as $valor) {
          $request = $this->model->EliminarDt($valor);
        }
        if ($request == 1) {
          $arrRspta = array("status" => true, "msg" => "Registros Eliminados Correctamente!");
        } else if ($request == '1451') {
          $arrRspta = array("status" => false, "msg" => "No es Posible Eliminar Registros Relacionados!");
        } else {
          $arrRspta = array("status" => false, "msg" =>$request);
        }
      }
      echo json_encode( $arrRspta , JSON_UNESCAPED_UNICODE);
    } else {
      header("Location:" . base_URL() . "Error404");
    }
  }

  public function Mostrar(){
    if (isset($_POST['idusuario'])) {
      $idusuario=intval(limpiarCadena($_POST['idusuario']));
      if ($idusuario>0) {
        $arrData=$this->model->ShowDt($idusuario);
        if (empty($arrData)) {
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
    die(); 

  }

  public function Desactivar(){
    if (isset($_POST['idusuario'])) {
      $idusuario=intval(limpiarCadena($_POST['idusuario']));
      $estatus=intval(0);
      $request=$this->model->EstatusDt($idusuario,$estatus);
        if($request>0){
          $arrRspta=array("status"=>true,"msg"=>"Registro Desctivado Correctamente!");
        }else {
          $arrRspta=array("status"=>false,"msg"=>"Error al Desactivar el Registro!");
        }
      echo json_encode($arrRspta,JSON_UNESCAPED_UNICODE);
    } else{
      header("Location:".base_URL()."Error404");
    }
    die(); 
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
        $arrData[$i]['cod_usuario']='<h6 '.$al.'center'.$w.'150px">'.$arrData[$i]['cod_usuario'].'</h6>';
        $arrData[$i]['desc_usuario']='<h6 '.$al.''.$w.'">'.$arrData[$i]['desc_usuario'].'</h6>';
        $arrData[$i]['acceso']='<h6 '.$al.''.$w.'180px">'.$arrData[$i]['cod_macceso'].'-'.$arrData[$i]['desc_macceso'].'</h6>';;
        $arrData[$i]['eliminar']='<input type="checkbox" name="eliminar_reg[]" value="'.$arrData[$i]['idusuario'].'">';
      }
      echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
      die();
    } else{
      header("Location:".base_URL()."Error403");
    }

  }

  public function Selectpicker(){
    if (isset($_POST["security"])) {
      $arrData=$this->model->ListDt();
      if($arrData){
        for ($i=0; $i<count($arrData);$i++) { 
          echo '<option value="'.$arrData[$i]['idusuario'].'">'.$arrData[$i]['cod_usuario'].'-'.$arrData[$i]['desc_usuario'].'</option>';
        }
      } else {
        echo '<option readonly>No Existen Registros!</option>';
      }
    } else {
      header("Location:".base_URL()."Error403");
    }
  }

  public function ActualizarClave(){
    if (isset($_POST['idusuario'])) {
      $idusuario=intval(limpiarCadena($_POST['idusuario']));
      $clave=hashpw($_POST['clave']);
  
        $request=$this->model->EditarClave($idusuario,$clave);
        if($request>0){
          $arrRspta=array("status"=>true,"msg"=>"Clave Actualizada Exitosamente!");
        }else {
          $arrRspta=array("status"=>false,"msg"=>"Error al Actualizar la Clave!");
        }
        echo json_encode($arrRspta,JSON_UNESCAPED_UNICODE);
      } else{
        header("Location:".base_URL()."Error404");
      }
  }

  public function SessionOut(){
    if (isset($_POST["security"])) {
      session_unset();//Destruìmos la sesión
      $_SESSION = array(); // Destroy the variables 
      unset($_SESSION);
      session_destroy(); // Destroy the session 
      setcookie('PHPSESSID', ", time()-3600,'/', ", 0, 0);//Destroy the cookie 
    } else {
      header("Location:".base_URL()."Error403");
    }
  }
  
}