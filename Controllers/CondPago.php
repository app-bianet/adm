<?php
class CondPago extends Controllers{

  public function __construct(){
    session_start();
    ob_start();
    if (!isset($_SESSION['sidusuario'])){
      header("Location:".base_URL()."login");
      session_unset();
      session_destroy();
    } else{
      if($_SESSION['condpago']!=1)  {
        header("Location:".base_URL()."error403");
      } 
    }
    ob_end_flush();     
    parent::__construct();
  }

  public function condpago(){
    $data['page_tag']="Condición de Pago";
    $data['page_title']=".:: Condición de Pago ::.";
    $data['page_name']="condpago";
    $data['func']="functions_condpago.js";
    $this->views->getView($this,"condpago",$data);
  }

  public function Insertar(){
    if(isset($_POST["security"])){
      $idcondpago=isset($_POST["idcondpago"])? limpiarCadena($_POST["idcondpago"]):"";
      $cod_condpago=isset($_POST["cod_condpago"])? limpiarCadena($_POST["cod_condpago"]):"";
      $desc_condpago=isset($_POST["desc_condpago"])? limpiarCadena($_POST["desc_condpago"]):"";
      $dias=isset($_POST["dias"])? limpiarCadena($_POST["dias"]):"";

      if ($idcondpago==0) {
        $resquest=$this->model->InsertDt($cod_condpago,$desc_condpago,$dias);
        $option=1;
      } else {
        $resquest=$this->model->EditarDt($idcondpago,$cod_condpago,$desc_condpago,$dias);
        $option=2;
      }

      if($resquest==1){
        if ($option==1) {
          $arrRspta=array("status"=>true,"msg"=>"Registro Ingresado Correctamente!");
        } else {
          $arrRspta=array("status"=>true,"msg"=>"Registro Actualizado Correctamente!");
        }
      } else if ($resquest=="duplicado"){
        $arrRspta=array("status"=>false,"msg"=>"El Código <b>".$cod_condpago."</b> ya se encuentra Registrado! 
        <br>No es posible ingresar <b>Registros Duplicados!</b>");
      } else {
        if ($resquest=='error_insert') {
          $arrRspta=array("status"=>false,"msg"=>"Error Insertando Registros!");
        } else {
          $arrRspta=array("status"=>false,"msg"=>"Error Editando Registros!");
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
        $idcondpago = $_POST['eliminar_reg'];
        foreach ($idcondpago as $valor) {
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
    if (isset($_POST['idcondpago'])) {
      $idcondpago=limpiarCadena($_POST['idcondpago']);
      if ($idcondpago>0) {
        $arrData=$this->model->ShowDt($idcondpago);
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
    if (isset($_POST['idcondpago'])) {
      $idcondpago=intval(limpiarCadena($_POST['idcondpago']));
      $estatus=intval(1);
      $resquest=$this->model->EstatusDt($idcondpago,$estatus);
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
    if (isset($_POST['idcondpago'])) {
      $idcondpago=intval(limpiarCadena($_POST['idcondpago']));
      $estatus=intval(0);
      $resquest=$this->model->EstatusDt($idcondpago,$estatus);
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
    if (isset($_POST["security"])) {
      $arrData=$this->model->SelectDt();
      $al='style="text-align:';
      $w='; width:';
      for ($i=0; $i<count($arrData);$i++) { 
        if($arrData[$i]['estatus']==1){
          $arrData[$i]['estatus']='<small class="badge badge-success">Activo</small>';
          $arrData[$i]['opciones']=
        '<small '.$al.'center'.$w.'100px;" class="small btn-group">
        <button type="button" class="btn btn-primary btn-xs" onclick="mostrar('.$arrData[$i]['idcondpago'].')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil"></i></button>'.
        '<button type="button" class="btn btn-success btn-xs" onclick="desactivar('.$arrData[$i]['idcondpago'].')" data-toggle="tooltip" data-placement="right" title="Desactivar"><i class="fa fa-check"></i></button>
        </small>';
        } else {
          $arrData[$i]['estatus']='<small class="badge badge-danger">Inactivo</small>';
          $arrData[$i]['opciones']=
          '<small '.$al.'center'.$w.'100px;" class="small btn-group">
          <button type="button" class="btn btn-primary btn-xs" onclick="mostrar('.$arrData[$i]['idcondpago'].')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil"></i></button>'.
          '<button type="button" class="btn btn-warning btn-xs" onclick="activar('.$arrData[$i]['idcondpago'].')" data-toggle="tooltip" data-placement="right" title="Activar"><i class="fa fa-exclamation-triangle"></i></button>
          </small>';   
        }
        $arrData[$i]['cod_condpago']='<h6 '.$al.'center'.$w.'150px">'.$arrData[$i]['cod_condpago'].'</h6>';
        $arrData[$i]['desc_condpago']='<h6 '.$al.''.$w.'400px">'.$arrData[$i]['desc_condpago'].'</h6>';
        $arrData[$i]['dias']='<h6 '.$al.'center'.$w.'50px" >'.$arrData[$i]['dias'].'</h6>';
        $arrData[$i]['eliminar']='<input type="checkbox" name="eliminar_reg[]" value="'.$arrData[$i]['idcondpago'].'">';
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
      for ($i=0; $i<count($arrData);$i++) { 
        echo '<option value="'.$arrData[$i]['idcondpago'].'">'.$arrData[$i]['cod_condpago'].'-'.$arrData[$i]['desc_condpago'].'</option>';
      }
    } else {
      header("Location:".base_URL()."Error403");
    }
  }
  
}