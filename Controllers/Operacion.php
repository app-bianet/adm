<?php
class Operacion extends Controllers{

  public function __construct(){
    parent::__construct();
  }

  public function operacion(){
    ob_start();
    session_start();
    if (!isset($_SESSION["sidusuario"])){
      header("Location:".base_URL()."login");
    } else {
      if ($_SESSION['operacion']==1){     
        $data['page_tag']=" Tipos de Operaciones";
        $data['page_title']=".:: Operaciones ::.";
        $data['page_name']="operacion";
        $data['func']="functions_operacion.js";
        $this->views->getView($this,"operacion",$data);
      } else {
        header("Location:".base_URL()."error403");
      }
    }
    ob_end_flush();
  }

  public function Insertar(){
    if(isset($_POST["security"])){
      $idoperacion=isset($_POST["idoperacion"])? limpiarCadena($_POST["idoperacion"]):"";
      $cod_operacion=isset($_POST["cod_operacion"])? limpiarCadena($_POST["cod_operacion"]):"";
      $desc_operacion=isset($_POST["desc_operacion"])? limpiarCadena($_POST["desc_operacion"]):"";
      $escompra=isset($_POST["escompra"])? limpiarCadena($_POST["escompra"]):"";
      $esventa=isset($_POST["esventa"])? limpiarCadena($_POST["esventa"]):"";
      $esinventario=isset($_POST["esinventario"])? limpiarCadena($_POST["esinventario"]):"";
      $esconfig=isset($_POST["esconfig"])? limpiarCadena($_POST["esconfig"]):"";
      $esbanco=isset($_POST["esbanco"])? limpiarCadena($_POST["esbanco"]):"";

      if (empty($idoperacion)) {
        $request=$this->model->InsertDt($cod_operacion,$desc_operacion,$escompra,$esventa,$esinventario,$esconfig,$esbanco);
        $option=1;
      } else {
       $request=$this->model->EditarDt($idoperacion,$cod_operacion,$desc_operacion,$escompra,$esventa,$esinventario,$esconfig,$esbanco);
        $option=2;
      }

      if($request>0){
        if ($option==1) {
          $arrRspta=array("status"=>true,"msg"=>"Registro Ingresado Correctamente!");
        } else {
          $arrRspta=array("status"=>true,"msg"=>"Registro Actualizado Correctamente!");
        }
      } else if ($request=="duplicado"){
        $arrRspta=array("status"=>false,"msg"=>"El Código <b>".$cod_operacion."</b> ya se encuentra Registrado! 
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
        $idoperacion = $_POST['eliminar_reg'];
        foreach ($idoperacion as $valor) {
          $request = $this->model->EliminarDt($valor);
        }
        if ($request  > 0) {
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
    if (isset($_POST['idoperacion'])) {
      $idoperacion=intval(limpiarCadena($_POST['idoperacion']));
      if ($idoperacion>0) {
        $arrData=$this->model->ShowDt($idoperacion);
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
    if (isset($_POST['idoperacion'])) {
      $idoperacion=intval(limpiarCadena($_POST['idoperacion']));
      $estatus=intval(1);
      $request=$this->model->EstatusDt($idoperacion,$estatus);
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
    if (isset($_POST['idoperacion'])) {
      $idoperacion=intval(limpiarCadena($_POST['idoperacion']));
      $estatus=intval(0);
      $request=$this->model->EstatusDt($idoperacion,$estatus);
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
          <button type="button" class="btn btn-primary btn-xs" onclick="mostrar('.$arrData[$i]['idoperacion'].')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil"></i></button>'.
          '<button type="button" class="btn btn-success btn-xs" onclick="desactivar('.$arrData[$i]['idoperacion'].')" data-toggle="tooltip" data-placement="right" title="Desactivar"><i class="fa fa-check"></i></button>
          </small>';
        } else {
          $arrData[$i]['estatus']='<small class="badge badge-danger">Inactivo</small>';
          $arrData[$i]['opciones']=
          '<small '.$al.'center'.$w.'100px;" class="small btn-group">
          <button type="button" class="btn btn-primary btn-xs" onclick="mostrar('.$arrData[$i]['idoperacion'].')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil"></i></button>'.
          '<button type="button" class="btn btn-warning btn-xs" onclick="activar('.$arrData[$i]['idoperacion'].')" data-toggle="tooltip" data-placement="right" title="Activar"><i class="fa fa-exclamation-triangle"></i></button>
          </small>';   
        }
        $arrData[$i]['cod_operacion']='<h6>'.$arrData[$i]['cod_operacion'].'</h6>';
        $arrData[$i]['desc_operacion']='<h6>'.$arrData[$i]['desc_operacion'].'</h6>';
        $arrData[$i]['escompra']=$arrData[$i]['escompra']?'<i class=" fa fa-check text-success"></i>':'<i class=" fa fa-remove text-red"></i>';
        $arrData[$i]['esventa']=$arrData[$i]['esventa']?'<i class=" fa fa-check text-success"></i>':'<i class=" fa fa-remove text-red"></i>';
        $arrData[$i]['esinventario']=$arrData[$i]['esinventario']?'<i class=" fa fa-check text-success"></i>':'<i class=" fa fa-remove text-red"></i>';
        $arrData[$i]['esbanco']=$arrData[$i]['esbanco']?'<i class=" fa fa-check text-success"></i>':'<i class=" fa fa-remove text-red"></i>';
        $arrData[$i]['esconfig']=$arrData[$i]['esconfig']?'<i class=" fa fa-check text-success"></i>':'<i class=" fa fa-remove text-red"></i>';
        $arrData[$i]['eliminar']='<input type="checkbox" name="eliminar_reg[]" value="'.$arrData[$i]['idoperacion'].'">';
      }
      echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
      die();
    } else{
      header("Location:".base_URL()."Error403");
    }
  }

  public function Selectpicker(){
    if (isset($_POST["security"])) {
      $arrData=$this->model->ListDt(POSTT($_POST['op']));
      if($arrData){
        for ($i=0; $i<count($arrData);$i++) { 
          echo '<option value="'.$arrData[$i]['idoperacion'].'">'.$arrData[$i]['cod_operacion'].'-'.$arrData[$i]['desc_operacion'].'</option>';
        }
      } else {
        echo '<option readonly>No Existen Registros!</option>';
      }
    } else {
      header("Location:".base_URL()."Error403");
    }
  }
  
}