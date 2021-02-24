<?php
class Ajuste extends Controllers{

  public function __construct(){   
    parent::__construct();
  }

  public function ajuste(){
    ob_start();
    session_start();
    if (!isset($_SESSION["sidusuario"])){
      header("Location:".base_URL()."login");
    } else {
      if ($_SESSION['ajustei']==1){     
        $data['page_tag']="Ajustes";
        $data['page_title']=".:: Ajustes ::.";
        $data['page_name']="ajuste";
        $data['func']="functions_ajuste.js";
        $this->views->getView($this,"ajuste",$data);
      } else {
        header("Location:".base_URL()."error403");
      }
    }
    ob_end_flush();
  }

  public function Insertar(){
    if(isset($_POST["security"])){
      $idajuste=isset($_POST["idajuste"])? limpiarCadena($_POST["idajuste"]):"";
      $idusuario=isset($_POST["idusuario"])? limpiarCadena($_POST["idusuario"]):"";
      $cod_ajuste=isset($_POST["cod_ajuste"])? limpiarCadena($_POST["cod_ajuste"]):"";
      $desc_ajuste=isset($_POST["desc_ajuste"])? limpiarCadena($_POST["desc_ajuste"]):"";
      $tipo=isset($_POST["tipo"])? limpiarCadena($_POST["tipo"]):"";
      $totalstock=isset($_POST["totalstock"])? limpiarCadena($_POST["totalstock"]):"";
      $totalh=isset($_POST["totalh"])? limpiarCadena($_POST["totalh"]):"";
      $fechareg=isset($_POST["fechareg"])? limpiarCadena($_POST["fechareg"]):"";

        $request=$this->model->InsertDt($idusuario,$cod_ajuste,$desc_ajuste,'Registrado',$tipo,
        $totalstock,$totalh,$fechareg,$_POST['idarticulo'],$_POST['iddeposito'],
        $_POST['cantidad'],$_POST['costo'],$_POST['idartunidad']);
        $this->model->AddStockArt($_POST['idarticulo'],$_POST['iddeposito'],$_POST['cantidad'],$_POST['valor'],
        $_POST['tipoa'],$tipo);
        $this->model->AjustarCosto($_POST['idarticulo'],$_POST['costo'],$_POST['valor']);

      if($request>0){
        $arrRspta=array("status"=>true,"msg"=>"Registro Ingresado Correctamente!");
      } else if ($request=="duplicado"){
        $arrRspta=array("status"=>false,"msg"=>"El Código <b>".$cod_ajuste."</b> ya se encuentra Registrado! 
        <br>No es posible ingresar <b>Registros Duplicados!</b>");
      } else {
        $arrRspta=array("status"=>false,"msg"=>$request);
      }
      echo json_encode($arrRspta,JSON_UNESCAPED_UNICODE);    
    } else{
       header("Location:".base_URL()."Error404");
    }
  }

  public function Anular(){
    $request = $this->model->AnularDt(POSTT($_POST['id']));
    $request = $this->model->AnularStock(POSTT($_POST['id']),POSTT($_POST['tipo']));
    if ($request) {
      $arrRspta = array("status" => true, "msg" => "Registros Anulados Correctamente!");
    } else {
      $arrRspta = array("status" => false, "msg" =>$request);
    }
    echo json_encode( $arrRspta , JSON_UNESCAPED_UNICODE);
  }

  public function Eliminar(){
    $request = $this->model->AnularStock(POSTT($_POST['id']),POSTT($_POST['tipo']));
    $request = $this->model->EliminarDt(POSTT($_POST['id']));
    if ($request) {
      $arrRspta = array("status" => true, "msg" => "Registros Eliminado Correctamente!");
    } else {
      $arrRspta = array("status" => false, "msg" =>$request);
    }
    echo json_encode( $arrRspta , JSON_UNESCAPED_UNICODE);
  }

  public function Mostrar(){
    if (isset($_POST['idajuste'])) {
      $idajuste=intval(limpiarCadena($_POST['idajuste']));
      if ($idajuste>0) {
        $arrData=$this->model->Mostrar($idajuste);
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

  public function Listar(){
    if (isset($_POST["security"])) {
      $arrData=$this->model->ListarDt();
      $al='style="text-align:';
      $w='; width:';
      $btn='button" class="btn btn-xs btn-';
      $dtg='data-toggle="tooltip" data-placement="right" title=';
      for ($i=0; $i<count($arrData);$i++) { 
        if($arrData[$i]['estatus']=='Registrado'|| $arrData[$i]['estatus']=='Procesado'){
          $arrData[$i]['opciones']=
          '<small '.$al.'center'.$w.'100px;" class="small btn-group">
          <button type="'.$btn.'primary" onclick="mostrar('.$arrData[$i]['idajuste'].')" '.$dtg.'"Editar"><i class="fa fa-pencil"></i></button>
          <button type="'.$btn.'warning" onclick="anular('.$arrData[$i]['idajuste'].',\''.$arrData[$i]['tipo'].'\')" '.$dtg.'"Anular"><i class="fa fa-exclamation-triangle"></i></button>
          <button type="'.$btn.'danger" onclick="eliminar('.$arrData[$i]['idajuste'].',\''.$arrData[$i]['tipo'].'\')" '.$dtg.'"Eliminar"><i class="fa fa-times"></i></button>
          <button type="'.$btn.'secondary" onclick="reporte('.$arrData[$i]['idajuste'].')" '.$dtg.'"Reporte"><i class="fa fa-clipboard"></i></button>
          </small>';
        } else {
          $arrData[$i]['opciones']=
          '<small '.$al.'center'.$w.'100px;" class="small btn-group">
          <button type="'.$btn.'primary" onclick="mostrar('.$arrData[$i]['idajuste'].')" '.$dtg.'"Editar"><i class="fa fa-pencil"></i></button>
          <button type="'.$btn.'warning" disabled '.$dtg.'"Anular"><i class="fa fa-info-circle"></i></button>
          <button type="'.$btn.'danger" disabled '.$dtg.'"Eliminar"><i class="fa fa-times"></i></button>
          <button type="'.$btn.'secondary" onclick="reporte('.$arrData[$i]['idajuste'].')" '.$dtg.'"Reporte"><i class="fa fa-clipboard"></i></button>
          </i></button>
          </small>';   
        }
        $arrData[$i]['fechareg']='<h6>'.$arrData[$i]['fechareg'].'</h6>';
        $arrData[$i]['cod_ajuste']='<h6>'.$arrData[$i]['cod_ajuste'].'</h6>';
        $arrData[$i]['desc_ajuste']='<h6>'.$arrData[$i]['desc_ajuste'].'</h6>';
        $arrData[$i]['tipo']='<h6>'.$arrData[$i]['tipo'].'</h6>';
        $arrData[$i]['totalh']='<h6>'.formatMoneyP($arrData[$i]['totalh'],2).'</h6>';
        switch ($arrData[$i]['estatus']) {
          case 'Registrado':
            $arrData[$i]['estatus']='<small class=" badge badge-primary">Registrado</small>';
          break;
          case 'Procesado':
            $arrData[$i]['estatus']='<small class=" badge badge-success">Procesado</small>';
          break;
          default:
            $arrData[$i]['estatus']='<small class=" badge badge-danger">Anulado</small>';
          break;
        }
      }
      echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
      die();
    } else{
      header("Location:".base_URL()."Error403");
    }
  }

  public function ListarDetalle(){
    $arrData=$this->model->MostrarDetalle(POSTT($_POST['id']));
    $cont=0;
    $totalf=0;
      echo'<thead class="btn-primary">
            <th style="width:25px;" class="text-center">E</th>
            <th style="width:150px;" class="text-center">Codigo</th>
            <th style="width:450px;" class="text-center">Artículo</th>
            <th style="width:90px;" class="text-center">Unidad</th>
            <th style="width:80px;" class="text-center">Cantidad</th>
            <th style="width:150px;" class="text-center">Costo</th>
            <th style="width:160px;" class="text-center">Total Reng. </th>
          </thead>';
      foreach ($arrData as $row) {
        $data[] ='<tr class="filas">
          <td style="width:25px;"><small style="width:25px; "text-align:center;" class="badge badge-danger">'.($cont+1).'</span></td>
          <td style="width:150px;"><h5>'.$row['cod_articulo'].'</h5></td>
          <td style="width:450px;"><h5><span style="font-size:13px">'.$row['desc_articulo'].'</h5></span></td>
          <td style="text-align:; width:90px;"><h5>'.$row['desc_unidad'].'</h5></td>
          <td style="text-align:right; width:80px; padding-right:4px;"><h6>'.formatMoneyP($row['cantidad'],2).'</h6></td>
          <td style="text-align:right; width:150px;"><h6>'.formatMoneyP($row['costo'],2).'</h6></td>
          <td style="text-align:right; width:160px;"><h6>'.formatMoneyP($row['totald'],2).'</h6></td>
        </tr>';
        $cont++;
        $totalf+=$row['totald'];
      }
      echo '<tfoot class="hidden">
        <th></th>
        <th></th>
        <th></th>
        <th></th>         
        <th></th>
        <th></th>
        <th><h4 style="text-align:right;"><B><input type="hidden" 
          class="numberf" id="totalt" value="'.number_format($totalf,2,",",".").'"></span></B></h4>
        </th>
      </tfoot>';
    var_dump($data,JSON_UNESCAPED_UNICODE);
  }

  public function ListarArticulos(){
    $arrData = $this->model->SelectAjuste(POSTT($_POST['id']), POSTT($_POST['tipo']));
    $data = array();
    foreach ($arrData as $row) {
      $data[] = array(
        "0" => '<button type="button" class="btn btn-secondary btn-xs" onclick="agregarDetalle
        ('.$row['idarticulo'] .',\''. $row['iddeposito'] . '\',\'' . $row['cod_articulo'] . '\',
        \'' . $row['desc_articulo'] . '\',\'' . $row['tipo'] . '\',\'' . $row['costo'] . '\',\'' . $row['stock'] . '\');" 
        style="text-align:center; width:20px;"><span class="fa fa-times-circle"></span></button>',
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

  public function Selectpicker(){
    if (isset($_POST["security"])) {
      $arrData=$this->model->ListDt();
      if ($arrData) {
        for ($i=0; $i<count($arrData);$i++) { 
          echo '<option value="'.$arrData[$i]['idajuste'].'">'.$arrData[$i]['cod_ajuste'].'-'.$arrData[$i]['desc_ajuste'].'</option>';
        }
      } else {
        echo '<option readonly>No Existen Registros!</option>';
      }
    } else {
      header("Location:".base_URL()."Error403");
    }
  }
  
}