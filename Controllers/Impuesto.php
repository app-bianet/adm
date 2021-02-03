<?php
class Impuesto extends Controllers{

  public function __construct(){
    session_start();
    ob_start();
    if (!isset($_SESSION['sidusuario'])){
      header("Location:".base_URL()."login");
      session_unset();
      session_destroy();
    } else{
      if($_SESSION['impuesto']!=1)  {
        header("Location:".base_URL()."error403");
      } 
    }
    ob_end_flush();     
    parent::__construct();
  }

  public function impuesto(){
    $data['page_tag']="Impuesto";
    $data['page_title']=".:: Impuesto ::.";
    $data['page_name']="impuesto";
    $data['func']="functions_impuesto.js";
    $this->views->getView($this,"impuesto",$data);
  }

  public function Insertar(){
    if(isset($_POST["security"])){
      $idimpuesto=isset($_POST["idimpuesto"])? limpiarCadena($_POST["idimpuesto"]):"";
      $cod_impuesto=isset($_POST["cod_impuesto"])? limpiarCadena($_POST["cod_impuesto"]):"";
      $desc_impuesto=isset($_POST["desc_impuesto"])? limpiarCadena($_POST["desc_impuesto"]):"";
      $simbolo=isset($_POST["simbolo"])? limpiarCadena($_POST["simbolo"]):"";
      $tasa=isset($_POST["tasa"])? limpiarCadena($_POST["tasa"]):"";
      $fechareg=isset($_POST["fechareg"])? limpiarCadena($_POST["fechareg"]):"";

      if (empty($idimpuesto)) {
        $request=$this->model->InsertDt($cod_impuesto,$desc_impuesto,$simbolo,$tasa,formatDate($fechareg));
        $option=1;
      } else {
       $request=$this->model->EditarDt($idimpuesto,$cod_impuesto,$desc_impuesto,$simbolo,$tasa,formatDate($fechareg));
        $option=2;
      }

      if($request==1){
        if ($option==1) {
          $arrRspta=array("status"=>true,"msg"=>"Registro Ingresado Correctamente!");
        } else {
          $arrRspta=array("status"=>true,"msg"=>"Registro Actualizado Correctamente!");
        }
      } else if ($request=="1062"){
        $arrRspta=array("status"=>false,"msg"=>"El Código <b>".$cod_impuesto."</b> ya se encuentra Registrado! 
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
        $idimpuesto = $_POST['eliminar_reg'];
        foreach ($idimpuesto as $valor) {
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
    if (isset($_POST['idimpuesto'])) {
      $idimpuesto=intval(limpiarCadena($_POST['idimpuesto']));
      if ($idimpuesto>0) {
        $arrData=$this->model->ShowDt($idimpuesto);
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
    if (isset($_POST['idimpuesto'])) {
      $idimpuesto=intval(limpiarCadena($_POST['idimpuesto']));
      $estatus=intval(1);
      $request=$this->model->EstatusDt($idimpuesto,$estatus);
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
    if (isset($_POST['idimpuesto'])) {
      $idimpuesto=intval(limpiarCadena($_POST['idimpuesto']));
      $estatus=intval(0);
      $request=$this->model->EstatusDt($idimpuesto,$estatus);
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
          <button type="button" class="btn btn-primary btn-xs" onclick="mostrar('.$arrData[$i]['idimpuesto'].')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil"></i></button>'.
          '<button type="button" class="btn btn-success btn-xs" onclick="desactivar('.$arrData[$i]['idimpuesto'].')" data-toggle="tooltip" data-placement="right" title="Desactivar"><i class="fa fa-check"></i></button>
          </small>';
        } else {
          $arrData[$i]['estatus']='<small class="badge badge-danger">Inactivo</small>';
          $arrData[$i]['opciones']=
          '<small '.$al.'center'.$w.'100px;" class="small btn-group">
          <button type="button" class="btn btn-primary btn-xs" onclick="mostrar('.$arrData[$i]['idimpuesto'].')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil"></i></button>'.
          '<button type="button" class="btn btn-warning btn-xs" onclick="activar('.$arrData[$i]['idimpuesto'].')" data-toggle="tooltip" data-placement="right" title="Activar"><i class="fa fa-exclamation-triangle"></i></button>
          </small>';   
        }
        $arrData[$i]['cod_impuesto']='<h6>'.$arrData[$i]['cod_impuesto'].'</h6>';
        $arrData[$i]['desc_impuesto']='<h6>'.$arrData[$i]['desc_impuesto'].'</h6>';
        $arrData[$i]['simbolo']='<h6>'.$arrData[$i]['simbolo'].'</h6>';
        $arrData[$i]['tasa']='<h6>'.formatMoneyP($arrData[$i]['tasa'],2).'</h6>';
        $arrData[$i]['eliminar']='<input type="checkbox" name="eliminar_reg[]" value="'.$arrData[$i]['idimpuesto'].'">';
      }
      echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
      die();
    } else {
      header("Location:".base_URL()."Error403");
    }
  }

  public function Selectpicker(){
    if (isset($_POST["security"])) {
      $arrData=$this->model->ListDt();
      if ($arrData) {
        for ($i=0; $i<count($arrData);$i++) { 
          echo '<option value="'.$arrData[$i]['idimpuesto'].'">'.$arrData[$i]['desc_impuesto'].'</option>';
        }
      } else {
        echo '<option readonly>No Existen Registros!</option>';
      }
    } else {
      header("Location:".base_URL()."Error403");
    }
  }
  
}