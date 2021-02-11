<?php
class ArtPrecio extends Controllers{

  public function __construct(){
    parent::__construct();
  }

  public function artprecio(){

// $_POST['idarticulop']
// $_POST['idartprecio']
// $_POST['idtipoprecio']
// $_POST['idmoneda']
// $_POST['fecharegp']
// $_POST['preciom']
// $_POST['fechavenp']
// $_POST['margenm']
// $_POST['venc']
    ob_start();
    session_start();
    if (!isset($_SESSION["sidusuario"])){
      header("Location:".base_URL()."login");
    } else {
      if ($_SESSION['articulo']==1){     
        $data['page_tag']="Unidad";
        $data['page_title']=".:: Unidad ::.";
        $data['page_name']="unidad";
        $data['func']="functions_unidad.js";
        $this->views->getView($this,"artprecio");
      } else {
        header("Location:".base_URL()."error403");
      }
    }
    ob_end_flush();
  }

  public function ListaPrecio(){
    $arrData=$this->model->ListDt(POSTT($_POST['id']));
    $data = array();
    $al='style="font-size:14px;text-align:';
    $w='; width';
    $btn='button type="button" class="';	
    echo '<thead class="bg-gray">
          <th class="nd text-center nd" style="width:100px">Opciones</th>
          <th class="nd text-center nd" style="width:30px;font-size:14px">Moneda</th>
          <th class="nd text-center nd" style="width:220px">Tipo de Precio</th>
          <th class="nd text-center nd" style="width:150px">Precio Neto</th>
          <th class="nd text-center nd" style="width:80px;font-size:14px">Margen</th>
          <th class="nd text-center nd" style="width:160px">Margen+Precio</th>
          <th class="nd text-center nd" style="width:120px">Impuesto</th>
          <th class="nd text-center nd" style="width:160px">Total Precio</th>
          <th class="nd text-center nd" style="width:90px">Registro</th>
          <th class="nd text-center nd" style="width:90px">F. Venc.</th>
          <th class="nd text-center nd" style="width:50px;font-size:14px">Venc.</th>
          </thead>';
         foreach ($arrData as $row) {
          $data[] =
          '<tr class="filas">
            <td>
              <small style="text-align:center; width:100px" class="small btn-group">
              <'.$btn.'btn btn-primary btn-xs btnl" onclick="EditarPrecio('.$row['idartprecio'].')"> Editar </button>
              <'.$btn.'btn btn-danger btn-xs btnl" onclick="eliminarPrecio('.$row['idartprecio'].')">Eliminar</button>
              </small>
            </td>
            <td><h6 '.$al.'center'.$w.':50px;">'.$row['simbolo'].'</h6></td>
            <td><h6 '.$al.''.$w.':200px;">'.$row['cod_tipoprecio'].'-'.$row['desc_tipoprecio'].'</h6></td>
            <td><h6 '.$al.'right'.$w.':150px;">'.formatMoneyP($row['montoprecio'],2).'</h6></td>
            <td><h6 '.$al.'center'.$w.':50px;">'.formatMoneyP($row['margen'],0).' %</h6></td>
            <td><h6 '.$al.'right'.$w.':160px;">'.formatMoneyP($row['preciom'],2).'</h6></td>
            <td><h6 '.$al.'right'.$w.':120px;">'.formatMoneyP($row['imp'],2).'</h6></td>
            <td><h6 '.$al.'right'.$w.':160px;">'.formatMoneyP($row['preciot'],2).'</h6></td>
            <td><h6 '.$al.'center'.$w.':90px;">'.$row['fechareg'].'</h6></td>
            <td><h6 '.$al.'center'.$w.':90px;">'.$row['fechaven'].'</h6></td>
            <td><h6 '.$al.'center'.$w.':50px;"><input type="checkbox" class="vencel" disabled value="'.$row['vence'].'"></h6></td>
          </tr>';		
        }
      var_dump($data,JSON_UNESCAPED_UNICODE);
  }

  public function MostrarPrecio(){
    $arrData=$this->model->ShowDt(POSTT($_POST['id']));
    echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
  }

  public function GuadarEditarPrecio(){
    if (empty($_POST['idartprecio'])) {
      $request=$this->model->InsertDt($_POST['idarticulop'],$_POST['idtipoprecio'],$_POST['idmoneda'],formatDate($_POST['fecharegp']),
      insertNumber($_POST['preciom']),formatDate($_POST['fechavenp']),insertNumber($_POST['margenm']),$_POST['venc']);
      $option=1;
    } else {
      $request=$this->model->UpdateDt($_POST['idartprecio'],$_POST['idtipoprecio'],$_POST['idmoneda'],formatDate($_POST['fecharegp']),
      insertNumber($_POST['preciom']),formatDate($_POST['fechavenp']),insertNumber($_POST['margenm']),$_POST['venc']);
      $option=2;
    }
  
    if($request){
      if ($option==1) {
        $arrRspta=array("status"=>true,"msg"=>"Registro Ingresado Correctamente!");
      } else {
        $arrRspta=array("status"=>true,"msg"=>"Registro Actualizado Correctamente!");
      }
    } else if ($request=="1062"){
      $arrRspta=array("status"=>false,"msg"=>"El Tipo de Precio ya se encuentra Registrado!
      <br>No es posible ingresar <b>Registros Duplicados!</b>");
    } else {
      $arrRspta=array("status"=>false,"msg"=>$request);
    }
    echo json_encode($arrRspta,JSON_UNESCAPED_UNICODE); 
  }

  public function Eliminar(){
    $request = $this->model->EliminarDt($_POST['id']);
    if ($request == 1) {
      $arrRspta = array("status" => true, "msg" => "Registros Eliminados Correctamente!");
    } else if ($request == '1451') {
      $arrRspta = array("status" => false, "msg" => "No es Posible Eliminar Registros Relacionados!");
    } else {
      $arrRspta = array("status" => false, "msg" =>$request);
    }
      echo json_encode( $arrRspta , JSON_UNESCAPED_UNICODE);
  }


}