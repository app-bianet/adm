<?php
class IPago extends Controllers{

  public function __construct(){   
    parent::__construct();
  }

  public function ipago(){
    ob_start();
    session_start();
    if (!isset($_SESSION["sidusuario"])){
      header("Location:".base_URL()."login");
    } else {
      if ($_SESSION['ipago']==1){     
        $data['page_tag']="Instrumentos de Pago";
        $data['page_title']=".:: Instrumentos de Pago ::.";
        $data['page_name']="ipago";
        $data['func']="functions_ipago.js";
        $this->views->getView($this,"ipago",$data);
      } else {
        header("Location:".base_URL()."error403");
      }
    }
    ob_end_flush();
  }

  public function Insertar(){
    if(isset($_POST["security"])){
      $idipago=isset($_POST["idipago"])? limpiarCadena($_POST["idipago"]):"";
      $cod_ipago=isset($_POST["cod_ipago"])? limpiarCadena($_POST["cod_ipago"]):"";
      $desc_ipago=isset($_POST["desc_ipago"])? limpiarCadena($_POST["desc_ipago"]):"";
      $comision=isset($_POST["comision"])? limpiarCadena($_POST["comision"]):"";
      $recargo=isset($_POST["recargo"])? limpiarCadena($_POST["recargo"]):"";

      if (empty($idipago)) {
        $request=$this->model->InsertDt($cod_ipago,$desc_ipago,insertNumber($comision),insertNumber($recargo));
        $option=1;
      } else {
       $request=$this->model->EditarDt($idipago,$cod_ipago,$desc_ipago,insertNumber($comision),insertNumber($recargo));
        $option=2;
      }

      if($request>0){
        if ($option==1) {
          $arrRspta=array("status"=>true,"msg"=>"Registro Ingresado Correctamente!");
        } else {
          $arrRspta=array("status"=>true,"msg"=>"Registro Actualizado Correctamente!");
        }
      } else if ($request=="duplicado"){
        $arrRspta=array("status"=>false,"msg"=>"El Código <b>".$cod_ipago."</b> ya se encuentra Registrado! 
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
        $idipago = $_POST['eliminar_reg'];
        foreach ($idipago as $valor) {
          $request = $this->model->EliminarDt($valor);
        }
        if ($request == 1) {
          $arrRspta = array("status" => true, "msg" => "Registros Eliminados Correctamente!");
        } else if ($request=="relacion") {
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
    if (isset($_POST['idipago'])) {
      $idipago=intval(limpiarCadena($_POST['idipago']));
      if ($idipago>0) {
        $arrData=$this->model->ShowDt($idipago);
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
    if (isset($_POST['idipago'])) {
      $idipago=intval(limpiarCadena($_POST['idipago']));
      $estatus=intval(1);
      $request=$this->model->EstatusDt($idipago,$estatus);
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
    if (isset($_POST['idipago'])) {
      $idipago=intval(limpiarCadena($_POST['idipago']));
      $estatus=intval(0);
      $request=$this->model->EstatusDt($idipago,$estatus);
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
          <button type="button" class="btn btn-primary btn-xs" onclick="mostrar('.$arrData[$i]['idipago'].')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil"></i></button>
          <button type="button" class="btn btn-success btn-xs" onclick="desactivar('.$arrData[$i]['idipago'].')" data-toggle="tooltip" data-placement="right" title="Desactivar"><i class="fa fa-check"></i></button>
          </small>';
        } else {
          $arrData[$i]['estatus']='<small class="badge badge-danger">Inactivo</small>';
          $arrData[$i]['opciones']=
          '<h6 '.$al.'center'.$w.'100px;" class="small btn-group">
          <button type="button" class="btn btn-primary btn-xs" onclick="mostrar('.$arrData[$i]['idipago'].')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil"></i></button>
          <button type="button" class="btn btn-warning btn-xs" onclick="activar('.$arrData[$i]['idipago'].')" data-toggle="tooltip" data-placement="right" title="Activar"><i class="fa fa-exclamation-triangle"></i></button>
          </small>';   
        }
        $arrData[$i]['cod_ipago']='<h6>'.$arrData[$i]['cod_ipago'].'</h6>';
        $arrData[$i]['desc_ipago']='<h6>'.$arrData[$i]['desc_ipago'].'</h6>';
        $arrData[$i]['comision']='<h6>'.formatMoneyP($arrData[$i]['comision'],2).'</h6>';
        $arrData[$i]['recargo']='<h6>'.formatMoneyP($arrData[$i]['recargo'],2).'</h6>';
        $arrData[$i]['eliminar']='<input type="checkbox" name="eliminar_reg[]" value="'.$arrData[$i]['idipago'].'">';
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
      if ($arrData) {
        for ($i=0; $i<count($arrData);$i++) { 
          echo '<option value="'.$arrData[$i]['idipago'].'">'.$arrData[$i]['cod_ipago'].'-'.$arrData[$i]['desc_ipago'].'</option>';
        }
      } else {
        echo '<option readonly>No Existen Registros!</option>';
      }
    } else {
      header("Location:".base_URL()."Error403");
    }
  }
  
}