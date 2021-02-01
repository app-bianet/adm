<?php
class Impuestoz extends Controllers{

  public function __construct(){
    session_start();
    ob_start();
    if (!isset($_SESSION['sidusuario'])){
      header("Location:".base_URL()."login");
      session_unset();
      session_destroy();
    } else{
      if($_SESSION['impuestoz']!=1)  {
        header("Location:".base_URL()."error403");
      } 
    }
    ob_end_flush();     
    parent::__construct();
  }

  public function impuestoz(){
    $data['page_tag']="Impuestoz";
    $data['page_title']=".:: Impuestoz ::.";
    $data['page_name']="impuestoz";
    $data['func']="functions_impuestoz.js";
    $this->views->getView($this,"impuestoz",$data);
  }

  public function Insertar(){
    if(isset($_POST["security"])){
      $idimpuestoz=isset($_POST["idimpuestoz"])? limpiarCadena($_POST["idimpuestoz"]):"";
      $idimpuestozd=isset($_POST["idimpuestozd"])? limpiarCadena($_POST["idimpuestozd"]):"";
      $cod_concepto=isset($_POST["cod_concepto"])? limpiarCadena($_POST["cod_concepto"]):"";
      $desc_concepto=isset($_POST["desc_concepto"])? limpiarCadena($_POST["desc_concepto"]):"";
      $base=isset($_POST["base"])? limpiarCadena($_POST["base"]):"";
      $retencion=isset($_POST["retencion"])? limpiarCadena($_POST["retencion"]):"";
      $sustraendo=isset($_POST["sustraendo"])? limpiarCadena($_POST["sustraendo"]):"";

      if (empty($idimpuestozd)) {
        $resquest=$this->model->InsertDt($idimpuestoz,$cod_concepto,$desc_concepto,$base,$retencion,$sustraendo);
        $option=1;
      } else {
       $resquest=$this->model->EditarDt($idimpuestozd,$cod_concepto,$desc_concepto,$base,$retencion,$sustraendo);
        $option=2;
      }

      if($resquest==1){
        if ($option==1) {
          $arrRspta=array("status"=>true,"msg"=>"Registro Ingresado Correctamente!");
        } else {
          $arrRspta=array("status"=>true,"msg"=>"Registro Actualizado Correctamente!");
        }
      } else if ($resquest=="duplicado"){
        $arrRspta=array("status"=>false,"msg"=>"El Código <b>".$cod_concepto."</b> ya se encuentra Registrado! 
        <br>No es posible ingresar <b>Registros Duplicados!</b>");
      } else {
        if ($resquest=='error_insert') {
          $arrRspta=array("status"=>false,"msg"=>json_encode($resquest));
        } else {
          $arrRspta=array("status"=>false,"msg"=>json_encode($resquest));
        }
      }
      echo json_encode($arrRspta,JSON_UNESCAPED_UNICODE);    
    } else{
      header("Location:".base_URL()."Error404");
    }
  }

  public function Eliminar(){
    if (isset($_POST["security"])) {
      $resquest = '';
      if (empty($_POST['eliminar_reg'])) {
        $arrRspta = array("status" => false, "msg" => "No Seleccionó ningún Registro para Eliminar!");
      } else {
        $idimpuestoz = $_POST['eliminar_reg'];
        foreach ($idimpuestoz as $valor) {
          $resquest = $this->model->EliminarDt($valor);
        }
        if ($resquest == 'duplicado') {
          $arrRspta = array("status" => false, "msg" => "No es Posible Eliminar Registros Relacionados!");
        } else if ($resquest == 1) {
          $arrRspta = array("status" => true, "msg" => "Registros Eliminados Correctamente!");
        } else {
          $arrRspta = array("status" => false, "msg" => "Error eliminado Registros!");
        }
      }
      echo json_encode( $arrRspta , JSON_UNESCAPED_UNICODE);
    } else {
      header("Location:" . base_URL() . "Error404");
    }
  }

  public function Mostrar(){
    if (isset($_POST['idimpuestoz'])) {
      $idimpuestoz=intval(limpiarCadena($_POST['idimpuestoz']));
      if ($idimpuestoz>0) {
        $arrData=$this->model->ShowDt($idimpuestoz);
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

  public function MostrarDt(){
    if (isset($_POST['id'])) {
      $idimpuestozd=intval(limpiarCadena($_POST['id']));
      if ($idimpuestozd>0) {
        $arrData=$this->model->ShowRengDt($idimpuestozd);
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
    if (isset($_POST['idimpuestoz'])) {
      $idimpuestoz=intval(limpiarCadena($_POST['idimpuestoz']));
      $estatus=intval(1);
      $resquest=$this->model->EstatusDt($idimpuestoz,$estatus);
        if($resquest>0){
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
    if (isset($_POST['idimpuestoz'])) {
      $idimpuestoz=intval(limpiarCadena($_POST['idimpuestoz']));
      $estatus=intval(0);
      $resquest=$this->model->EstatusDt($idimpuestoz,$estatus);
        if($resquest>0){
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

      $arrData=$this->model->ListRengDt(POSTT($_POST['id']));
      for ($x=0; $x <count($arrData) ; $x++) {
        $arrData[$x]['opciones']='<h6 style="width:100px">
        <button type="button" class="btn btn-primary btn-xs" onclick="mostrar('.$arrData[$x]['idimpuestozd'].')">Editar</button></h6>';
        $arrData[$x]['cod_concepto']='<h6 class="text-center" style="width:50px">'.$arrData[$x]['cod_concepto'].'</h6>';
        $arrData[$x]['desc_concepto']='<h6 style="min-width:400px">'.$arrData[$x]['desc_concepto'].'</h6>';
        $arrData[$x]['base']='<h6 class="text-right" style="max-width:100px">'.$arrData[$x]['base'].'</h6>';
        $arrData[$x]['retencion']='<h6 class="text-right" style="max-width:120px">'.$arrData[$x]['retencion'].'</h6>';
        $arrData[$x]['sustraendo']='<h6 class="text-right" style="max-width:120px">'.$arrData[$x]['sustraendo'].'</h6>';
        $arrData[$x]['eliminar']='<h6 style="max-width:80px" class="text-center"><input type="checkbox" name="eliminar_reg[]" value="'.$arrData[$x]['idimpuestozd'].'"></h6>';
      }
      echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
      die();
  }

  public function Selectpicker(){

      $arrData=$this->model->ListDt();
      if ($arrData) {
        for ($i=0; $i<count($arrData);$i++) { 
          echo '<option value="'.$arrData[$i]['idimpuestoz'].'">'.$arrData[$i]['desc_impuestoz'].'</option>';
        }
      } else {
        echo '<option readonly>No Existen Registros!</option>';
      }

  }
  
}