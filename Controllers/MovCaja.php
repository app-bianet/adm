<?php
class MovCaja extends Controllers{

  public function __construct(){   
    parent::__construct();
  }

  public function movcaja(){
    ob_start();
    session_start();
    if (!isset($_SESSION["sidusuario"])){
      header("Location:".base_URL()."login");
    } else {
      if ($_SESSION['movcaja']==1){     
        $data['page_tag']="MovCajas";
        $data['page_title']=".:: MovCajas ::.";
        $data['page_name']="movcaja";
        $data['func']="functions_movcaja.js";
        $this->views->getView($this,"movcaja",$data);
      } else {
        header("Location:".base_URL()."error403");
      }
    }
    ob_end_flush();
  }

  
    // [idmovcaja] => 
    // [idcaja] => 2
    // [idbanco] => 4
    // [idoperacion] => 1
    // [idusuario] => 1
    //[desc_movcaja] => des
    //[saldoinicial] => 1
    // [forma] => Cheque
    // [tipo] => Ingreso
    // [origen] => Caja
    // [estatus] => Sin Procesar
    // [numeroc] => 343432423
    // [numerod] => 23123123
    // [montod] => 250000
    // [montoh] => 0
    // [fechareg] => 20/02/2021

  public function Insertar(){
    if(isset($_POST["security"])){
      $idmovcaja = isset($_POST["idmovcaja"])? limpiarCadena($_POST["idmovcaja"]):"";
      $idcaja = isset($_POST["idcaja"])? limpiarCadena($_POST["idcaja"]):"";
      $idbanco = isset($_POST["idbanco"])? limpiarCadena($_POST["idbanco"]):"";
      $idoperacion = isset($_POST["idoperacion"])? limpiarCadena($_POST["idoperacion"]):"";
      $idusuario = isset($_POST["idusuario"])? limpiarCadena($_POST["idusuario"]):"";
      $cod_movcaja=isset($_POST["cod_movcaja"])? limpiarCadena($_POST["cod_movcaja"]):"";
      $tipo = isset($_POST["tipo"])? limpiarCadena($_POST["tipo"]):"";
      $forma = isset($_POST["forma"])? limpiarCadena($_POST["forma"]):"";
      $numerod = isset($_POST["numerod"])? limpiarCadena($_POST["numerod"]):"";
      $numeroc = isset($_POST["numeroc"])? limpiarCadena($_POST["numeroc"]):"";
      $origen = isset($_POST["origen"])? limpiarCadena($_POST["origen"]):"";
      $estatus = isset($_POST["estatus"])? limpiarCadena($_POST["estatus"]):"";
      $montod = isset($_POST["montod"])? limpiarCadena($_POST["montod"]):"";
      $montoh = isset($_POST["montoh"])? limpiarCadena($_POST["montoh"]):"";
      $saldoinicial = isset($_POST["saldoinicial"])? limpiarCadena($_POST["saldoinicial"]):"";
      $fechareg = isset($_POST["fechareg"])? limpiarCadena($_POST["fechareg"]):"";
      $desc_movcaja=isset($_POST["desc_movcaja"])? limpiarCadena($_POST["desc_movcaja"]):"";

      if (empty($idmovcaja)) {
        $request=$this->model->InsertDt($idcaja,$idbanco,$idoperacion,$idusuario,$cod_movcaja,$desc_movcaja,
        $tipo,'Registrado',$forma,$numerod,$numeroc,$origen,$montod,$montoh,$saldoinicial,$fechareg);
        $option=1;
      } else {
        $request=$this->model->EditarDt($idmovcaja,$idcaja,$idbanco,$idoperacion,$idusuario,$cod_movcaja,$desc_movcaja,
        $estatus,$tipo,$forma,$numerod,$numeroc,$origen,$montod,$montoh,$saldoinicial,$fechareg);
        $option=2;
      }

      if($request){
        if ($option==1) {
          $arrRspta=array("status"=>true,"msg"=>"Registro Ingresado Correctamente!");
        } else {
          $arrRspta=array("status"=>true,"msg"=>"Registro Actualizado Correctamente!");
        }
      } else if ($request=="duplicado"){
        $arrRspta=array("status"=>false,"msg"=>"El Código <b>".$cod_movcaja."</b> ya se encuentra Registrado! 
        <br>No es posible ingresar <b>Registros Duplicados!</b>");
      } else {
        $arrRspta=array("status"=>false,"msg"=>$request);
      }
      echo json_encode($arrRspta,JSON_UNESCAPED_UNICODE);    
    } else{
      header("Location:".base_URL()."Error404");
    }
  }



  public function Mostrar(){
    if (isset($_POST['idmovcaja'])) {
      $idmovcaja=intval(limpiarCadena($_POST['idmovcaja']));
      if ($idmovcaja>0) {
        $arrData=$this->model->ShowDt($idmovcaja);
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

  public function Anular(){
    if (isset($_POST['idmovcaja'])) {
      $idmovcaja=limpiarCadena($_POST['idmovcaja']);
      $idcaja=limpiarCadena($_POST['idcaja']);
      $request=$this->model->AnularDt($idmovcaja,$idcaja);
        if($request){
          $arrRspta=array("status"=>true,"msg"=>"Registro Anulado Correctamente!");
        }else {
          $arrRspta=array("status"=>false,"msg"=>"Error al Anular el Registro!");
        }
      echo json_encode($arrRspta,JSON_UNESCAPED_UNICODE);
    } else{
      header("Location:".base_URL()."Error404");
    }
    die();
  }

  public function Eliminar(){
    if (isset($_POST['idmovcaja'])) {
      $idmovcaja=limpiarCadena($_POST['idmovcaja']);
      $idcaja=limpiarCadena($_POST['idcaja']);
      $request=$this->model->EliminarDt($idmovcaja,$idcaja);
        if($request>0){
          $arrRspta=array("status"=>true,"msg"=>"Registro Anulado Correctamente!");
        } else if ($request =='relacion') {
          $arrRspta = array("status" => false, "msg" => "No es Posible Eliminar Registros Relacionados!");
        }else {
          $arrRspta=array("status"=>false,"msg"=>"Error al Anular el Registro!");
        }
      echo json_encode($arrRspta,JSON_UNESCAPED_UNICODE);
    } else{
      header("Location:".base_URL()."Error404");
    }
    die();
  }


  public function Listar(){
 //  if (isset($_POST["security"])) {
      $arrData=$this->model->SelectDt();
      $al='style="text-align:';
      $w='; width:';
      $dtg='data-toggle="tooltip" data-placement="right" title="';
      $estatus="";
      for ($i=0; $i<count($arrData);$i++) {

      if($arrData[$i]['estatus']=='Registrado'&& $arrData[$i]['origen']=='Caja'){
        $arrData[$i]['opciones']='<small '.$al.'center'.$w.'160px;" class="small btn-group">
        <button type="button" class="btn btn-primary btn-xs" onclick="mostrar('.$arrData[$i]['idmovcaja'].')" '.$dtg.'Mostrar"><i class="fa fa-pencil"></i></button>
        <button type="button" class="btn btn-success btn-xs" onclick="anular('.$arrData[$i]['idmovcaja'].',\''.$arrData[$i]['idcaja'].'\')" 
        '.$dtg.'Anular"><i class="fa fa-check"></i></button>
        <button type="button" class="btn btn-danger btn-xs" onclick="eliminar('.$arrData[$i]['idmovcaja'].',\''.$arrData[$i]['idcaja'].'\')" 
        '.$dtg.'Anular"><i class="fa fa-times"></i></button>
        <button type="button" class="btn btn-info btn-xs" '.$dtg.'Imprimir"><i class="fa fa-file"></i></button>
        </small >';
      } else if($arrData[$i]['estatus']=='Registrado'&& $arrData[$i]['origen']!='Caja'){
        $arrData[$i]['opciones']='<small  '.$al.'center'.$w.'160px;" class="small btn-group">
        <button type="button" class="btn btn-primary btn-xs" onclick="mostrar('.$arrData[$i]['idmovcaja'].')" '.$dtg.'Mostrar"><i class="fa fa-pencil"></i></button>
        <button type="button" class="btn btn-success btn-xs" disabled '.$dtg.'Anular"><i class="fa fa-check"></i></button>
        <button type="button" class="btn btn-danger btn-xs" disabled '.$dtg.'Anular"><i class="fa fa-times"></i></button>
        <button type="button" class="btn btn-info btn-xs" '.$dtg.'Imprimir"><i class="fa fa-file"></i></button>
        </small >';
      } else if($arrData[$i]['estatus']=='Procesado'){
        $arrData[$i]['opciones']='<small  '.$al.'center'.$w.'160px;" class="small btn-group">
        <button type="button" class="btn btn-primary btn-xs" onclick="mostrar('.$arrData[$i]['idmovcaja'].')" '.$dtg.'Mostrar"><i class="fa fa-pencil"></i></button>
        <button type="button" class="btn btn-warning btn-xs" disabled '.$dtg.'Anulado"><i class="fa fa-trash"></i></button>
        <button type="button" class="btn btn-danger btn-xs" disabled '.$dtg.'Anular"><i class="fa fa-times"></i></button>
        <button type="button" class="btn btn-info btn-xs" '.$dtg.'Imprimir"><i class="fa fa-file"></i></button>
        </small >';
      }else{
        $arrData[$i]['opciones']='<small  '.$al.'center'.$w.'160px;" class="small btn-group">
        <button type="button" class="btn btn-primary btn-xs" onclick="mostrar('.$arrData[$i]['idmovcaja'].')" '.$dtg.'Mostrar"><i class="fa fa-pencil"></i></button>
        <button type="button" class="btn btn-warning btn-xs" disabled '.$dtg.'Anulado"><i class="fa fa-trash"></i></button>
        <button type="button" class="btn btn-danger btn-xs" disabled '.$dtg.'Anular"><i class="fa fa-times"></i></button>
        <button type="button" class="btn btn-info btn-xs" '.$dtg.'Imprimir"><i class="fa fa-file"></i></button>
        </small >';
      }

        if ($arrData[$i]['estatus']=='Registrado') {
          $estatus='<h6><small class="badge badge-success">Registrado</small></h6>';         
        } else if ($arrData[$i]['estatus']=='Anulado'){
          $estatus='<h6><small class="badge badge-danger">Anulado</small></h6>';         
        }else if ($arrData[$i]['estatus']=='Procesado'){
          $estatus='<h6><small class="badge badge-primary">Procesado</small></h6>';         
        }

        $arrData[$i]['fechareg']='<h6>'.$arrData[$i]['fechareg'].'</h6>';
        $arrData[$i]['cod_movcaja']='<h6>'.$arrData[$i]['cod_movcaja'].'</h6>';
        $arrData[$i]['caja']='<h6>'.$arrData[$i]['cod_caja'].'-'.$arrData[$i]['desc_caja'].'</h6>';
        $arrData[$i]['tipo']='<h6>'.$arrData[$i]['tipo'].'</h6>';
        $arrData[$i]['forma']='<h6>'.$arrData[$i]['forma'].'</h6>';
        $arrData[$i]['numerod']='<h6>'.$arrData[$i]['numerod'].'</h6>';
        $arrData[$i]['monto']=$arrData[$i]['montod']!=0?
        '<h6>'.formatMoneyP($arrData[$i]['montod'],2).'</h6>':
        '<h6>'.formatMoneyP($arrData[$i]['montoh'],2).'</h6>';
        $arrData[$i]['estatus']=$estatus;
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
      if ($arrData) {
        for ($i=0; $i<count($arrData);$i++) { 
          echo '<option value="'.$arrData[$i]['idmovcaja'].'">'.$arrData[$i]['cod_movcaja'].'-'.$arrData[$i]['desc_movcaja'].'</option>';
        }
      } else {
        echo '<option readonly>No Existen Registros!</option>';
      }
    } else {
      header("Location:".base_URL()."Error403");
    }
  }
  
}