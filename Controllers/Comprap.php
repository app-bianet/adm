<?php
class Comprap extends Controllers{

  public function __construct(){   
    parent::__construct();
  }

  public function comprap(){
    ob_start();
    session_start();
    if (!isset($_SESSION["sidusuario"])){
      header("Location:".base_URL()."login");
    } else {
      if ($_SESSION['compraf']==1){     
        $data['page_tag']="Pedido de Compra";
        $data['page_title']=".:: Pedido de Compra ::.";
        $data['page_name']="comprap";
        $data['func']="functions_compra.js";
        $this->views->getView($this,"comprap",$data);
      } else {
        header("Location:".base_URL()."error403");
      }
    }
    ob_end_flush();
  }

  public function Insertar(){
    if(isset($_POST["security"])){

      $idcompra=isset($_POST["idcompra"])? limpiarCadena($_POST["idcompra"]):"";
      $idproveedor=isset($_POST["idproveedor"])? limpiarCadena($_POST["idproveedor"]):"";
      $idcondpago=isset($_POST["idcondpago"])? limpiarCadena($_POST["idcondpago"]):"";
      $idusuario=isset($_POST["idusuario"])? limpiarCadena($_POST["idusuario"]):"";
      $cod_compra=isset($_POST["cod_compra"])? limpiarCadena($_POST["cod_compra"]):"";
      $desc_compra=isset($_POST["desc_compra"])? limpiarCadena($_POST["desc_compra"]):"";
      $tipo=isset($_POST["tipo"])? limpiarCadena($_POST["tipo"]):"";
      $numerod=isset($_POST["numerod"])? limpiarCadena($_POST["numerod"]):"";
      $numeroc=isset($_POST["numeroc"])? limpiarCadena($_POST["numeroc"]):"";
      $origend=isset($_POST["origend"])? limpiarCadena($_POST["origend"]):"";
      $origenc=isset($_POST["origenc"])? limpiarCadena($_POST["origenc"]):"";
      $subtotalh=isset($_POST["subtotalh"])? limpiarCadena($_POST["subtotalh"]):"";
      $desch=isset($_POST["desch"])? limpiarCadena($_POST["desch"]):"";
      $impuestoh=isset($_POST["impuestoh"])? limpiarCadena($_POST["impuestoh"]):"";
      $totalh=isset($_POST["totalh"])? limpiarCadena($_POST["totalh"]):"";
      $saldoh=isset($_POST["saldoh"])? limpiarCadena($_POST["saldoh"]):"";
      $fechareg=isset($_POST["fechareg"])? limpiarCadena($_POST["fechareg"]):"";
      $fechaven=isset($_POST["fechaven"])? limpiarCadena($_POST["fechaven"]):"";

        $request=$this->model->InsertDt($idproveedor,$idcondpago,$idusuario,$cod_compra,$desc_compra,$numerod,
        $numeroc, $tipo,$origend,$origenc,'Registrado',$subtotalh,$desch,$impuestoh,
        $totalh,$saldoh,formatDate($fechareg),formatDate($fechaven),
        $_POST['idarticulo'],$_POST['iddeposito'],$_POST["idartunidad"],$_POST['cantidad'],
        $_POST['costo'],$_POST['pdesc'],$_POST['tasa']);

          $this->model->AddStockArt($_POST['idarticulo'],$_POST['iddeposito'],$_POST['cantidad'],
          $_POST['valor'],$_POST['tipoa']);
          $this->model->AjustarCosto($_POST['idarticulo'],$_POST['costo'],
          $_POST['pdesc'],$_POST['valor']);

          if (!empty($_POST['idcompraop']) && $origend!='Cotizacion' ) {
            $this->model->ActDetalleImp($_POST['idcompraop'],$origenc);
          }
          if (!empty($_POST['idcompraop'])) {
            $this->model->ProcesarDocumentoImp($_POST['idcompraop']);
          }

      if($request){
        $arrRspta=array("status"=>true,"msg"=>"Registro Ingresado Correctamente!");
      } else if ($request=="1062"){
        $arrRspta=array("status"=>false,"msg"=>"El Código <b>".$cod_compra."</b> ya se encuentra Registrado! 
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
    if (isset($_POST['idcompra'])) {
      $idcompra=intval(limpiarCadena($_POST['idcompra']));
      if ($idcompra>0) {
        $arrData=$this->model->ShowDt($_POST['idcompra']);
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

  public function MostrarDetalle(){
    $arrData=$this->model->MostrarDetalle($_POST['id']);
    $cont=0;
      foreach ($arrData as $row) {
        $data[]=
        '<tr class="filas" id="fila'.($cont+1).'">
        <td><span style="width:25px; "text-align:center;" class="badge badge-danger">'.($cont+1).'</span></td>
        <td class="hidden">
          <input name="idcomprad[]" id="idcomprad[]" value="'.$row['idcomprad'].'" type="text">
          <input name="idarticulo[]" id="idarticulo[]" value="'.$row['idarticulo'].'" type="text">
          <input name="iddeposito[]" id="iddeposito" value="'.$row['iddeposito'].'" type="text" >
          <input name="idartunidad[]" id="idartunidad[]" value="'.$row['idartunidad'].'" type="text" >
          <input name="tipoa[]" id="tipoa[]" value="'.$row['tipo'].'" type="text">
          <input name="tasa[]" id="tasa[]" value="'.$row['tasa'].'" type="text">
          <input name="valor[]" id="valor[]" value="'.$row['valor'].'" type="text">
          <input name="pdesc[]" id="pdesc[]" value="'.$row['pdesc'].'" type="text">
          <input name="cantidad[]" id="cantidad[]" value="'.$row['cantidad'].'" type="text" >
          <input name="costo[]" id="costo[]" value="'.$row['costo'].'" type="text" >
        </td>
        <td style="min-width:120px;"><h6>'.$row['cod_articulo'].'</h6></td>
        <td style="min-width:400px;"><input class="form-control form-control-sm" type="text" 
        style="height: calc(1.650rem); border:none; pointer-events:none" value="'.$row['desc_articulo'].'"></td>
        <td style="min-width:90px;"><h6>'.$row['desc_unidad'].'</h6></td>
        <td style="min-width:80px;"><h6 class="nformatn">'.$row['cantidad'].'</h6></td>
        <td style="min-width:150px;"><h6 class="nformat">'.$row['costo'].'</h6></td>
        <td style="min-width:80px;"><h6 class="nformatn">'.$row['pdesc'].'</h6></td>
        <td style="min-width:150px;"><h6 class="nformat" name="mdesc" id="mdesc">0</h6></td>
        <td style="min-width:150px;"><h6 id="subtotal" name="subtotal" class="nformat">0</h6></td>
        <td class="hidden">'.$row['tasa'].'</td>
        <td style="min-width:150px;"><h6 class="nformat" name="subimp" id="subimp">0</h6></td>
        <td style="min-width:150px;"><h6 class="nformat" name="total" id="total" >0</h6></td>
        </tr>';
        $cont++;
      };
    var_dump($data,JSON_UNESCAPED_UNICODE);
  }

  public function Anular(){
    $tipo=POSTT($_POST['tipo']);
    $origend=POSTT($_POST['origend']);
    $origenc=POSTT($_POST['origenc']);
    $idcompra=POSTT($_POST['id']);
    $totalh=POSTT($_POST['totalh']);


    if ($tipo!='Cotizacion' && empty($origenc)){
      $this->model->AnularDetalle($idcompra);
    } if ($tipo!='Cotizacion' && !empty($origenc) && $origend=='Cotizacion'){
      $this->model->AnularDetalle($idcompra);
    } 
    (!empty($origenc))?$this->model->AnularProcesarDocumentoImp($origenc,$origend,$totalh):'';

    $request=$this->model->AnularDt($idcompra);
    if($request){
      $arrRspta=array("status"=>true,"msg"=>"Registro Anulado Correctamente!");
    }else {
      $arrRspta=array("status"=>false,"msg"=>"Error al Anular el Registro!");
    }
    echo json_encode($arrRspta,JSON_UNESCAPED_UNICODE);
    die();
  }

  public function Eliminar(){
    $tipo=POSTT($_POST['tipo']);
    $origend=POSTT($_POST['origend']);
    $origenc=POSTT($_POST['origenc']);
    $idcompra=POSTT($_POST['id']);
    $totalh=POSTT($_POST['totalh']);

    if ($tipo!='Cotizacion' && empty($origenc)){
      $this->model->AnularDetalle($idcompra);
    } if ($tipo!='Cotizacion' && !empty($origenc) && $origend=='Cotizacion'){
      $this->model->AnularDetalle($idcompra);
    } 
    (!empty($origenc))?$this->model->AnularProcesarDocumentoImp($origenc,$origend,$totalh):'';

    $request=$this->model->EliminarDt($idcompra);
    if($request){
      $arrRspta=array("status"=>true,"msg"=>"Registro Eliminado Correctamente!");
    }else {
      $arrRspta=array("status"=>false,"msg"=>"Error al Eliminar el Registro!");
    }
    echo json_encode($arrRspta,JSON_UNESCAPED_UNICODE);
    die();
  }

  public function Listar(){
    if (isset($_POST["security"])) {
      $arrData=$this->model->SelectDt('Pedido');
      $al='style="text-align:';
      $w='; width:';
      $btn='button type="button" class="btn btn-xs btn-';
      $dtg='data-toggle="tooltip" data-placement="right" title="';
      for ($i=0; $i<count($arrData);$i++) {
      if ($arrData[$i]['estatus']=='Registrado') {
          $estatus='<small class="badge badge-primary">Registrado</small>';         
      } else if ($arrData[$i]['estatus']=='Anulado'){
          $estatus='<small class="badge badge-danger">Anulado</small>';         
      }else if ($arrData[$i]['estatus']=='Procesado'){
          $estatus='<small class="badge badge-success">Procesado</small>';         
      } else if ($arrData[$i]['estatus']=='Procesado Parc.'){
          $estatus='<small class="badge bg-green">Procesado Parc.</small>';         
      }else if ($arrData[$i]['estatus']=='Pagado'){
          $estatus='<small class="badge bg-purple">Pagado</small>';         
      } else if ($arrData[$i]['estatus']=='Pago Parc.'){
          $estatus='<small class="badge bg-fuchsia">Pago Parc.</small>';         
      }    

      if($arrData[$i]['estatus']=='Registrado'){
        $arrData[$i]['opciones']=
        '<small '.$al.'center'.$w.'150px;" class="small btn-group">
          <'.$btn.'primary" onclick="mostrar('.$arrData[$i]['idcompra'].')" '.$dtg.'Editar"><i class="fa fa-pencil"></i></button>
          <'.$btn.'warning" onclick="anular('.$arrData[$i]['idcompra'].',\''.$arrData[$i]['tipo'].'\',\''.$arrData[$i]['origenc'].'\',
          \''.$arrData[$i]['origend'].'\',\''.$arrData[$i]['totalh'].'\')" '.$dtg.'Anular"><i class="fa fa-exclamation-triangle"></i></button>
          <'.$btn.'danger" onclick="eliminar('.$arrData[$i]['idcompra'].',\''.$arrData[$i]['tipo'].'\',\''.$arrData[$i]['origenc'].'\',
          \''.$arrData[$i]['origend'].'\',\''.$arrData[$i]['totalh'].'\')" '.$dtg.'Eliminar"><i class="fa fa-times"></i></button>
          <'.$btn.'info" onclick="reportef('.$arrData[$i]['idcompra'].')" '.$dtg.'Reporte de Compra"><i class="fa fa-file-csv"></i></button>
          <'.$btn.'secondary" onclick="reporte('.$arrData[$i]['idcompra'].')" '.$dtg.'Factura de Compra"><i class="fa fa-file"></i></button>
        </small>';
      } else {
          $arrData[$i]['opciones']=
          '<small '.$al.'center'.$w.'150px;" class="small btn-group">
          <'.$btn.'success" onclick="mostrar('.$arrData[$i]['idcompra'].')" '.$dtg.'Editar"><i class="fa fa-pencil"></i></button>
          <'.$btn.'warning" disabled '.$dtg.'Editar"><i class="fa fa-exclamation-triangle"></i></button>
          <'.$btn.'danger" disabled '.$dtg.'Editar"><i class="fa fa-times"></i></button>
          <'.$btn.'primary" onclick="reportef('.$arrData[$i]['idcompra'].')" '.$dtg.'Editar"><i class="fa fa-list"></i></button>
          <'.$btn.'secondary" onclick="reporte('.$arrData[$i]['idcompra'].')" '.$dtg.'Editar"><i class="fa fa-file"></i></button>
          </small>';   
      }
        $arrData[$i]['fechareg']='<h6 '.$al.''.$w.'90px;">'.$arrData[$i]['fechareg'].'</h6>';
        $arrData[$i]['cod_compra']='<h6 '.$al.'center'.$w.'90px;">'.$arrData[$i]['cod_compra'].'</h6>';
        $arrData[$i]['desc_proveedor']='<h6 '.$al.''.$w.'400px;">'.$arrData[$i]['desc_proveedor'].'</h6>';
        $arrData[$i]['rif']='<h6 '.$al.''.$w.'100px;">'.$arrData[$i]['rif'].'</h6>';
        $arrData[$i]['numerod']='<h6 '.$al.'left'.$w.'90px;">'.$arrData[$i]['numerod'].'</h6>';
        $arrData[$i]['total']='<h6 '.$al.'rigth'.$w.'150px;">'.formatMoneyP($arrData[$i]['totalh'],2).'</h6>';
        $arrData[$i]['estatus']=$estatus;
      }
      echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
    } else{
      header("Location:".base_URL()."Error403");
    }
    die();
  }

  public function Selectpicker(){
    if (isset($_POST["security"])) {
      $arrData=$this->model->ListDt();
      if ($arrData) {
        for ($i=0; $i<count($arrData);$i++) { 
          echo '<option value="'.$arrData[$i]['idcompra'].'">'.$arrData[$i]['cod_compra'].'-'.$arrData[$i]['desc_compra'].'</option>';
        }
      } else {
        echo '<option readonly>No Existen Registros!</option>';
      }
    } else {
      header("Location:".base_URL()."Error403");
    }
  }

  public function ListarProveedor(){
    $arrData=$this->model->ShowProveedor();
    $data=array();
    foreach($arrData as $row){
      $data[]=array(
        '0'=>'<button class="btn btn-xs btn-primary btn-block" type="button" onclick="
        agregarProveedor('.$row['idproveedor'] .',\''. $row['idcondpago'] . '\',\''. $row['cod_proveedor'] . '\',\''. $row['cod_proveedor'] . '\',
        \''. $row['desc_proveedor'] . '\',\''. $row['rif'] . '\',\''. $row['dias'] . '\',\''. $row['limite'] . '\')">Agregar</button>',
        '1'=>'<h6 style="width:100px;">'.$row['cod_proveedor'].'</h6>',
        '2'=>'<h6 style="width:400px;">'.$row['desc_proveedor'].'</h6>',
        '3'=>'<h6 style="width:100px;">'.$row['rif'].'</h6>',
        '4'=>'<h6 style="width:200px;">'.$row['cod_condpago'].'-'.$row['desc_condpago'].'</h6>',
      );
    }
    $results = array(
      "sEcho" => 1, "iTotalRecords" => count($data), "iTotalDisplayRecords" => count($data), "aaData" => $data
    );
    echo json_encode($results, JSON_UNESCAPED_UNICODE);
  }

  public function ListarArticulos(){
    $arrData = $this->model->SelectArticulo(POSTT($_POST['id']));
    $data = array();
    foreach ($arrData as $row) {
      $data[] = array(
        "0" => '<button type="button" class="btn btn-primary btn-xs" onclick="agregarArticulo
        ('.$row['idarticulo'] .',\''. $row['iddeposito'] . '\',\'' . $row['cod_articulo'] . '\',
        \'' . $row['desc_articulo'] .'\',\'' . $row['tipo'] . '\',\'' . $row['costo'] . '\',
        \'' . $row['tasa'] . '\',\'' . $row['stock'] . '\');" 
        style="text-align:center; width:20px;"><span class="fa fa-times"></span></button>',
        "1" => '<h6 style="width:150px;">' . $row['cod_articulo'] . '</h6>',
        "2" => '<h6 style="width:400px;">' . $row['desc_articulo'] . '</h6>',
        "3" => '<h6 style="width:120px;">' . $row['ref'] . '</h6>',
        "4" => '<h6 style="text-align:right; width:50px;">' . formatMoneyP($row['stock'], 0) . '</h6>',
        "5" => '<h6 style="text-align:right; width:120px;">' . formatMoneyP($row['costo'], 2) . '</h6>',
      );
    }
    $results = array(
      "sEcho" => 1, "iTotalRecords" => count($data), "iTotalDisplayRecords" => count($data), "aaData" => $data
    );
    echo json_encode($results, JSON_UNESCAPED_UNICODE);
  }

}