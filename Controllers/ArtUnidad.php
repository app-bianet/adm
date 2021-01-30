<?php 
class ArtUnidad extends Controllers{

  public function __construct(){
    session_start();
    ob_start();
    if (!isset($_SESSION['sidusuario'])){
      header("Location:".base_URL()."login");
      session_unset();
      session_destroy();
    } 
    ob_end_flush();     
    parent::__construct();
  }

   public function artunidad(){
    $this->views->getView($this,"artunidad");
  }

  public function MostrarUnidad(){
    $arrRspta=$this->model->SelectDt(POSTT($_POST['id']));
    echo json_encode($arrRspta,JSON_UNESCAPED_UNICODE); 
  }

  public function ListarUnidad(){
    $arrData=$this->model->ShowListUnidad(POSTT($_POST['id']));
    $reng=0;
    $data = array();
    $al='style="text-align:';
    $w='; width';
    $btn='button type="button" class="';
    echo '<thead class="bg-gray">
            <th class="text-center" style="width: 20%;">Opciones</th>
            <th class="text-center">Unidad</th>
            <th class="text-center" style="width: 10%;">Valor</th>
            <th class="text-center" style="width: 10%; font-size:12px">Principal</th>
          </thead>';
          foreach ($arrData as $row) {
            $data[] =
            '<tr class="filas" id="fila'.($reng+1).'">
              <td><h6 style="text-align:center; width:20%" class="span btn-group">
                <'.$btn.'btn btn-primary btn-xs btnl" onclick="mostrarUnidad('.$row['idartunidad'].')"> Editar </button>
                <'.$btn.'btn btn-danger btn-xs btnl" onclick="eliminarUnidad('.$row['idartunidad'].',\''.$row['principal'].'\')"> Eliminar </button>
              </h6></td>
              <td><h6 '.$al.''.$w.'60%">'.$row['desc_unidad'].'</h6></td>
              <td><h6 '.$al.'right'.$w.':10%">'.formatStock($row['valor']).'</h6></td>
              <td class="text-center"><input type="checkbox" class="chk" disabled value="'.$row['principal'].'"></td>
            </tr>';
          }
    var_dump($data,JSON_UNESCAPED_UNICODE);
  }

  public function GuadarEditarUnidad(){

    if (empty(POSTT($_POST['idartunidad']))) {
      $request=$this->model->InsertDt(POSTT($_POST['idarticulou']), POSTT($_POST['idunidad']),
      POSTT($_POST['valor']),POSTT($_POST['principal']));
      $option=1;
    } else {
      $request=$this->model->UpdateDt(POSTT($_POST['idartunidad']),POSTT($_POST['idarticulou']),POSTT($_POST['idunidad']),POSTT($_POST['valor']),
      POSTT($_POST['principal']));
      $option=2;
    }

    if($request==1){
      if ($option==1) {
        $arrRspta=array("status"=>true,"msg"=>"Registro Ingresado Correctamente!");
      } else {
        $arrRspta=array("status"=>true,"msg"=>"Registro Actualizado Correctamente!");
      }
    } else if ($request=="principaldt"){
      $arrRspta=array("status"=>false,"msg"=>"Solo es posible indicar una Unidad como <b>Principal</b>");
    } else if ($request=="duplicado"){
      $arrRspta=array("status"=>false,"msg"=>"La Unidad Seleccionada ya se encuentra Registrada! 
      <br>No es posible ingresar <b>Registros Duplicados!</b>");
    } else {
      if ($request) {
        $arrRspta=array("status"=>false,"msg"=>"Error Insertando Registros!");
      } else {
        $arrRspta=array("status"=>false,"msg"=>"Error Editando Registros!");
      }
    }
    echo json_encode($arrRspta,JSON_UNESCAPED_UNICODE);  
  }

  public function Eliminar(){
    $resquest = $this->model->EliminarDt($_POST['id'],$_POST['principal']);
      if ($resquest == 'duplicado') {
          $arrRspta = array("status" => false, "msg" => "No es Posible Eliminar Registros Relacionados!");
      } else if ($resquest == 'principaldt') {
          $arrRspta = array("status" => false, "msg" => "No Es posible Eliminar la Unidad Principal!
          <br>Edite la <b>Unidad Pricipal</b> Antes de Eliminar!");
      } else if ($resquest == 1) {
          $arrRspta = array("status" => true, "msg" => "Registros Eliminados Correctamente!");
      } else {
          $arrRspta = array("status" => false, "msg" => "Error eliminado Registros!");
      }
    echo json_encode( $arrRspta , JSON_UNESCAPED_UNICODE);
  }
  
}