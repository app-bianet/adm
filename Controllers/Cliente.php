<?php
class Cliente extends \Controllers{



  public function __construct(){
    session_start();
    ob_start();
    if (!isset($_SESSION['sidusuario'])){
      header("Location:".base_URL()."login");
      session_unset();
      session_destroy();
    } else{
      if($_SESSION['cliente']!=1)  {
        header("Location:".base_URL()."error403");
      } 
    }
    ob_end_flush();     
    parent::__construct();
  }

  public function cliente(){
    $data['page_tag']="Cliente";
    $data['page_title']=".:: Cliente ::.";
    $data['page_name']="cliente";
    $data['func']="functions_cliente.js";
    $this->views->getView($this,"cliente",$data);
  }

  public function Insertar(){
    if(isset($_POST["security"])){
      $idcliente=isset($_POST["idcliente"])? limpiarCadena($_POST["idcliente"]):"";
      $idvendedor=isset($_POST["idvendedor"])?limpiarCadena($_POST["idvendedor"]):"";
      $idtipocliente=isset($_POST["idtipocliente"])? limpiarCadena($_POST["idtipocliente"]):"";
      $idcondpago=isset($_POST["idcondpago"])? limpiarCadena($_POST["idcondpago"]):"";
      $idzona=isset($_POST["idzona"])? limpiarCadena($_POST["idzona"]):"";
      $idoperacion=isset($_POST["idoperacion"])? limpiarCadena($_POST["idoperacion"]):"";
      $idimpuestoz=isset($_POST["idimpuestoz"])? limpiarCadena($_POST["idimpuestoz"]):"";
      $cod_cliente=isset($_POST["cod_cliente"])? limpiarCadena($_POST["cod_cliente"]):"";
      $desc_cliente=isset($_POST["desc_cliente"])? limpiarCadena($_POST["desc_cliente"]):"";
      $rif=isset($_POST["rif"])? limpiarCadena($_POST["rif"]):"";
      $direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
      $ciudad=isset($_POST["ciudad"])? limpiarCadena($_POST["ciudad"]):"";
      $codpostal=isset($_POST["codpostal"])? limpiarCadena($_POST["codpostal"]):"";
      $contacto=isset($_POST["contacto"])? limpiarCadena($_POST["contacto"]):"";
      $telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
      $movil=isset($_POST["movil"])? limpiarCadena($_POST["movil"]):"";
      $email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
      $web=isset($_POST["web"])? limpiarCadena($_POST["web"]):"";
      $limite=isset($_POST["limite"])? limpiarCadena($_POST["limite"]):"";
      $montofiscal=isset($_POST["montofiscal"])? limpiarCadena($_POST["montofiscal"]):"";
      $fechareg=isset($_POST["fechareg"])? limpiarCadena($_POST["fechareg"]):"";
      $aplicareten=isset($_POST["aplicareten"])? limpiarCadena($_POST["aplicareten"]):"";

      if (empty($idcliente)) {
        $request=$this->model->InsertDt($idvendedor,$idtipocliente,$idoperacion,$idcondpago,$idzona,$idimpuestoz,
        $cod_cliente,$desc_cliente,$rif,$direccion,$ciudad,$codpostal,$contacto,$telefono,$movil,$email,
        $web,insertNumber($limite),insertNumber($montofiscal),formatDate($fechareg),$aplicareten);
        $option=1;
      } else {
       $request=$this->model->EditarDt($idcliente,$idvendedor,$idtipocliente,$idoperacion,$idcondpago,$idzona,$idimpuestoz,
       $cod_cliente,$desc_cliente,$rif,$direccion,$ciudad,$codpostal,$contacto,$telefono,$movil,$email,$web,
       insertNumber($limite),insertNumber($montofiscal),formatDate($fechareg),$aplicareten);
        $option=2;
      }

      if($request==1){
        if ($option==1) {
          $arrRspta=array("status"=>true,"msg"=>"Registro Ingresado Correctamente!");
        } else {
          $arrRspta=array("status"=>true,"msg"=>"Registro Actualizado Correctamente!");
        }
      } else if ($request=="1062"){
        $arrRspta=array("status"=>false,"msg"=>"El Código <b>".$cod_cliente."</b> ya se encuentra Registrado! 
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
        $idcliente = $_POST['eliminar_reg'];
        foreach ($idcliente as $valor) {
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
    if (isset($_POST['idcliente'])) {
      $idcliente=intval(limpiarCadena($_POST['idcliente']));
      if ($idcliente>0) {
        $arrData=$this->model->ShowDt($idcliente);
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
    if (isset($_POST['idcliente'])) {
      $idcliente=intval(limpiarCadena($_POST['idcliente']));
      $estatus=intval(1);
      $request=$this->model->EstatusDt($idcliente,$estatus);
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
    if (isset($_POST['idcliente'])) {
      $idcliente=intval(limpiarCadena($_POST['idcliente']));
      $estatus=intval(0);
      $request=$this->model->EstatusDt($idcliente,$estatus);
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
          <button type="button" class="btn btn-primary btn-xs" onclick="mostrar('.$arrData[$i]['idcliente'].')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil"></i></button>
          <button type="button" class="btn btn-success btn-xs" onclick="desactivar('.$arrData[$i]['idcliente'].')" data-toggle="tooltip" data-placement="right" title="Desactivar"><i class="fa fa-check"></i></button>
          </small>';
        } else {
          $arrData[$i]['estatus']='<small class="badge badge-danger">Inactivo</small>';
          $arrData[$i]['opciones']=
          '<small '.$al.'center'.$w.'100px;" class="small btn-group">
          <button type="button" class="btn btn-primary btn-xs" onclick="mostrar('.$arrData[$i]['idcliente'].')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil"></i></button>
          <button type="button" class="btn btn-warning btn-xs" onclick="activar('.$arrData[$i]['idcliente'].')" data-toggle="tooltip" data-placement="right" title="Activar"><i class="fa fa-exclamation-triangle"></i></button>
          </small>';   
        }
        $arrData[$i]['cod_cliente']='<h6 '.$al.'center'.$w.'150px">'.$arrData[$i]['cod_cliente'].'</h6>';
        $arrData[$i]['desc_cliente']='<h6 '.$al.''.$w.'450px">'.cortar_cadena($arrData[$i]['desc_cliente']).'</h6>';
        $arrData[$i]['rif']='<h6 '.$al.''.$w.'130px;">'.$arrData[$i]['rif'].'</h6>';
				$arrData[$i]['tipo']='<h6 '.$al.''.$w.'250px;">'.$arrData[$i]['cod_tipocliente'].'-'.$arrData[$i]['desc_tipocliente'].'</h6>';
        $arrData[$i]['operacion']='<h6 '.$al.''.$w.'250px;">'.$arrData[$i]['cod_operacion'].'-'.$arrData[$i]['desc_operacion'].'</h6>';
        $arrData[$i]['contacto']='<h6 '.$al.''.$w.'250px;">'.$arrData[$i]['contacto'].'</h6>';
				$arrData[$i]['telefono']='<h6 '.$al.''.$w.'160px;">'.$arrData[$i]['telefono'].'</h6>';
				$arrData[$i]['movil']='<h6 '.$al.''.$w.'160px;">'.$arrData[$i]['movil'].'</h6>';
				$arrData[$i]['email']='<h6 '.$al.''.$w.'250px;">'.$arrData[$i]['email'].'</h6>';
				$arrData[$i]['limite']='<h6 '.$al.'right'.$w.'130px;">'.formatMoneyP($arrData[$i]['limite'],2).'</h6>'; 
				$arrData[$i]['saldo']='<h6 '.$al.'right'.$w.'150px;">'.formatMoneyP($arrData[$i]['saldo'],2).'</h6>';   
        $arrData[$i]['eliminar']='<input type="checkbox" name="eliminar_reg[]" value="'.$arrData[$i]['idcliente'].'">';
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
          echo '<option value="'.$arrData[$i]['idcliente'].'">'.$arrData[$i]['cod_cliente'].'-'.$arrData[$i]['desc_cliente'].'</option>';
        }
      } else {
        echo '<option readonly>No Existen Registros!</option>';
      }
    } else {
      header("Location:".base_URL()."Error403");
    }
  }
  
}