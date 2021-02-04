<?php
class Correlativo extends Controllers{

  public function __construct(){
    parent::__construct();
  }

  public function correlativo(){
    ob_start();
    session_start();
    if (!isset($_SESSION["sidusuario"])){
      header("Location:".base_URL()."login");
    } else {
      if ($_SESSION['correlativo']==1){     
        $data['page_tag']="Series de Operaciones";
        $data['page_title']=".:: Series ::.";
        $data['page_name']="correlativo";
        $data['func']="functions_correlativo.js";
        $this->views->getView($this,"correlativo",$data);
      } else {
        header("Location:".base_URL()."error403");
      }
    }
    ob_end_flush();
  }

  public function Insertar(){
    if(isset($_POST["security"])){
      $idcorrelativo=isset($_POST["idcorrelativo"])? limpiarCadena($_POST["idcorrelativo"]):"";
      $cod_correlativo=isset($_POST["cod_correlativo"])? limpiarCadena($_POST["cod_correlativo"]):"";
      $desc_correlativo=isset($_POST["desc_correlativo"])? limpiarCadena($_POST["desc_correlativo"]):"";
      $grupo=isset($_POST["grupo"])? limpiarCadena($_POST["grupo"]):"";
      $tabla=isset($_POST["tabla"])? limpiarCadena($_POST["tabla"]):"";
      $cadena=isset($_POST["cadena"])? limpiarCadena($_POST["cadena"]):"";
      $precadena=isset($_POST["precadena"])? limpiarCadena($_POST["precadena"]):"";
      $cod_num=isset($_POST["cod_num"])? limpiarCadena($_POST["cod_num"]):"";
      $largo=isset($_POST["largo"])? limpiarCadena($_POST["largo"]):"";

      if (empty($idcorrelativo)) {
        $request=$this->model->InsertDt($cod_correlativo,$desc_correlativo,$grupo,
        $tabla,$cadena,$precadena,$cod_num,$largo);
        $option=1;
      } else {
        $request=$this->model->EditarDt($idcorrelativo,$cod_correlativo,$desc_correlativo,$grupo,
        $tabla,$cadena,$precadena,$cod_num,$largo);
        $option=2;
      }

      if($request){
        if ($option==1) {
          $arrRspta=array("status"=>true,"msg"=>"Registro Ingresado Correctamente!");
        } else {
          $arrRspta=array("status"=>true,"msg"=>"Registro Actualizado Correctamente!");
        }
      } else if ($request=="1062"){
        $arrRspta=array("status"=>false,"msg"=>"El Código <b>".$cod_correlativo."</b> ya se encuentra Registrado! 
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
        $idcorrelativo = $_POST['eliminar_reg'];
        foreach ($idcorrelativo as $valor) {
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
    if (isset($_POST['idcorrelativo'])) {
      $idcorrelativo=intval(limpiarCadena($_POST['idcorrelativo']));
      if ($idcorrelativo>0) {
        $arrData=$this->model->ShowDt($idcorrelativo);
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
    if (isset($_POST['idcorrelativo'])) {
      $idcorrelativo=intval(limpiarCadena($_POST['idcorrelativo']));
      $estatus=intval(1);
      $request=$this->model->EstatusDt($idcorrelativo,$estatus);
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
    if (isset($_POST['idcorrelativo'])) {
      $idcorrelativo=intval(limpiarCadena($_POST['idcorrelativo']));
      $estatus=intval(0);
      $request=$this->model->EstatusDt($idcorrelativo,$estatus);
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
    //if (isset($_POST["security"])) {
      $arrData=$this->model->SelectDt();
      $al='style="text-align:';
      $w='; width:';
      for ($i=0; $i<count($arrData);$i++) { 
        if($arrData[$i]['estatus']==1){
          $arrData[$i]['estatus']='<small class="badge badge-success">Activo</small>';
          $arrData[$i]['opciones']=
        '<small '.$al.'center'.$w.'100px;" class="small btn-group">
        <button type="button" class="btn btn-primary btn-xs" onclick="mostrar('.$arrData[$i]['idcorrelativo'].')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil"></i></button>'.
        '<button type="button" class="btn btn-success btn-xs" onclick="desactivar('.$arrData[$i]['idcorrelativo'].')" data-toggle="tooltip" data-placement="right" title="Desactivar"><i class="fa fa-check"></i></button>
        </small>';
        } else {
          $arrData[$i]['estatus']='<small class="badge badge-danger">Inactivo</small>';
          $arrData[$i]['opciones']=
          '<small '.$al.'center'.$w.'100px;" class="small btn-group">
          <button type="button" class="btn btn-primary btn-xs" onclick="mostrar('.$arrData[$i]['idcorrelativo'].')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil"></i></button>'.
          '<button type="button" class="btn btn-warning btn-xs" onclick="activar('.$arrData[$i]['idcorrelativo'].')" data-toggle="tooltip" data-placement="right" title="Activar"><i class="fa fa-exclamation-triangle"></i></button>
          </small>';   
        }
        $arrData[$i]['eliminar']='<input type="checkbox" name="eliminar_reg[]" value="'.$arrData[$i]['idcorrelativo'].'">';
      }
      echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
      die();
    // } else{
    //   header("Location:".base_URL()."Error403");
    // }
  }

  public function Selectpicker(){
    if (isset($_POST["security"])) {
      $arrData=$this->model->ListDt();
      for ($i=0; $i<count($arrData);$i++) { 
        echo '<option value="'.$arrData[$i]['idcorrelativo'].'">'.$arrData[$i]['cod_correlativo'].'-'.$arrData[$i]['desc_correlativo'].'</option>';
      }
    } else {
      header("Location:".base_URL()."Error403");
    }
  }

  public function GenerarCod(){
    if (isset($_POST["security"])) {
      $arrData=$this->model->GenerarCod($_POST['tabla']);
      echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
      die();
    } else {
      header("Location:".base_URL()."Error403");
    }
  }
  
}