<?php
class TipoPrecio extends Controllers{

  public function __construct(){
    parent::__construct();
  }

  public function tipoprecio(){
    ob_start();
    session_start();
    if (!isset($_SESSION["sidusuario"])){
      header("Location:".base_URL()."login");
    } else {
      if ($_SESSION['tipoprecio']==1){     
        $data['page_tag']="Tipos de Precios";
        $data['page_title']=".:: Tipos de Precios ::.";
        $data['page_name']="tipoprecio";
        $data['func']="functions_tipoprecio.js";
        $this->views->getView($this,"tipoprecio",$data);
      } else {
        header("Location:".base_URL()."error403");
      }
    }
    ob_end_flush();
  }

  public function Insertar(){
    if(isset($_POST["security"])){
      $idtipoprecio=isset($_POST["idtipoprecio"])? limpiarCadena($_POST["idtipoprecio"]):"";
      $cod_tipoprecio=isset($_POST["cod_tipoprecio"])? limpiarCadena($_POST["cod_tipoprecio"]):"";
      $desc_tipoprecio=isset($_POST["desc_tipoprecio"])? limpiarCadena($_POST["desc_tipoprecio"]):"";

      if (empty($idtipoprecio)) {
        $request=$this->model->InsertDt($cod_tipoprecio,$desc_tipoprecio);
        $option=1;
      } else {
       $request=$this->model->EditarDt($idtipoprecio,$cod_tipoprecio,$desc_tipoprecio,$desc_tipoprecio);
        $option=2;
      }

      if($request==1){
        if ($option==1) {
          $arrRspta=array("status"=>true,"msg"=>"Registro Ingresado Correctamente!");
        } else {
          $arrRspta=array("status"=>true,"msg"=>"Registro Actualizado Correctamente!");
        }
      } else if ($request=="1062"){
        $arrRspta=array("status"=>false,"msg"=>"El Código <b>".$cod_tipoprecio."</b> ya se encuentra Registrado! 
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
        $idtipoprecio = $_POST['eliminar_reg'];
        foreach ($idtipoprecio as $valor) {
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
    if (isset($_POST['idtipoprecio'])) {
      $idtipoprecio=intval(limpiarCadena($_POST['idtipoprecio']));
      if ($idtipoprecio>0) {
        $arrData=$this->model->ShowDt($idtipoprecio);
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
    if (isset($_POST['idtipoprecio'])) {
      $idtipoprecio=intval(limpiarCadena($_POST['idtipoprecio']));
      $estatus=intval(1);
      $request=$this->model->EstatusDt($idtipoprecio,$estatus);
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
    if (isset($_POST['idtipoprecio'])) {
      $idtipoprecio=intval(limpiarCadena($_POST['idtipoprecio']));
      $estatus=intval(0);
      $request=$this->model->EstatusDt($idtipoprecio,$estatus);
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
          <button type="button" class="btn btn-primary btn-xs" onclick="mostrar('.$arrData[$i]['idtipoprecio'].')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil"></i></button>'.
          '<button type="button" class="btn btn-success btn-xs" onclick="desactivar('.$arrData[$i]['idtipoprecio'].')" data-toggle="tooltip" data-placement="right" title="Desactivar"><i class="fa fa-check"></i></button>
          </small>';
        } else {
          $arrData[$i]['estatus']='<small class="badge badge-danger">Inactivo</small>';
          $arrData[$i]['opciones']=
          '<small '.$al.'center'.$w.'100px;" class="small btn-group">
          <button type="button" class="btn btn-primary btn-xs" onclick="mostrar('.$arrData[$i]['idtipoprecio'].')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil"></i></button>'.
          '<button type="button" class="btn btn-warning btn-xs" onclick="activar('.$arrData[$i]['idtipoprecio'].')" data-toggle="tooltip" data-placement="right" title="Activar"><i class="fa fa-exclamation-triangle"></i></button>
          </small>';   
        }
        $arrData[$i]['cod_tipoprecio']='<h6>'.$arrData[$i]['cod_tipoprecio'].'</h6>';
        $arrData[$i]['desc_tipoprecio']='<h6>'.$arrData[$i]['desc_tipoprecio'].'</h6>';
        $arrData[$i]['eliminar']='<input type="checkbox" name="eliminar_reg[]" value="'.$arrData[$i]['idtipoprecio'].'">';
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
          echo '<option value="'.$arrData[$i]['idtipoprecio'].'">'.$arrData[$i]['cod_tipoprecio'].'-'.$arrData[$i]['desc_tipoprecio'].'</option>';
        }
      } else {
        echo '<option readonly>No Existen Registros!</option>';
      }
    } else {
      header("Location:".base_URL()."Error403");
    }
  }
  
}