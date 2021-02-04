<?php
class Beneficiario extends Controllers{

  public function __construct(){ 
    parent::__construct();
  }

  public function beneficiario(){
    ob_start();
    session_start();
    if (!isset($_SESSION["sidusuario"])){
      header("Location:".base_URL()."login");
    } else {
      if ($_SESSION['beneficiario']==1){     
        $data['page_tag']="Beneficiarioes";
        $data['page_title']=".:: Beneficiarioes ::.";
        $data['page_name']="beneficiario";
        $data['func']="functions_beneficiario.js";
        $this->views->getView($this,"beneficiario",$data);
      } else {
        header("Location:".base_URL()."error403");
      }
    }
    ob_end_flush();
  }

  public function Insertar(){
    if(isset($_POST["security"])){
      $idbeneficiario=isset($_POST["idbeneficiario"])? limpiarCadena($_POST["idbeneficiario"]):"";
      $idimpuestoz=isset($_POST["idimpuestoz"])? limpiarCadena($_POST["idimpuestoz"]):"";
      $cod_beneficiario=isset($_POST["cod_beneficiario"])? limpiarCadena($_POST["cod_beneficiario"]):"";
      $desc_beneficiario=isset($_POST["desc_beneficiario"])? limpiarCadena($_POST["desc_beneficiario"]):"";
      $rif=isset($_POST["rif"])? limpiarCadena($_POST["rif"]):"";
      $direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
      $telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
      $fechareg=isset($_POST["fechareg"])? limpiarCadena($_POST["fechareg"]):"";

      if (empty($idbeneficiario)) {
        $request=$this->model->InsertDt($idimpuestoz,$cod_beneficiario,$desc_beneficiario,
        $rif,$direccion,$telefono,formatDate($fechareg));
        $option=1;
      } else {
        $request=$this->model->EditarDt($idbeneficiario,$idimpuestoz,$cod_beneficiario,$desc_beneficiario,
        $rif,$direccion,$telefono,formatDate($fechareg));
        $option=2;
      }

      if($request){
        if ($option==1) {
          $arrRspta=array("status"=>true,"msg"=>"Registro Ingresado Correctamente!");
        } else {
          $arrRspta=array("status"=>true,"msg"=>"Registro Actualizado Correctamente!");
        }
      } else if ($request=="1062"){
        $arrRspta=array("status"=>false,"msg"=>"El Código <b>".$cod_beneficiario."</b> ya se encuentra Registrado! 
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
        $idbeneficiario = $_POST['eliminar_reg'];
        foreach ($idbeneficiario as $valor) {
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
    if (isset($_POST['idbeneficiario'])) {
      $idbeneficiario=intval(limpiarCadena($_POST['idbeneficiario']));
      if ($idbeneficiario>0) {
        $arrData=$this->model->ShowDt($idbeneficiario);
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
    if (isset($_POST['idbeneficiario'])) {
      $idbeneficiario=intval(limpiarCadena($_POST['idbeneficiario']));
      $estatus=intval(1);
      $request=$this->model->EstatusDt($idbeneficiario,$estatus);
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
    if (isset($_POST['idbeneficiario'])) {
      $idbeneficiario=intval(limpiarCadena($_POST['idbeneficiario']));
      $estatus=intval(0);
      $request=$this->model->EstatusDt($idbeneficiario,$estatus);
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
        <button type="button" class="btn btn-primary btn-xs" onclick="mostrar('.$arrData[$i]['idbeneficiario'].')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil"></i></button>'.
        '<button type="button" class="btn btn-success btn-xs" onclick="desactivar('.$arrData[$i]['idbeneficiario'].')" data-toggle="tooltip" data-placement="right" title="Desactivar"><i class="fa fa-check"></i></button>
        </small>';
        } else {
          $arrData[$i]['estatus']='<small class="badge badge-danger">Inactivo</small>';
          $arrData[$i]['opciones']=
          '<small '.$al.'center'.$w.'100px;" class="small btn-group">
          <button type="button" class="btn btn-primary btn-xs" onclick="mostrar('.$arrData[$i]['idbeneficiario'].')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil"></i></button>'.
          '<button type="button" class="btn btn-warning btn-xs" onclick="activar('.$arrData[$i]['idbeneficiario'].')" data-toggle="tooltip" data-placement="right" title="Activar"><i class="fa fa-exclamation-triangle"></i></button>
          </small>';   
        }
        $arrData[$i]['cod_beneficiario']='<h6>'.$arrData[$i]['cod_beneficiario'].'</h6>';
        $arrData[$i]['desc_beneficiario']='<h6>'.$arrData[$i]['desc_beneficiario'].'</h6>';
        $arrData[$i]['rif']='<h6>'.$arrData[$i]['rif'].'</h6>';
        $arrData[$i]['saldo']='<h6>'.formatMoneyP('0.00',2).'</h6>';
        $arrData[$i]['eliminar']='<input type="checkbox" name="eliminar_reg[]" value="'.$arrData[$i]['idbeneficiario'].'">';
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
          echo '<option value="'.$arrData[$i]['idbeneficiario'].'">'.$arrData[$i]['cod_beneficiario'].'-'.$arrData[$i]['desc_beneficiario'].'</option>';
        }
      } else {
        echo '<option readonly>No Existen Registros!</option>';
      }
    } else {
      header("Location:".base_URL()."Error403");
    }
  }
  
}