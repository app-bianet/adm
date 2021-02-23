<?php
class Proveedor extends Controllers{

  public function __construct(){   
    parent::__construct();
  }

  public function proveedor(){
    ob_start();
    session_start();
    if (!isset($_SESSION["sidusuario"])){
      header("Location:".base_URL()."login");
    } else {
      if ($_SESSION['proveedor']==1){     
        $data['page_tag']="Proveedores";
        $data['page_title']=".:: Proveedores ::.";
        $data['page_name']="proveedor";
        $data['func']="functions_proveedor.js";
        $this->views->getView($this,"proveedor",$data);
      } else {
        header("Location:".base_URL()."error403");
      }
    }
    ob_end_flush();
  }

  public function Insertar(){
    if(isset($_POST["security"])){
      $idproveedor=isset($_POST["idproveedor"])? limpiarCadena($_POST["idproveedor"]):"";
      $idtipoproveedor=isset($_POST["idtipoproveedor"])? limpiarCadena($_POST["idtipoproveedor"]):"";
      $idcondpago=isset($_POST["idcondpago"])? limpiarCadena($_POST["idcondpago"]):"";
      $idzona=isset($_POST["idzona"])? limpiarCadena($_POST["idzona"]):"";
      $idoperacion=isset($_POST["idoperacion"])? limpiarCadena($_POST["idoperacion"]):"";
      $idimpuestoz=isset($_POST["idimpuestoz"])? limpiarCadena($_POST["idimpuestoz"]):"";
      $cod_proveedor=isset($_POST["cod_proveedor"])? limpiarCadena($_POST["cod_proveedor"]):"";
      $desc_proveedor=isset($_POST["desc_proveedor"])? limpiarCadena($_POST["desc_proveedor"]):"";
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

      if (empty($idproveedor)) {
        $request=$this->model->InsertDt($idtipoproveedor,$idoperacion,$idcondpago,$idzona,$idimpuestoz,
        $cod_proveedor,$desc_proveedor,$rif,$direccion,$ciudad,$codpostal,$contacto,$telefono,$movil,$email,
        $web,insertNumber($limite),insertNumber($montofiscal),formatDate($fechareg),$aplicareten);
        $option=1;
      } else {
        $request=$this->model->EditarDt($idproveedor,$idtipoproveedor,$idoperacion,$idcondpago,$idzona,$idimpuestoz,
        $cod_proveedor,$desc_proveedor,$rif,$direccion,$ciudad,$codpostal,$contacto,$telefono,$movil,$email,$web,
        insertNumber($limite),insertNumber($montofiscal),formatDate($fechareg),$aplicareten);
        $option=2;
      }

      if($request){
        if ($option==1) {
          $arrRspta=array("status"=>true,"msg"=>"Registro Ingresado Correctamente!");
        } else {
          $arrRspta=array("status"=>true,"msg"=>"Registro Actualizado Correctamente!");
        }
      } else if ($request=="1062"){
        $arrRspta=array("status"=>false,"msg"=>"El Código <b>".$cod_proveedor."</b> ya se encuentra Registrado! 
        <br>No es posible ingresar <b>Registros Duplicados!</b>");
      } else {
        $arrRspta=array("status"=>false,"msg"=>$request);
      }
      echo json_encode($arrRspta,JSON_UNESCAPED_UNICODE);    
    } else{
      header("Location:".base_URL()."Error404");
    }
  }

  public function InsertarProveedorRapido(){
    $cod=POSTT($_POST['cod_proveedori']);
    $desc=POSTT($_POST['desc_proveedori']);
    $rif=POSTT($_POST['rifi']);
    $direccion=POSTT($_POST['direccion']);
    $request=$this->model->InsertDirect($cod,$desc,$rif,$direccion);
    if($request){
        $arrRspta=array("status"=>true,"msg"=>"Registro Ingresado Correctamente!");
    } else if ($request=="1062"){
      $arrRspta=array("status"=>false,"msg"=>"El Código <b>".$cod."</b> ya se encuentra Registrado! 
      <br>No es posible ingresar <b>Registros Duplicados!</b>");
    } else {
      $arrRspta=array("status"=>false,"msg"=>$request);
    }
    echo json_encode($arrRspta,JSON_UNESCAPED_UNICODE);
  }

  public function Eliminar(){
    if (isset($_POST["security"])) {
      $request = '';
      if (empty($_POST['eliminar_reg'])) {
        $arrRspta = array("status" => false, "msg" => "No Seleccionó ningún Registro para Eliminar!");
      } else {
        $idproveedor = $_POST['eliminar_reg'];
        foreach ($idproveedor as $valor) {
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
    if (isset($_POST['idproveedor'])) {
      $idproveedor=intval(limpiarCadena($_POST['idproveedor']));
      if ($idproveedor>0) {
        $arrData=$this->model->ShowDt($idproveedor);
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
    if (isset($_POST['idproveedor'])) {
      $idproveedor=intval(limpiarCadena($_POST['idproveedor']));
      $estatus=intval(1);
      $request=$this->model->EstatusDt($idproveedor,$estatus);
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
    if (isset($_POST['idproveedor'])) {
      $idproveedor=intval(limpiarCadena($_POST['idproveedor']));
      $estatus=intval(0);
      $request=$this->model->EstatusDt($idproveedor,$estatus);
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
          <button type="button" class="btn btn-primary btn-xs" onclick="mostrar('.$arrData[$i]['idproveedor'].')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil"></i></button>
          <button type="button" class="btn btn-success btn-xs" onclick="desactivar('.$arrData[$i]['idproveedor'].')" data-toggle="tooltip" data-placement="right" title="Desactivar"><i class="fa fa-check"></i></button>
          </small>';
        } else {
          $arrData[$i]['estatus']='<small class="badge badge-danger">Inactivo</small>';
          $arrData[$i]['opciones']=
          '<small '.$al.'center'.$w.'100px;" class="small btn-group">
          <button type="button" class="btn btn-primary btn-xs" onclick="mostrar('.$arrData[$i]['idproveedor'].')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil"></i></button>
          <button type="button" class="btn btn-warning btn-xs" onclick="activar('.$arrData[$i]['idproveedor'].')" data-toggle="tooltip" data-placement="right" title="Activar"><i class="fa fa-exclamation-triangle"></i></button>
          </small>';   
        }
        $arrData[$i]['cod_proveedor']='<h6 '.$al.'center'.$w.'150px">'.$arrData[$i]['cod_proveedor'].'</h6>';
        $arrData[$i]['desc_proveedor']='<h6 '.$al.''.$w.'450px">'.cortar_cadena($arrData[$i]['desc_proveedor']).'</h6>';
        $arrData[$i]['rif']='<h6 '.$al.''.$w.'130px;">'.$arrData[$i]['rif'].'</h6>';
				$arrData[$i]['tipo']='<h6 '.$al.''.$w.'250px;">'.$arrData[$i]['cod_tipoproveedor'].'-'.$arrData[$i]['desc_tipoproveedor'].'</h6>';
        $arrData[$i]['operacion']='<h6 '.$al.''.$w.'250px;">'.$arrData[$i]['cod_operacion'].'-'.$arrData[$i]['desc_operacion'].'</h6>';
        $arrData[$i]['contacto']='<h6 '.$al.''.$w.'250px;">'.$arrData[$i]['contacto'].'</h6>';
				$arrData[$i]['telefono']='<h6 '.$al.''.$w.'160px;">'.$arrData[$i]['telefono'].'</h6>';
				$arrData[$i]['movil']='<h6 '.$al.''.$w.'160px;">'.$arrData[$i]['movil'].'</h6>';
				$arrData[$i]['email']='<h6 '.$al.''.$w.'250px;">'.$arrData[$i]['email'].'</h6>';
				$arrData[$i]['limite']='<h6 '.$al.'right'.$w.'130px;">'.formatMoneyP($arrData[$i]['limite'],2).'</h6>'; 
				$arrData[$i]['saldo']='<h6 '.$al.'right'.$w.'150px;">'.formatMoneyP($arrData[$i]['saldo'],2).'</h6>';   
        $arrData[$i]['eliminar']='<input type="checkbox" name="eliminar_reg[]" value="'.$arrData[$i]['idproveedor'].'">';
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
          echo '<option value="'.$arrData[$i]['idproveedor'].'">'.$arrData[$i]['cod_proveedor'].'-'.$arrData[$i]['desc_proveedor'].'</option>';
        }
      } else {
        echo '<option readonly>No Existen Registros!</option>';
      }
    } else {
      header("Location:".base_URL()."Error403");
    }
  }

  public function ImportarDoc(){
    $arrData = $this->model->ImportarDocumento(POSTT($_POST['id']),POSTT($_POST['estatus']),POSTT($_POST['tipo']));
    $data = array();
    foreach ($arrData as $row) {
      if ($row['estatus']=='Registrado') {
        $estatus='<h6 style="width:110px; text-align:center"><small class="badge badge-success">Registrado</small></h6>';
      } else  if ($row['estatus']=='Procesado'){
        $estatus='<h6 style="width:110px; text-align:center"><small class="badge badge-primary">Procesado</small></h6>';
      }else  if ($row['estatus']=='Procesado Parcialmente'){
        $estatus='<h6 style="width:110px; text-align:center"><small class="badge badge-warning">Parc. Procesado</small></h6>';
      }
        $data[] = array(
          "0"=>'<h6><button class="btn btn-success btn-xs" onclick="agregarImportarDoc('.$row['idcompraop'].',
          \''.$row['idproveedor'].'\',\''.$row['idcondpago'].'\',\''.$row['cod_proveedor'].'\',\''.$row['desc_proveedor'].'\',
          \''.$row['rif'].'\',\''.$row['dias'].'\',\''.$row['limite'].'\',\''.$row['tipo'].'\',\''.$row['origenc'].'\')">
          <span class="fa fa-check" style="text-align:center; width:15px;"></span></button></h6>',
          "1"=>'<h6 style="width:80px; text-align:center">'. $row['fechareg'].'</h6>',
          "2"=>$estatus,
          "3"=>'<h6 style="width:100px; text-align:center">'. $row['origenc'].'</h6>',
          "4"=>'<h6 style="width:380px; font-size:12px">'. $row['desc_proveedor'].'</h6>',
          "5"=>'<h6 style="width:95px; text-align:center">'. $row['rif'].'</h6>',
          "6"=>'<h6 style="width:100px; text-align:center">'. $row['numerod'].'</h6>',
          "7"=>'<h6 style="width:150px; text-align:right">'.formatMoneyP($row['totalh'],2).'</h6>'
        );
    }
      $results = array("sEcho" => 1, "iTotalRecords" => count($data), 
      "iTotalDisplayRecords" => count($data), "aaData" => $data);
      echo json_encode($results, JSON_UNESCAPED_UNICODE);
  }

  public function DetalleImportar(){
    $fila=array();
    $cont=0;
    $arrData = $this->model->ImportarDetalle(POSTT($_POST['id']));
    foreach ($arrData as $row) {
      $varcont=count($row);
      $fila[]='<tr class="filas" id="fila'.($cont+1).'">
      <td style="min-width:30px;"><h6><span class="badge badge-danger">'.($cont+1).'</span></h6></td>
      <td class="hidden">
        <input name="idcomprad[]"   id="idcomprad[]"   value="'.$row['idcomprad'].'">
        <input name="idarticulo[]"  id="idarticulo[]"  value="'.$row['idarticulo'].'">
        <input name="iddeposito[]"  id="iddeposito[]" class="depp" value="'.$row['iddeposito'].'">
        <input name="idartunidad[]" id="idartunidad[]" value="'.$row['idartunidad'].'">
        <input name="tipoa[]"       id="tipoa[]"       value="'.$row['tipo'].'">
        <input name="tasa[]"        id="tasa[]"        value="'.$row['tasa'].'">
        <input name="valor[]"       id="valor[]"       value="'.$row['valor'].'">
        <input name="pdesc[]"       id="pdesc[]"       value="'.$row['pdesc'].'">
        <input name="cantidad[]"    id="cantidad[]"    value="'.$row['cantidad'].'">
        <input name="costo[]"       id="costo[]"       value="'.$row['costo'].'">
        <input id="detalles" value="'.($cont+1).'" class="hidden">
      </td>
      <td style="min-width:120px;"><h5 class="text-center">'.$row['cod_articulo'].'</h5></td>
      <td style="min-width:400px;"><input class="form-control form-control-sm" type="text" 
      style="height: calc(1.650rem); border:none; pointer-events:none" value="'.$row['desc_articulo'].'"></></td>
      <td style="min-width:90px;"><h5 class="text-center">'.$row['desc_unidad'].'</h5></td>
      <td style="min-width:90px;"><h5 class="text-rigth">'.$row['cantidad'].'</h5></td>
      <td style="min-width:150px;"><h5 class="text-rigth nformat">'.$row['costo'].'</h5></td>
      <td style="min-width:80px;"><h5 class="text-rigth nformat">'.formatMoneyP($row['pdesc'],0).'</h5></td>
      <td style="min-width:150px;"><h5 class="text-rigth nformat" name="mdesc" id="mdesc">0</h5></td>
      <td style="min-width:150px;"><h5 class="text-rigth nformat" name="subtotal" id="subtotal">0</h5></td>
      <td class="hidden">'.$row['tasa'].'</td>
      <td style="min-width:150px;"><h5 class="text-rigth nformat" name="subimp" id="subimp">0</h5></td>
      <td style="min-width:150px;"><h5 class="text-rigth nformat" name="total" id="total">0</h5></td>
      </tr>';
      $cont++;
    }
    var_dump($fila,JSON_UNESCAPED_UNICODE);
  }
  
  
}