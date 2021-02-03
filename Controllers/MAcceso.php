<?php
class MAcceso extends Controllers{

  public function __construct(){
    session_start();
    ob_start();
    if (!isset($_SESSION['sidusuario'])){
      header("Location:".base_URL()."login");
      session_unset();
      session_destroy();
    } else{
      if($_SESSION['macceso']!=1)  {
        header("Location:".base_URL()."error403");
      } 
    }
    ob_end_flush();     
    parent::__construct();
  }

  public function macceso(){
    $data['item']=$_SESSION["macceso"];
    $data['page_tag']="Perfil de Acceso";
    $data['page_title']=".:: Perfil de Acceso ::.";
    $data['page_name']="macceso";
    $data['func']="functions_macceso.js";
    $this->views->getView($this,"macceso",$data);
  }

  public function Insertar(){
    if (isset($_POST['security'])) {
      $idmacceso=isset($_POST["idmacceso"])? limpiarCadena($_POST["idmacceso"]):"";
      $cod_macceso=isset($_POST["cod_macceso"])? limpiarCadena($_POST["cod_macceso"]):"";
      $desc_macceso=isset($_POST["desc_macceso"])? limpiarCadena($_POST["desc_macceso"]):"";
      $departamento=isset($_POST["departamento"])? limpiarCadena($_POST["departamento"]):"";
        if ($idmacceso==0) {
          $request=$this->model->InsertDt($cod_macceso,$desc_macceso,$departamento,$_POST["accesos"]);
          $option=1;
        } else {
          $request=$this->model->EditarDt($idmacceso,$cod_macceso,$desc_macceso,$departamento,$_POST["accesos"]);
          $option=2;
        }
  
        if($request==1){
          if ($option==1) {
            $arrRspta=array("status"=>true,"msg"=>"Registro Ingresado Correctamente!");
          } else {
            $arrRspta=array("status"=>true,"msg"=>"Registro Actualizado Correctamente!");
          }
        } else if ($request=="1062"){
          $arrRspta=array("status"=>false,"msg"=>"El Código <b>".$cod_macceso."</b> ya se encuentra Registrado! 
          <br>No es posible ingresar <b>Registros Duplicados!</b>");
        } else {
          if ($request=='error_insert') {
            $arrRspta=array("status"=>false,"msg"=>"Error Insertando Registros!");
          } else {
            $arrRspta=array("status"=>false,"msg"=>"Error Editando Registros!");
          }
        }
      echo json_encode($arrRspta,JSON_UNESCAPED_UNICODE);
    } else{
      header("location:".base_URL()."error403");
    }
  }

  public function Eliminar(){
    if (isset($_POST["security"])) {
      $request = '';
      if (empty($_POST['eliminar_reg'])) {
        $arrRspta = array("status" => false, "msg" => "No Seleccionó ningún Registro para Eliminar!");
      } else {
        $idmacceso = $_POST['eliminar_reg'];
        foreach ($idmacceso as $valor) {
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
    if (isset($_POST['idmacceso'])) {
      $idmacceso=intval(limpiarCadena($_POST['idmacceso']));
      if ($idmacceso>0) {
        $arrData=$this->model->ShowDt($idmacceso);
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
    if (isset($_POST['idmacceso'])) {
      $idmacceso=intval(limpiarCadena($_POST['idmacceso']));
      $estatus=intval(1);
      $request=$this->model->EstatusDt($idmacceso,$estatus);
      if($request>0){
        $arrRspta=array("status"=>true,"msg"=>"Registro Activado Correctamente!");
      }else {
        $arrRspta=array("status"=>false,"msg"=>"Error al Activar el Registro!");
      }
      echo json_encode($arrRspta,JSON_UNESCAPED_UNICODE);
    }else {
      header("location:".base_URL()."error403");
    }
  }

  public function Desactivar(){
    if (isset($_POST['idmacceso'])) {
      $idmacceso=intval(limpiarCadena($_POST['idmacceso']));
      $estatus=intval(0);
      $request=$this->model->EstatusDt($idmacceso,$estatus);
      if($request>0){
        $arrRspta=array("status"=>true,"msg"=>"Registro Desctivado Correctamente!");
      }else {
        $arrRspta=array("status"=>false,"msg"=>"Error al Desactivar el Registro!");
      }
      echo json_encode($arrRspta,JSON_UNESCAPED_UNICODE);
    }else {
      header("location:".base_URL()."error403");
    }
  }

  public function Listar(){
    if (isset($_POST['security'])) {
      $arrData=$this->model->SelectDt();
      $al='style="text-align:';
      $w='; width:';
  
      for ($i=0; $i<count($arrData);$i++) { 
        if($arrData[$i]['estatus']==1){
          $arrData[$i]['estatus']='<small class="badge badge-success">Activo</small>';
          $arrData[$i]['opciones']=
          '<small '.$al.'center'.$w.'100px;" class="small btn-group">
          <button type="button" class="btn btn-primary btn-xs" onclick="mostrar('.$arrData[$i]['idmacceso'].')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil"></i></button>'.
          '<button type="button" class="btn btn-success btn-xs" onclick="desactivar('.$arrData[$i]['idmacceso'].')" data-toggle="tooltip" data-placement="right" title="Desactivar"><i class="fa fa-check"></i></button>
          </small>';
        } else {
          $arrData[$i]['estatus']='<small class="badge badge-danger">Inactivo</small>';
          $arrData[$i]['opciones']=
          '<small '.$al.'center'.$w.'100px;" class="small btn-group">
          <button type="button" class="btn btn-primary btn-xs" onclick="mostrar('.$arrData[$i]['idmacceso'].')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil"></i></button>'.
          '<button type="button" class="btn btn-warning btn-xs" onclick="activar('.$arrData[$i]['idmacceso'].')" data-toggle="tooltip" data-placement="right" title="Activar"><i class="fa fa-exclamation-triangle"></i></button>
          </small>';   
        }
        $arrData[$i]['cod_macceso']='<h6>'.$arrData[$i]['cod_macceso'].'</h6>';
        $arrData[$i]['desc_macceso']='<h6>'.$arrData[$i]['desc_macceso'].'</h6>';
        $arrData[$i]['departamento']='<h6>'.$arrData[$i]['departamento'].'</h6>';
        $arrData[$i]['eliminar']='<input type="checkbox" name="eliminar_reg[]" value="'.$arrData[$i]['idmacceso'].'">';
      }
      echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
    }else {
      header("location:".base_URL()."error403");
    }
    die();
  }

  public function Selectpicker(){
    if (isset($_POST['security'])) {
      $arrData=$this->model->ListDt();
      for ($i=0; $i<count($arrData);$i++) { 
        echo '<option value="'.$arrData[$i]['idmacceso'].'">'.$arrData[$i]['cod_macceso'].'-'.$arrData[$i]['desc_macceso'].'</option>';
      }
    }else {
      header("location:".base_URL()."error403");
    }
  }

  public function AccesoTab(){
    if (isset($_POST['security'])) {
      $modulo = limpiarCadena($_POST['modulo']);
      $idmacceso = limpiarCadena($_POST['idmacceso']);
      $valores = array();
  
      if (!empty($idmacceso)) {
  
        $Modulos = $this->model->ListarModulo($modulo);
        $Marcados = $this->model->ListarMarcados($idmacceso, $modulo);
        for ($i = 0; $i < count($Marcados); $i++) {
          array_push($valores, $Marcados[$i]['idacceso'],$Marcados[$i]['eliminar']);
        }
      } else {
        $Modulos = $this->model->ListarModulo($modulo);
      }
  
      echo
        '<thead class="bg-gray">
        <th>Tablas</th>
        <th width="10%">Estado</th>
        <th width="10%">Permiso</th>                                   
          </thead>';
      for ($i = 0; $i < count($Modulos); $i++) {
        $sw = in_array($Modulos[$i]['idacceso'], $valores) ? 'checked' : '';
        $swi = in_array($Modulos[$i]['idacceso'], $valores) ? 'success fa fa-check-circle' : 'danger fa fa-times-circle';
  
  
        echo $fila = '<tr class="filas">
          <td><label>'.$Modulos[$i]['desc_acceso'].'</label></td>
          <td><input form="dataForm" type="checkbox" '.$sw.' name="accesos[]" value="'.$Modulos[$i]['idacceso'].'" class="chk chk'. $modulo .'"></td>
          <td><i class="text-'.$swi.' a'.$modulo.'"></i></td>
  
        </tr>';
      }

    }else {
      header("location:".base_URL()."error403");
    }
  }

  public function AccesoOp(){
    if (isset($_POST['security'])) {

      $modulo = limpiarCadena($_POST['modulo']);
      $idmacceso = limpiarCadena($_POST['idmacceso']);
      $valores = array();

    if (!empty($idmacceso)) {

      $Modulos = $this->model->ListarModulo($modulo);
      $Marcados = $this->model->ListarMarcados($idmacceso, $modulo);
      for ($i = 0; $i < count($Marcados); $i++) {
        array_push($valores, $Marcados[$i]['idacceso']);
      }
    } else {
      $Modulos = $this->model->ListarModulo($modulo);
    }

    echo
      '<thead class="bg-gray">
      <th>Operaciones</th>
      <th width="10%">Estado</th>
      <th width="10%">Permiso</th>                                   
      </thead>';
    for ($i = 0; $i < count($Modulos); $i++) {
      $sw = in_array($Modulos[$i]['idacceso'], $valores) ? 'checked' : '';
      $swi = in_array($Modulos[$i]['idacceso'], $valores) ? 'success fa fa-check-circle' : 'danger fa fa-times-circle';

      echo $fila = '<tr class="filas">
				<td><label>' . $Modulos[$i]['desc_acceso'] . '</label></td>
				<td><input form="dataForm" type="checkbox" ' . $sw . ' name="accesos[]" value="' . $Modulos[$i]['idacceso'] . '" class="chk chk' . $modulo . '"></td>
        <td><i class="text-' . $swi . ' a' . $modulo . '"></i></td>
			</tr>';
    }

    }else {
      header("location:".base_URL()."error403");
    }
  }
}