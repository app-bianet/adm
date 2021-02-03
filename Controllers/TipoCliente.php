<?php
class TipoCliente extends Controllers{

  public function __construct(){
    session_start();
    ob_start();
    if (!isset($_SESSION['sidusuario'])){
      header("Location:".base_URL()."login");
      session_unset();
      session_destroy();
    } else{
      if($_SESSION['tipocliente']!=1)  {
        header("Location:".base_URL()."error403");
      } 
    }
    ob_end_flush();     
    parent::__construct();
  }

  public function tipocliente(){
    $data['page_tag']="Tipos de Clientes";
    $data['page_title']=".:: Tipo de Cliente ::.";
    $data['page_name']="tipocliente";
    $data['func']="functions_tipocliente.js";
    $this->views->getView($this,"tipocliente",$data);
  }

  public function Insertar(){
    if(isset($_POST["security"])){
      $idtipocliente=isset($_POST["idtipocliente"])? limpiarCadena($_POST["idtipocliente"]):"";
      $idtipoprecio=isset($_POST["idtipoprecio"])? limpiarCadena($_POST["idtipoprecio"]):"";
      $cod_tipocliente=isset($_POST["cod_tipocliente"])? limpiarCadena($_POST["cod_tipocliente"]):"";
      $desc_tipocliente=isset($_POST["desc_tipocliente"])? limpiarCadena($_POST["desc_tipocliente"]):"";

      if ($idtipocliente==0) {
        $request=$this->model->InsertDt($idtipoprecio,$cod_tipocliente,$desc_tipocliente);
        $option=1;
      } else {
        $request=$this->model->EditarDt($idtipocliente,$idtipoprecio,$cod_tipocliente,$desc_tipocliente);
        $option=2;
      }

      if($request==1){
        if ($option==1) {
          $arrRspta=array("status"=>true,"msg"=>"Registro Ingresado Correctamente!");
        } else {
          $arrRspta=array("status"=>true,"msg"=>"Registro Actualizado Correctamente!");
        }
      } else if ($request=="1062"){
        $arrRspta=array("status"=>false,"msg"=>"El Código <b>".$cod_tipocliente."</b> ya se encuentra Registrado! 
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
        $idtipocliente = $_POST['eliminar_reg'];
        foreach ($idtipocliente as $valor) {
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
      echo json_encode($arrRspta,JSON_UNESCAPED_UNICODE);
    } else{
      header("Location:".base_URL()."Error404");
    }
  }

  public function Mostrar(){
    if (isset($_POST['idtipocliente'])) {
      $idtipocliente=limpiarCadena($_POST['idtipocliente']);
      if ($idtipocliente>0) {
        $arrData=$this->model->ShowDt($idtipocliente);
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
    if (isset($_POST['idtipocliente'])) {
      $idtipocliente=intval(limpiarCadena($_POST['idtipocliente']));
      $estatus=intval(1);
      $request=$this->model->EstatusDt($idtipocliente,$estatus);
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
    if (isset($_POST['idtipocliente'])) {
      $idtipocliente=intval(limpiarCadena($_POST['idtipocliente']));
      $estatus=intval(0);
      $request=$this->model->EstatusDt($idtipocliente,$estatus);
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
        <button type="button" class="btn btn-primary btn-xs" onclick="mostrar('.$arrData[$i]['idtipocliente'].')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil"></i></button>'.
        '<button type="button" class="btn btn-success btn-xs" onclick="desactivar('.$arrData[$i]['idtipocliente'].')" data-toggle="tooltip" data-placement="right" title="Desactivar"><i class="fa fa-check"></i></button>
        </small>';
        } else {
          $arrData[$i]['estatus']='<small class="badge badge-danger">Inactivo</small>';
          $arrData[$i]['opciones']=
          '<small '.$al.'center'.$w.'100px;" class="small btn-group">
          <button type="button" class="btn btn-primary btn-xs" onclick="mostrar('.$arrData[$i]['idtipocliente'].')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil"></i></button>'.
          '<button type="button" class="btn btn-warning btn-xs" onclick="activar('.$arrData[$i]['idtipocliente'].')" data-toggle="tooltip" data-placement="right" title="Activar"><i class="fa fa-exclamation-triangle"></i></button>
          </small>';   
        }
        $arrData[$i]['cod_tipocliente']='<h6>'.$arrData[$i]['cod_tipocliente'].'</h6>';
        $arrData[$i]['desc_tipocliente']='<h6>'.$arrData[$i]['desc_tipocliente'].'</h6>';
        $arrData[$i]['tipoprecio']='<h6>'.$arrData[$i]['cod_tipoprecio'].'-'.$arrData[$i]['desc_tipoprecio'].'</h6>';;
        $arrData[$i]['eliminar']='<input type="checkbox" name="eliminar_reg[]" value="'.$arrData[$i]['idtipocliente'].'">';
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
          echo '<option value="'.$arrData[$i]['idtipocliente'].'">'.$arrData[$i]['cod_tipocliente'].'-'.$arrData[$i]['desc_tipocliente'].'</option>';
        }
      } else {
        echo '<option readonly>No Existen Registros!</option>';
      }
    } else {
      header("Location:".base_URL()."Error403");
    }
  }


  
}