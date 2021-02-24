<?php
class Cuenta extends Controllers{

  public function __construct(){   
    parent::__construct();
  }

  public function cuenta(){
    ob_start();
    session_start();
    if (!isset($_SESSION["sidusuario"])){
      header("Location:".base_URL()."login");
    } else {
      if ($_SESSION['cuenta']==1){     
        $data['page_tag']="Cuentas";
        $data['page_title']=".:: Cuentas ::.";
        $data['page_name']="cuenta";
        $data['func']="functions_cuenta.js";
        $this->views->getView($this,"cuenta",$data);
      } else {
        header("Location:".base_URL()."error403");
      }
    }
    ob_end_flush();
  }

  public function Insertar(){
    if(isset($_POST["security"])){
      $idcuenta=isset($_POST["idcuenta"])? limpiarCadena($_POST["idcuenta"]):"";
      $idbanco=isset($_POST["idbanco"])? limpiarCadena($_POST["idbanco"]):"";
      $cod_cuenta=isset($_POST["cod_cuenta"])? limpiarCadena($_POST["cod_cuenta"]):"";
      $desc_cuenta=isset($_POST["desc_cuenta"])? limpiarCadena($_POST["desc_cuenta"]):"";
      $tipo=isset($_POST["tipo"])? limpiarCadena($_POST["tipo"]):"";
      $numcuenta=isset($_POST["numcuenta"])? limpiarCadena($_POST["numcuenta"]):"";
      $agencia=isset($_POST["agencia"])? limpiarCadena($_POST["agencia"]):"";
      $ejecutivo=isset($_POST["ejecutivo"])? limpiarCadena($_POST["ejecutivo"]):"";
      $direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
      $telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
      $email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
      $mostrar=isset($_POST["mostrar"])? limpiarCadena($_POST["mostrar"]):"";
      $fechareg=isset($_POST["fechareg"])? limpiarCadena($_POST["fechareg"]):"";


      if (empty($idcuenta)) {
        $request=$this->model->InsertDt($idbanco,$cod_cuenta,$desc_cuenta,$tipo,$numcuenta,$agencia,$ejecutivo,$direccion,
        $telefono,$email,$mostrar,$fechareg);
        $option=1;
      } else {
        $request=$this->model->EditarDt($idcuenta,$idbanco,$cod_cuenta,$desc_cuenta,$tipo,$numcuenta,$agencia,$ejecutivo,$direccion,
        $telefono,$email,$mostrar,$fechareg);
        $option=2;
      }

      if($request>0){
        if ($option==1) {
          $arrRspta=array("status"=>true,"msg"=>"Registro Ingresado Correctamente!");
        } else {
          $arrRspta=array("status"=>true,"msg"=>"Registro Actualizado Correctamente!");
        }
      } else if ($request=="duplicado"){
        $arrRspta=array("status"=>false,"msg"=>"El Código <b>".$cod_cuenta."</b> ya se encuentra Registrado! 
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
        $idcuenta = $_POST['eliminar_reg'];
        foreach ($idcuenta as $valor) {
          $request = $this->model->EliminarDt($valor);
        }
        if ($request > 0) {
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
    if (isset($_POST['idcuenta'])) {
      $idcuenta=intval(limpiarCadena($_POST['idcuenta']));
      if ($idcuenta>0) {
        $arrData=$this->model->ShowDt($idcuenta);
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
    if (isset($_POST['idcuenta'])) {
      $idcuenta=intval(limpiarCadena($_POST['idcuenta']));
      $estatus=intval(1);
      $request=$this->model->EstatusDt($idcuenta,$estatus);
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
    if (isset($_POST['idcuenta'])) {
      $idcuenta=intval(limpiarCadena($_POST['idcuenta']));
      $estatus=intval(0);
      $request=$this->model->EstatusDt($idcuenta,$estatus);
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
          <button type="button" class="btn btn-primary btn-xs" onclick="mostrar('.$arrData[$i]['idcuenta'].')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil"></i></button>
          <button type="button" class="btn btn-success btn-xs" onclick="desactivar('.$arrData[$i]['idcuenta'].')" data-toggle="tooltip" data-placement="right" title="Desactivar"><i class="fa fa-check"></i></button>
          </small>';
        } else {
          $arrData[$i]['estatus']='<small class="badge badge-danger">Inactivo</small>';
          $arrData[$i]['opciones']=
          '<h6 '.$al.'center'.$w.'100px;" class="small btn-group">
          <button type="button" class="btn btn-primary btn-xs" onclick="mostrar('.$arrData[$i]['idcuenta'].')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil"></i></button>
          <button type="button" class="btn btn-warning btn-xs" onclick="activar('.$arrData[$i]['idcuenta'].')" data-toggle="tooltip" data-placement="right" title="Activar"><i class="fa fa-exclamation-triangle"></i></button>
          </small>';   
        }
        $arrData[$i]['cod_cuenta']='<h6>'.$arrData[$i]['cod_cuenta'].'</h6>';
        $arrData[$i]['desc_cuenta']='<h6>'.$arrData[$i]['desc_cuenta'].'</h6>';
        $arrData[$i]['cod_banco']='<h6>'.$arrData[$i]['cod_banco'].'</h6>';
				$arrData[$i]['numcuenta']='<h6>'.$arrData[$i]['numcuenta'].'</h6>';
				$arrData[$i]['saldot']='<h6>'.formatMoneyP($arrData[$i]['saldot'],2).'</h6>';
        $arrData[$i]['eliminar']='<input type="checkbox" name="eliminar_reg[]" value="'.$arrData[$i]['idcuenta'].'">';
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
          echo '<option value="'.$arrData[$i]['idcuenta'].'">'.$arrData[$i]['cod_cuenta'].'-'.$arrData[$i]['desc_cuenta'].'</option>';
        }
      } else {
        echo '<option readonly>No Existen Registros!</option>';
      }
    } else {
      header("Location:".base_URL()."Error403");
    }
  }
  
}