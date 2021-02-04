<?php
session_start();
class Login extends Controllers{

  public function __construct(){
    if (isset($_SESSION['sidusuario'])){
      header("Location:".base_URL()."Escritorio");
    } 
    parent::__construct();
  }

  public function login(){
    $data['item']="Login";
    $data['page_tag']="Login";
    $data['page_title']=".:: Login ::.";
    $data['page_name']="login";
    $data['func']="functions_login.js";
    $this->views->getView($this,"login",$data);
  }

  public function SessionStart(){
    $passpublic=$_POST['clave'];
    $cod_usuario=limpiarCadena($_POST['cod_usuario']);
    $arrData=$this->model->Verificar($cod_usuario);
     for ($i=0; $i<count($arrData);$i++){
       if($arrData[$i]['estatus']==1){

        if (password_verify($passpublic,$arrData[$i]['clave'])) {
          $_SESSION['sidusuario']=base64_encode($arrData[$i]['idusuario']);
          $_SESSION['scod_usuario']=base64_encode($arrData[$i]['cod_usuario']);
          $_SESSION['sdesc_usuario']=base64_encode($arrData[$i]['desc_usuario']);
          $_SESSION['sdepartamento']=base64_encode($arrData[$i]['departamento']);
          $_SESSION['stelefono']=base64_encode($arrData[$i]['telefono']);
          $_SESSION['semail']=base64_encode($arrData[$i]['email']);
          $_SESSION['simagen']=base64_encode($arrData[$i]['imagen']);

          $Marcados = $this->model->ListarMarcados($arrData[$i]['idmacceso']);
          $valores=array();	
       
          for ($i = 0; $i < count($Marcados); $i++) {
            array_push($valores,$Marcados[$i]['idacceso']);
          }

          //Determinamos los accesos del usuario
          in_array(1,$valores)?$_SESSION['config']=1:$_SESSION['config']=0;
          in_array(2,$valores)?$_SESSION['macceso']=1:$_SESSION['macceso']=0;
          in_array(3,$valores)?$_SESSION['usuariod']=1:$_SESSION['usuariod']=0;
          in_array(4,$valores)?$_SESSION['empresa']=1:$_SESSION['empresa']=0;
          in_array(5,$valores)?$_SESSION['operacion']=1:$_SESSION['operacion']=0;
          in_array(6,$valores)?$_SESSION['correlativo']=1:$_SESSION['correlativo']=0;
          in_array(7,$valores)?$_SESSION['impuesto']=1:$_SESSION['impuesto']=0;
          in_array(8,$valores)?$_SESSION['impuestoz']=1:$_SESSION['impuestoz']=0;
          in_array(9,$valores)?$_SESSION['pais']=1:$_SESSION['pais']=0;
          in_array(10,$valores)?$_SESSION['moneda']=1:$_SESSION['moneda']=0;
              
          in_array(20,$valores)?$_SESSION['escritorio']=1:$_SESSION['escritorio']=0;
    
          in_array(40,$valores)?$_SESSION['inventario']=1:$_SESSION['inventario']=0;
          in_array(41,$valores)?$_SESSION['articulo']=1:$_SESSION['articulo']=0;
          in_array(42,$valores)?$_SESSION['categoria']=1:$_SESSION['categoria']=0;
          in_array(43,$valores)?$_SESSION['linea']=1:$_SESSION['linea']=0;
          in_array(44,$valores)?$_SESSION['unidad']=1:$_SESSION['unidad']=0;
          in_array(45,$valores)?$_SESSION['deposito']=1:$_SESSION['deposito']=0;
          in_array(50,$valores)?$_SESSION['opinventario']=1:$_SESSION['opinventario']=0;
          in_array(51,$valores)?$_SESSION['ajustei']=1:$_SESSION['ajustei']=0;
          in_array(52,$valores)?$_SESSION['traslado']=1:$_SESSION['traslado']=0;
          in_array(53,$valores)?$_SESSION['ajustep']=1:$_SESSION['ajustep']=0;
          in_array(58,$valores)?$_SESSION['rinventario']=1:$_SESSION['rinventario']=0;
            
          in_array(60,$valores)?$_SESSION['compras']=1:$_SESSION['compras']=0;
          in_array(61,$valores)?$_SESSION['proveedor']=1:$_SESSION['proveedor']=0;
          in_array(62,$valores)?$_SESSION['tipoproveedor']=1:$_SESSION['tipoproveedor']=0;
          in_array(64,$valores)?$_SESSION['condpago']=1:$_SESSION['condpago']=0;
          in_array(66,$valores)?$_SESSION['zona']=1:$_SESSION['zona']=0;
          in_array(70,$valores)?$_SESSION['opcompras']=1:$_SESSION['opcompras']=0;
          in_array(71,$valores)?$_SESSION['comprac']=1:$_SESSION['comprac']=0;
          in_array(72,$valores)?$_SESSION['comprap']=1:$_SESSION['comprap']=0;
          in_array(73,$valores)?$_SESSION['compraf']=1:$_SESSION['compraf']=0;
          in_array(74,$valores)?$_SESSION['comprasr']=1:$_SESSION['comprasr']=0;
          in_array(75,$valores)?$_SESSION['pago']=1:$_SESSION['pago']=0;
          in_array(76,$valores)?$_SESSION['documentoc']=1:$_SESSION['documentoc']=0;
  
          in_array(80,$valores)?$_SESSION['ventas']=1:$_SESSION['ventas']=0;
          in_array(81,$valores)?$_SESSION['cliente']=1:$_SESSION['cliente']=0;
          in_array(82,$valores)?$_SESSION['tipocliente']=1:$_SESSION['tipocliente']=0;
          in_array(83,$valores)?$_SESSION['tipoprecio']=1:$_SESSION['tipoprecio']=0;
          in_array(84,$valores)?$_SESSION['vendedor']=1:$_SESSION['vendedor']=0;
          in_array(85,$valores)?$_SESSION['turnopv']=1:$_SESSION['turnopv']=0;
          in_array(86,$valores)?$_SESSION['condpago']=1:$_SESSION['condpago']=0;	
          in_array(87,$valores)?$_SESSION['zona']=1:$_SESSION['zona']=0;	
          in_array(90,$valores)?$_SESSION['opventas']=1:$_SESSION['opventas']=0;
          in_array(91,$valores)?$_SESSION['ventac']=1:$_SESSION['ventac']=0;
          in_array(92,$valores)?$_SESSION['ventap']=1:$_SESSION['ventap']=0;
          in_array(93,$valores)?$_SESSION['ventaf']=1:$_SESSION['ventaf']=0;
          in_array(94,$valores)?$_SESSION['ventasr']=1:$_SESSION['ventasr']=0;
          in_array(95,$valores)?$_SESSION['cobro']=1:$_SESSION['cobro']=0;
          in_array(96,$valores)?$_SESSION['documentov']=1:$_SESSION['documentov']=0;
          in_array(97,$valores)?$_SESSION['tpventa']=1:$_SESSION['tpventa']=0;
            
          in_array(100,$valores)?$_SESSION['bancos']=1:$_SESSION['bancos']=0;
          in_array(101,$valores)?$_SESSION['bancop']=1:$_SESSION['bancop']=0;
          in_array(102,$valores)?$_SESSION['caja']=1:$_SESSION['caja']=0;
          in_array(103,$valores)?$_SESSION['cuenta']=1:$_SESSION['cuenta']=0;
          in_array(104,$valores)?$_SESSION['ipago']=1:$_SESSION['ipago']=0;	
          in_array(105,$valores)?$_SESSION['beneficiario']=1:$_SESSION['beneficiario']=0;
          in_array(110,$valores)?$_SESSION['opbancos']=1:$_SESSION['opbancos']=0;
          in_array(111,$valores)?$_SESSION['movcaja']=1:$_SESSION['movcaja']=0;
          in_array(112,$valores)?$_SESSION['movbanco']=1:$_SESSION['movbanco']=0;
          in_array(113,$valores)?$_SESSION['depbanco']=1:$_SESSION['depbanco']=0;
          in_array(114,$valores)?$_SESSION['odpago']=1:$_SESSION['odpago']=0;
          in_array(117,$valores)?$_SESSION['conciliacion']=1:$_SESSION['conciliacion']=0;
          in_array(119,$valores)?$_SESSION['rbanco']=1:$_SESSION['rbanco']=0;			

          $arrRspta=array("status"=>true,"msg"=>"Bienvenido ".base64_decode($_SESSION['sdesc_usuario'])."!","icon"=>"success");

         } else {
           $arrRspta=array("status"=>false,"msg"=>"Usuario o Clave Incorrecta!","icon"=>"error");
           session_unset();
           session_destroy();
         }          
       } else {
         $arrRspta=array("status"=>false,"msg"=>"No Es Posible Iniciar Sesion<br>\n
         El Usuario de encuentra <b>Inactivo</b>!","icon"=>"info");
         session_unset();
         session_destroy();
       }
    }   
    echo json_encode($arrRspta,JSON_UNESCAPED_UNICODE);
  } 

  public function SessionOut(){
      session_unset();//Destruìmos la sesión
      $_SESSION = array(); // Destroy the variables 
      unset($_SESSION);
      session_destroy(); // Destroy the session 
      setcookie('PHPSESSID', ", time()-3600,'/', ", 0, 0);//Destroy the cookie 
      header("Location:".base_URL()."Login");
  }

  public function ActualizarClave(){
    if (isset($_POST['idusuario'])) {
      $idusuario=intval(limpiarCadena($_POST['idusuario']));
      $clave=hashpw($_POST['clave']);
  
        $request=$this->model->EditarClave($idusuario,$clave);
        if($request){
          $arrRspta=array("status"=>true,"msg"=>"Clave Actualizada Exitosamente!");
        }else {
          $arrRspta=array("status"=>false,"msg"=>"Error al Actualizar la Clave!");
        }
        echo json_encode($arrRspta,JSON_UNESCAPED_UNICODE);
      } else{
        header("Location:".base_URL()."Error404");
      }
  }

  


  
}