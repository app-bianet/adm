<?php
class Linea extends Controllers{

  public function __construct(){
    session_start();
    ob_start();
    if (!isset($_SESSION['sidusuario'])){
      header("Location:".base_URL()."login");
      session_unset();
      session_destroy();
    } else{
      if($_SESSION['linea']!=1)  {
        header("Location:".base_URL()."error403");
      } 
    }
    ob_end_flush();     
    parent::__construct();
  }

  public function linea(){
    $data['page_tag']="Linea";
    $data['page_title']=".:: Linea ::.";
    $data['page_name']="linea";
    $data['func']="functions_linea.js";
    $this->views->getView($this,"linea",$data);
  }

  public function Insertar(){
    if(isset($_POST["security"])){
      $idlinea=isset($_POST["idlinea"])? limpiarCadena($_POST["idlinea"]):"";
      $idcategoria=isset($_POST["idcategoria"])? limpiarCadena($_POST["idcategoria"]):"";
      $cod_linea=isset($_POST["cod_linea"])? limpiarCadena($_POST["cod_linea"]):"";
      $desc_linea=isset($_POST["desc_linea"])? limpiarCadena($_POST["desc_linea"]):"";

      if ($idlinea==0) {
        $request=$this->model->InsertDt($idcategoria,$cod_linea,$desc_linea);
        $option=1;
      } else {
        $request=$this->model->EditarDt($idlinea,$idcategoria,$cod_linea,$desc_linea);
        $option=2;
      }

      if($request==1){
        if ($option==1) {
          $arrRspta=array("status"=>true,"msg"=>"Registro Ingresado Correctamente!");
        } else {
          $arrRspta=array("status"=>true,"msg"=>"Registro Actualizado Correctamente!");
        }
      } else if ($request=="1062"){
        $arrRspta=array("status"=>false,"msg"=>"El Código <b>".$cod_linea."</b> ya se encuentra Registrado! 
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
        $idlinea = $_POST['eliminar_reg'];
        foreach ($idlinea as $valor) {
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
    if (isset($_POST['idlinea'])) {
      $idlinea=limpiarCadena($_POST['idlinea']);
      if ($idlinea>0) {
        $arrData=$this->model->ShowDt($idlinea);
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
    if (isset($_POST['idlinea'])) {
      $idlinea=intval(limpiarCadena($_POST['idlinea']));
      $estatus=intval(1);
      $request=$this->model->EstatusDt($idlinea,$estatus);
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
    if (isset($_POST['idlinea'])) {
      $idlinea=intval(limpiarCadena($_POST['idlinea']));
      $estatus=intval(0);
      $request=$this->model->EstatusDt($idlinea,$estatus);
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
        <button type="button" class="btn btn-primary btn-xs" onclick="mostrar('.$arrData[$i]['idlinea'].')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil"></i></button>'.
        '<button type="button" class="btn btn-success btn-xs" onclick="desactivar('.$arrData[$i]['idlinea'].')" data-toggle="tooltip" data-placement="right" title="Desactivar"><i class="fa fa-check"></i></button>
        </small>';
        } else {
          $arrData[$i]['estatus']='<small class="badge badge-danger">Inactivo</small>';
          $arrData[$i]['opciones']=
          '<small '.$al.'center'.$w.'100px;" class="small btn-group">
          <button type="button" class="btn btn-primary btn-xs" onclick="mostrar('.$arrData[$i]['idlinea'].')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil"></i></button>'.
          '<button type="button" class="btn btn-warning btn-xs" onclick="activar('.$arrData[$i]['idlinea'].')" data-toggle="tooltip" data-placement="right" title="Activar"><i class="fa fa-exclamation-triangle"></i></button>
          </small>';   
        }
        $arrData[$i]['cod_linea']='<h6 '.$al.'center'.$w.'150px">'.$arrData[$i]['cod_linea'].'</h6>';
        $arrData[$i]['desc_linea']='<h6 '.$al.''.$w.'300px">'.$arrData[$i]['desc_linea'].'</h6>';
        $arrData[$i]['categoria']='<h6 '.$al.''.$w.'220px">'.$arrData[$i]['cod_categoria'].'-'.$arrData[$i]['desc_categoria'].'</h6>';
        $arrData[$i]['eliminar']='<input type="checkbox" name="eliminar_reg[]" value="'.$arrData[$i]['idlinea'].'">';
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
        echo '<option value="'.$arrData[$i]['idlinea'].'">'.$arrData[$i]['cod_linea'].'-'.$arrData[$i]['desc_linea'].'</option>';
      }
    } else {
      header("Location:".base_URL()."Error403");
    }
  }

  public function SelectpickerC(){
    if (isset($_POST["security"])) {
      $idcategoria=intval(limpiarCadena($_POST['idcategoria']));
      $arrData=$this->model->ShowDtc($idcategoria);
      if ($arrData) {
        for ($i=0; $i<count($arrData);$i++) { 
          echo '<option value="'.$arrData[$i]['idlinea'].'">'.$arrData[$i]['cod_linea'].'-'.$arrData[$i]['desc_linea'].'</option>';
        }
      } else {
        echo '<option readonly>No Existen Registros!</option>';
      }
    } else {
      header("Location:".base_URL()."Error403");
    }
  }
  
}