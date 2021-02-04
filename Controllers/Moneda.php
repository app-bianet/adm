<?php
class Moneda extends Controllers{

  public function __construct(){
    parent::__construct();
  }

  public function moneda(){
    ob_start();
    session_start();
    if (!isset($_SESSION["sidusuario"])){
      header("Location:".base_URL()."login");
    } else {
      if ($_SESSION['moneda']==1){     
        $data['page_tag']="Monedas";
        $data['page_title']=".:: Monedas ::.";
        $data['page_name']="moneda";
        $data['func']="functions_moneda.js";
        $this->views->getView($this,"moneda",$data);
      } else {
        header("Location:".base_URL()."error403");
      }
    }
    ob_end_flush();
  }

  public function Insertar(){
    if(isset($_POST["security"])){
      $idmoneda=isset($_POST["idmoneda"])? limpiarCadena($_POST["idmoneda"]):"";
      $cod_moneda=isset($_POST["cod_moneda"])? limpiarCadena($_POST["cod_moneda"]):"";
      $simbolo=isset($_POST["simbolo"])? limpiarCadena($_POST["simbolo"]):"";
      $desc_moneda=isset($_POST["desc_moneda"])? limpiarCadena($_POST["desc_moneda"]):"";     
      $factor=isset($_POST["factor"])? limpiarCadena($_POST["factor"]):"";
      $base=isset($_POST["base"])? limpiarCadena($_POST["base"]):"";

      if (empty($idmoneda)) {
        $request=$this->model->InsertDt($cod_moneda,$desc_moneda,$simbolo,$factor,$base);
        $option=1;
      } else {
        $request=$this->model->EditarDt($idmoneda,$cod_moneda,$desc_moneda,$simbolo,$factor,$base);
        $option=2;
      }

      if($request){
        if ($option==1) {
          $arrRspta=array("status"=>true,"msg"=>"Registro Ingresado Correctamente!");
        } else {
          $arrRspta=array("status"=>true,"msg"=>"Registro Actualizado Correctamente!");
        }
      } else if ($request=="1062"){
        $arrRspta=array("status"=>false,"msg"=>"El Código <b>".$cod_moneda."</b> ya se encuentra Registrado! 
        <br>No es posible ingresar <b>Registros Duplicados!</b>");
      } else if($request=="moneda_base"){
        $arrRspta=array("status"=>false,"msg"=>"Error al Registrar!
        <br>Solo es Posible Indicar una Moneda como <b>Moneda Base</b>!");
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
        $idmoneda = $_POST['eliminar_reg'];
        foreach ($idmoneda as $valor) {
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
    if (isset($_POST['idmoneda'])) {
      $idmoneda=intval(limpiarCadena($_POST['idmoneda']));
      if ($idmoneda>0) {
        $arrData=$this->model->ShowDt($idmoneda);
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
    if (isset($_POST['idmoneda'])) {
      $idmoneda=intval(limpiarCadena($_POST['idmoneda']));
      $estatus=intval(1);
      $request=$this->model->EstatusDt($idmoneda,$estatus);
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
    if (isset($_POST['idmoneda'])) {
      $idmoneda=intval(limpiarCadena($_POST['idmoneda']));
      $estatus=intval(0);
      $request=$this->model->EstatusDt($idmoneda,$estatus);
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
        <button type="button" class="btn btn-primary btn-xs" onclick="mostrar('.$arrData[$i]['idmoneda'].')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil"></i></button>'.
        '<button type="button" class="btn btn-success btn-xs" onclick="desactivar('.$arrData[$i]['idmoneda'].')" data-toggle="tooltip" data-placement="right" title="Desactivar"><i class="fa fa-check"></i></button>
        </small>';
        } else {
          $arrData[$i]['estatus']='<small class="badge badge-danger">Inactivo</small>';
          $arrData[$i]['opciones']=
          '<small '.$al.'center'.$w.'100px;" class="small btn-group">
          <button type="button" class="btn btn-primary btn-xs" onclick="mostrar('.$arrData[$i]['idmoneda'].')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil"></i></button>'.
          '<button type="button" class="btn btn-warning btn-xs" onclick="activar('.$arrData[$i]['idmoneda'].')" data-toggle="tooltip" data-placement="right" title="Activar"><i class="fa fa-exclamation-triangle"></i></button>
          </small>';   
        }
        $arrData[$i]['cod_moneda']='<h6>'.$arrData[$i]['cod_moneda'].'</h6>';
        $arrData[$i]['desc_moneda']='<h6>'.$arrData[$i]['desc_moneda'].'</h6>';
        $arrData[$i]['factor']='<h6>'.formatMoney($arrData[$i]['factor']).'</h6>';;
        $arrData[$i]['base']=$arrData[$i]['base']?'<i class=" fa fa-check text-success"></i>':'<i class=" fa fa-remove text-red"></i>';
        $arrData[$i]['eliminar']='<input type="checkbox" name="eliminar_reg[]" value="'.$arrData[$i]['idmoneda'].'">';
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
      if ($arrData){
      for ($i=0; $i<count($arrData);$i++) { 
        echo '<option value="'.$arrData[$i]['idmoneda'].'">'.$arrData[$i]['cod_moneda'].'-'.$arrData[$i]['desc_moneda'].'</option>';
      }
      } else {
        echo '<option readonly>No Existen Registros!</option>';
      }
    } else {
      header("Location:".base_URL()."Error403");
    }
  }
  
}