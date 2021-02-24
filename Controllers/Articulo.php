<?php
class Articulo extends Controllers{

  public function __construct(){
    parent::__construct();
  }

  public function articulo(){
    ob_start();
    session_start();
    if (!isset($_SESSION["sidusuario"])){
      header("Location:".base_URL()."login");
    } else {
      if ($_SESSION['articulo']==1){     
        $data['page_tag']="Articulo";
        $data['page_title']=".:: Articulo ::.";
        $data['page_name']="articulo";
        $data['func']="functions_articulo.js";
        $this->views->getView($this,"articulo",$data);
      } else {
        header("Location:".base_URL()."error403");
      }
    }
    ob_end_flush();
  }

  public function Insertar(){
    if(isset($_POST["security"])){
    $idarticulo=isset($_POST["idarticulo"])? limpiarCadena($_POST["idarticulo"]):"";
    $idcategoria=isset($_POST["idcategoria"])? limpiarCadena($_POST["idcategoria"]):"";
    $idlinea=isset($_POST["idlinea"])? limpiarCadena($_POST["idlinea"]):"";
    $idimpuesto=isset($_POST["idimpuesto"])? limpiarCadena($_POST["idimpuesto"]):"";
    $cod_articulo=isset($_POST["cod_articulo"])? limpiarCadena($_POST["cod_articulo"]):"";
    $desc_articulo=isset($_POST["desc_articulo"])? limpiarCadena($_POST["desc_articulo"]):"";
    $tipo=isset($_POST["tipo"])? limpiarCadena($_POST["tipo"]):"";
    $origen=isset($_POST["origen"])? limpiarCadena($_POST["origen"]):"";
    $ref=isset($_POST["ref"])? limpiarCadena($_POST["ref"]):"";
    $stockmin=isset($_POST["stockmin"])? limpiarCadena($_POST["stockmin"]):"";
    $stockmax=isset($_POST["stockmax"])? limpiarCadena($_POST["stockmax"]):"";
    $stockped=isset($_POST["stockped"])? limpiarCadena($_POST["stockped"]):"";
    $alto=isset($_POST["alto"])? limpiarCadena($_POST["alto"]):"";
    $ancho=isset($_POST["ancho"])? limpiarCadena($_POST["ancho"]):"";
    $peso=isset($_POST["peso"])? limpiarCadena($_POST["peso"]):"";
    $comision=isset($_POST["comision"])? limpiarCadena($_POST["comision"]):"";
    $costo=isset($_POST["costo"])? limpiarCadena($_POST["costo"]):"";
    $costoprecio=isset($_POST["costoprecio"])? limpiarCadena($_POST["costoprecio"]):"";
    $fechareg=isset($_POST["fechareg"])? limpiarCadena($_POST["fechareg"]):"";

    $imagen=isset($_POST["imagena"])? limpiarCadena($_POST["imagena"]):"";
    $lotes =isset($_POST["lotes"])? limpiarCadena($_POST["lotes"]):"";
    $lotesv =isset($_POST["lotesv"])? limpiarCadena($_POST["lotesv"]):"";
    $seriales =isset($_POST["seriales"])? limpiarCadena($_POST["seriales"]):"";


    //  $stock=isset($_POST["stock"])? limpiarCadena($_POST["stock"]):"";
    //  $condicion=isset($_POST["condicion"])? limpiarCadena($_POST["condicion"]):"";
    //  $iddeposito=isset($_POST["iddeposito"])? limpiarCadena($_POST["iddeposito"]):"";
    $rutaimg=$_SERVER['DOCUMENT_ROOT'].'/Bianet/Files/images/items/';


      if (!file_exists($_FILES['imagena']['tmp_name']) || !is_uploaded_file($_FILES['imagena']['tmp_name'])){
        $imagen=$_POST["imagenactual"];
      } else {
        $ext = explode(".", $_FILES["imagena"]["name"]);
        $_FILES['imagena']['tmp_name']==$rutaimg.$cod_articulo.'.'.end($ext)?
          unlink($rutaimg.$cod_articulo.'.'.end($ext)):''; 
        if (
          $_FILES['imagena']['type'] == "image/jpg" || 
          $_FILES['imagena']['type'] == "image/jpeg" || 
          $_FILES['imagena']['type'] == "image/png"){
          $imagen = $cod_articulo.'.'.end($ext);
          move_uploaded_file($_FILES["imagena"]["tmp_name"], $rutaimg.$imagen);
        } else {
          $arrRspta=array("status"=>false,"msg"=>"El Formato de Imagen no es Soportado!");
        }
      }

      if (empty($idarticulo)) {
        $request=$this->model->InsertDt($idcategoria,$idlinea,$idimpuesto,$cod_articulo,$desc_articulo,
        $tipo,$origen,$ref,insertNumber($stockmin),insertNumber($stockmax),insertNumber($stockped),insertNumber($alto),
        insertNumber($ancho),insertNumber($peso),insertNumber($comision),insertNumber($costo),
        $lotes,$lotesv,$seriales,$costoprecio,$imagen,formatDate($fechareg));
        $option=1;
      } else {
        $request=$this->model->UpdateDt($idarticulo,$idcategoria,$idlinea,$idimpuesto,$cod_articulo,$desc_articulo,
        $tipo,$origen,$ref,insertNumber($stockmin),insertNumber($stockmax),insertNumber($stockped),insertNumber($alto),
        insertNumber($ancho),insertNumber($peso),insertNumber($comision),insertNumber($costo),
        $lotes,$lotesv,$seriales,$costoprecio,$imagen,formatDate($fechareg));
        $option=2;
      }
      if($request>0){
        if ($option==1) {
          $arrRspta=array("status"=>true,"msg"=>"Registro Ingresado Correctamente!","RetornoId"=>$request);
        } else {
          $arrRspta=array("status"=>true,"msg"=>"Registro Actualizado Correctamente!");
        }
      } else if ($request=="duplicado"){
        $arrRspta=array("status"=>false,"msg"=>"El Código <b>".$cod_articulo."</b> ya se encuentra Registrado! 
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
        $idarticulo = $_POST['eliminar_reg'];
        foreach ($idarticulo as $valor) {
          $request = $this->model->EliminarDt($valor);
        }
        if ($request >0) {
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
    if (isset($_POST['idarticulo'])) {
      $idarticulo=intval(limpiarCadena($_POST['idarticulo']));
      if ($idarticulo>0) {
        $arrData=$this->model->ShowDt($idarticulo);
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
    if (isset($_POST['idarticulo'])) {
      $idarticulo=intval(limpiarCadena($_POST['idarticulo']));
      $estatus=intval(1);
      $request=$this->model->EstatusDt($idarticulo,$estatus);
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
    if (isset($_POST['idarticulo'])) {
      $idarticulo=intval(limpiarCadena($_POST['idarticulo']));
      $estatus=intval(0);
      $request=$this->model->EstatusDt($idarticulo,$estatus);
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
          '<small '.$al.'center'.$w.'150px;" class="small btn-group">
          <button type="button" class="btn bg-navy btn-xs" onclick="mostrar('.$arrData[$i]['idarticulo'].')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil"></i></button>
          <button type="button" class="btn btn-success btn-xs" onclick="desactivar('.$arrData[$i]['idarticulo'].')" data-toggle="tooltip" data-placement="right" title="Desactivar"><i class="fa fa-check"></i></button>
          <button type="button" class="btn bg-purple btn-xs" onclick="listadoPrecio('.$arrData[$i]['idarticulo'].',\''.$arrData[$i]['desc_articulo'].'\')" data-toggle="tooltip" data-placement="right" title="Precios"><i class="fa fa-money-bill"></i></button>
          <button type="button" class="btn bg-orange btn-xs" onclick="ListadoStock('.$arrData[$i]['idarticulo'].',\''.$arrData[$i]['desc_articulo'].'\')" data-toggle="tooltip" data-placement="right" title="Stock"><i class="fa fa-cubes"></i></button>
          </small>';
        } else {
          $arrData[$i]['estatus']='<small class="badge badge-danger">Inactivo</small>';
          $arrData[$i]['opciones']=
          '<small '.$al.'center'.$w.'150px;" class="small btn-group">
          <button type="button" class="btn bg-navy btn-xs" onclick="mostrar('.$arrData[$i]['idarticulo'].')" data-toggle="tooltip" data-placement="right" title="Editar"><i class="fa fa-pencil"></i></button>
          <button type="button" class="btn btn-warning btn-xs" onclick="activar('.$arrData[$i]['idarticulo'].')" data-toggle="tooltip" data-placement="right" title="Activar"><i class="fa fa-exclamation-triangle"></i></button>
          <button type="button" class="btn bg-purple btn-xs" onclick="listadoPrecio('.$arrData[$i]['idarticulo'].',\''.$arrData[$i]['desc_articulo'].'\')" data-toggle="tooltip" data-placement="right" title="Precios"><i class="fa fa-money-bill"></i></button>
          <button type="button" class="btn bg-orange btn-xs" onclick="ListadoStock('.$arrData[$i]['idarticulo'].',\''.$arrData[$i]['desc_articulo'].'\')" data-toggle="tooltip" data-placement="right" title="Stock"><i class="fa fa-cubes"></i></button>
          </small>';   
        }
        $arrData[$i]['eliminar']='<h6 '.$al.'center'.$w.'50px;"><input type="checkbox" name="eliminar_reg[]" value="'.$arrData[$i]['idarticulo'].'"></h6>';
        $arrData[$i]['cod_articulo']='<h6 '.$al.''.$w.'150px;">'.$arrData[$i]['cod_articulo'].'</h6>';
        $arrData[$i]['desc_articulo']='<h6 '.$al.''.$w.'490px;">'.$arrData[$i]['desc_articulo'].'</h6>';
        $arrData[$i]['categoria']='<h6 '.$al.''.$w.'300px;">'.$arrData[$i]['cod_categoria'].'-'.$arrData[$i]['desc_categoria'].'</h6>';
        $arrData[$i]['ref']='<h6 '.$al.'center'.$w.'150px;">'.$arrData[$i]['ref'].'</h6>';
        $arrData[$i]['stock']=$arrData[$i]['tipo']=='Servicio'?
        '<h6 '.$al.'center'.$w.'80px;">N/A</h6>':
        '<h6 '.$al.'right'.$w.'80px;">'.formatMoneyP($arrData[$i]['stock'],0).'</h6>';

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
        echo '<option value="'.$arrData[$i]['idarticulo'].'">'.$arrData[$i]['cod_articulo'].'-'.$arrData[$i]['desc_articulo'].'</option>';
      }
    } else {
      header("Location:".base_URL()."Error403");
    }
  }

  public function ListaStock(){
    $arrData=$this->model->ShowStock($_POST['id']);
    $reng=0;
    $totalst=0;
    $data = array();
    echo '<thead class="bg-gray">
      <th style="width:10%" class="text-center">Reng</th>
      <th style="width:65%"class="nd text-center">Deposito</th>
      <th style="width:15%" class="text-center">Stock</th>
      </thead>';
      foreach ($arrData as $row) {
        $data[] =
        '<tr class="filas" id="fila'.($reng+1).'">
          <td><h6 style="width:50%; text-align:center;">'.($reng+1).'</h6></td>
          <td><h6>'.$row['cod_deposito'].'-'.$row['desc_deposito'].'</h6></td>
          <td><h6 style="width:95%;text-align:right;">'.formatStock($row['stock']).'</h6></td>
        </tr>';
        $totalst+=$row['stock'];		
        $reng++;
      }
      echo '<tfoot> 
				<th></th>     
				<th><h6 style="text-align:right;"><B>Total Unidad(s) en Stock :</B></h6></th>
				<th><h6 style="text-align:right;"><B><span id="lbtotalstock">'.formatStock($totalst).'</span></B></h6></th>
			</tfoot>';
      var_dump($data,JSON_UNESCAPED_UNICODE);
  }
}