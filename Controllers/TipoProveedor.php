<?php
class TipoProveedor extends Controllers{

  public function __construct(){
    session_start();
    ob_start();
    if (!isset($_SESSION['sidusuario'])){
      header("Location:".base_URL()."login");
      session_unset();
      session_destroy();
    } else{
      if($_SESSION['tipoproveedor']!=1)  {
        header("Location:".base_URL()."error403");
      } 
    }
    ob_end_flush();     
    parent::__construct();
  }

  public function tipoproveedor(){
    $data['page_tag']="Tipo de Proveedor";
    $data['page_title']=".:: Tipo de Proveedor ::.";
    $data['page_name']="tipoproveedor";
    $data['func']="functions_tipoproveedor.js";
    $this->views->getView($this,"tipoproveedor",$data);
  }

  public function Insertar(){
    if(isset($_POST["security"])){
      $idtipoproveedor=isset($_POST["idtipoproveedor"])? limpiarCadena($_POST["idtipoproveedor"]):"";
      $cod_tipoproveedor=isset($_POST["cod_tipoproveedor"])? limpiarCadena($_POST["cod_tipoproveedor"]):"";
      $desc_tipoproveedor=isset($_POST["desc_tipoproveedor"])? limpiarCadena($_POST["desc_tipoproveedor"]):"";

      if (empty($idtipoproveedor)) {
        $resquest=$this->model->InsertDt($cod_tipoproveedor,$desc_tipoproveedor);
        $option=1;
      } else {
       $resquest=$this->model->EditarDt($idtipoproveedor,$cod_tipoproveedor,$desc_tipoproveedor,$desc_tipoproveedor);
        $option=2;
      }

      if($resquest==1){
        if ($option==1) {
          $arrRspta=array("status"=>true,"msg"=>"Registro Ingresado Correctamente!");
        } else {
          $arrRspta=array("status"=>true,"msg"=>"Registro Actualizado Correctamente!");
        }
      } else if ($resquest=="duplicado"){
        $arrRspta=array("status"=>false,"msg"=>"El Código <b>".$cod_tipoproveedor."</b> ya se encuentra Registrado! 
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
        $idtipoproveedor = $_POST['eliminar_reg'];
        foreach ($idtipoproveedor as $valor) {
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
    if (isset($_POST['idtipoproveedor'])) {
      $idtipoproveedor=intval(limpiarCadena($_POST['idtipoproveedor']));
      if ($idtipoproveedor>0) {
        $arrData=$this->model->ShowDt($idtipoproveedor);
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
    if (isset($_POST['idtipoproveedor'])) {
      $idtipoproveedor=intval(limpiarCadena($_POST['idtipoproveedor']));
      $estatus=intval(1);
      $resquest=$this->model->EstatusDt($idtipoproveedor,$estatus);
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
    if (isset($_POST['idtipoproveedor'])) {
      $idtipoproveedor=intval(limpiarCadena($_POST['idtipoproveedor']));
      $estatus=intval(0);
      $resquest=$this->model->EstatusDt($idtipoproveedor,$estatus);
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
          <button type="button" class="btn btn-primary btn-xs" onclick="mostrar('.$arrData[$i]['idtipoproveedor'].')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil"></i></button>
          <button type="button" class="btn btn-success btn-xs" onclick="desactivar('.$arrData[$i]['idtipoproveedor'].')" data-toggle="tooltip" data-placement="right" title="Desactivar"><i class="fa fa-check"></i></button>
          </small>';
        } else {
          $arrData[$i]['estatus']='<small class="badge badge-danger">Inactivo</small>';
          $arrData[$i]['opciones']=
          '<h6 '.$al.'center'.$w.'100px;" class="small btn-group">
          <button type="button" class="btn btn-primary btn-xs" onclick="mostrar('.$arrData[$i]['idtipoproveedor'].')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil"></i></button>
          <button type="button" class="btn btn-warning btn-xs" onclick="activar('.$arrData[$i]['idtipoproveedor'].')" data-toggle="tooltip" data-placement="right" title="Activar"><i class="fa fa-exclamation-triangle"></i></button>
          </small>';   
        }
        $arrData[$i]['cod_tipoproveedor']='<h6 '.$al.'center'.$w.'150px">'.$arrData[$i]['cod_tipoproveedor'].'</h6>';
        $arrData[$i]['desc_tipoproveedor']='<h6 '.$al.''.$w.'">'.$arrData[$i]['desc_tipoproveedor'].'</h6>';
        $arrData[$i]['eliminar']='<input type="checkbox" name="eliminar_reg[]" value="'.$arrData[$i]['idtipoproveedor'].'">';
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
        echo '<option value="'.$arrData[$i]['idtipoproveedor'].'">'.$arrData[$i]['cod_tipoproveedor'].'-'.$arrData[$i]['desc_tipoproveedor'].'</option>';
      }
    } else {
      header("Location:".base_URL()."Error403");
    }
  }
  
}