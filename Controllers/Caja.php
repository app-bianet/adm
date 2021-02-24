<?php
class Caja extends Controllers{

  public function __construct(){   
    parent::__construct();
  }

  public function caja(){
    ob_start();
    session_start();
    if (!isset($_SESSION["sidusuario"])){
      header("Location:".base_URL()."login");
    } else {
      if ($_SESSION['caja']==1){     
        $data['page_tag']="Cajas";
        $data['page_title']=".:: Cajas ::.";
        $data['page_name']="caja";
        $data['func']="functions_caja.js";
        $this->views->getView($this,"caja",$data);
      } else {
        header("Location:".base_URL()."error403");
      }
    }
    ob_end_flush();
  }

  public function Insertar(){
    if(isset($_POST["security"])){
      $idcaja=isset($_POST["idcaja"])? limpiarCadena($_POST["idcaja"]):"";
      $idmoneda=isset($_POST["idmoneda"])? limpiarCadena($_POST["idmoneda"]):"";
      $cod_caja=isset($_POST["cod_caja"])? limpiarCadena($_POST["cod_caja"]):"";
      $desc_caja=isset($_POST["desc_caja"])? limpiarCadena($_POST["desc_caja"]):"";
      $fechareg=isset($_POST["fechareg"])? limpiarCadena($_POST["fechareg"]):"";

      if (empty($idcaja)) {
        $request=$this->model->InsertDt($idmoneda,$cod_caja,$desc_caja,formatDate($fechareg));
        $option=1;
      } else {
        $request=$this->model->EditarDt($idcaja,$idmoneda,$cod_caja,$desc_caja,formatDate($fechareg));
        $option=2;
      }

      if($request>0){
        if ($option==1) {
          $arrRspta=array("status"=>true,"msg"=>"Registro Ingresado Correctamente!");
        } else {
          $arrRspta=array("status"=>true,"msg"=>"Registro Actualizado Correctamente!");
        }
      } else if ($request=="duplicado"){
        $arrRspta=array("status"=>false,"msg"=>"El Código <b>".$cod_caja."</b> ya se encuentra Registrado! 
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
        $idcaja = $_POST['eliminar_reg'];
        foreach ($idcaja as $valor) {
          $request = $this->model->EliminarDt($valor);
        }
        if ($request == 1) {
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
    if (isset($_POST['idcaja'])) {
      $idcaja=intval(limpiarCadena($_POST['idcaja']));
      if ($idcaja>0) {
        $arrData=$this->model->ShowDt($idcaja);
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
    if (isset($_POST['idcaja'])) {
      $idcaja=intval(limpiarCadena($_POST['idcaja']));
      $estatus=intval(1);
      $request=$this->model->EstatusDt($idcaja,$estatus);
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
    if (isset($_POST['idcaja'])) {
      $idcaja=intval(limpiarCadena($_POST['idcaja']));
      $estatus=intval(0);
      $request=$this->model->EstatusDt($idcaja,$estatus);
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
          <button type="button" class="btn btn-primary btn-xs" onclick="mostrar('.$arrData[$i]['idcaja'].')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil"></i></button>
          <button type="button" class="btn btn-success btn-xs" onclick="desactivar('.$arrData[$i]['idcaja'].')" data-toggle="tooltip" data-placement="right" title="Desactivar"><i class="fa fa-check"></i></button>
          </small>';
        } else {
          $arrData[$i]['estatus']='<small class="badge badge-danger">Inactivo</small>';
          $arrData[$i]['opciones']=
          '<h6 '.$al.'center'.$w.'100px;" class="small btn-group">
          <button type="button" class="btn btn-primary btn-xs" onclick="mostrar('.$arrData[$i]['idcaja'].')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil"></i></button>
          <button type="button" class="btn btn-warning btn-xs" onclick="activar('.$arrData[$i]['idcaja'].')" data-toggle="tooltip" data-placement="right" title="Activar"><i class="fa fa-exclamation-triangle"></i></button>
          </small>';   
        }
        $arrData[$i]['cod_caja']='<h6>'.$arrData[$i]['cod_caja'].'</h6>';
        $arrData[$i]['desc_caja']='<h6>'.$arrData[$i]['desc_caja'].'</h6>';
        $arrData[$i]['moneda']='<h6>'.$arrData[$i]['simbolo'].'</h6>';
        $arrData[$i]['saldototal']='<h6>'.formatMoneyP($arrData[$i]['saldototal'],2).'</h6>';
        $arrData[$i]['eliminar']='<input type="checkbox" name="eliminar_reg[]" value="'.$arrData[$i]['idcaja'].'">';
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
      if ($arrData) {
        for ($i=0; $i<count($arrData);$i++) { 
          echo '<option value="'.$arrData[$i]['idcaja'].'">'.$arrData[$i]['cod_caja'].'-'.$arrData[$i]['desc_caja'].'</option>';
        }
      } else {
        echo '<option readonly>No Existen Registros!</option>';
      }
    } else {
      header("Location:".base_URL()."Error403");
    }
  }
}