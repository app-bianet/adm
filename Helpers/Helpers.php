<?php

function base_URL(){
  return URL;
}

function libs(){
  return URL."Assets";
}

function images(){
  return URL."/Files/images/";
}

function Models(){

  return URL."/Models/";
}

function scripts_app(){
  return URL."/Assets/scripts/";
}
 
function dep($data){
  $format =print_r('<pre>');
  $format .=print_r($data);
  $format .=print_r('</pre>');
  return $format;
}

function headerAdmin($data=""){
  $view_header = 'Views/Templates/header_admin.php';
  require_once $view_header;
}

function footerAdmin($data=""){
  $view_footer='Views/Templates/footer_admin.php';
  require_once $view_footer;
}

function getModal($name, $data="")
{
  $view_modal="Views/TemplateModal/".$name.".php";
  require_once $view_modal;
}

function limpiarCadena($strCadena){
  $string=preg_replace(['/\s+/','/^\s|\s$/'],[' ',''],$strCadena);
  $string=trim($strCadena);
  $string=str_ireplace(' ', '',$strCadena);
  $string=stripslashes($strCadena);
  $string=str_ireplace("<script>","",$string);
  $string=str_ireplace("</script>","",$string);
  $string=str_ireplace("<script src>","",$string);
  $string=str_ireplace("<script type=>","",$string);
  $string=str_ireplace("SELECT * FROM","",$string);
  $string=str_ireplace("INSERT INTO","",$string);
  $string=str_ireplace("DELETE FROM","",$string);
  $string=str_ireplace("SELECT COUNT(*) FROM","",$string);
  $string=str_ireplace("DROP TABLE","",$string);
  $string=str_ireplace("OR '1'='1'","",$string);
  $string=str_ireplace('OR "1"="1"',"",$string);
  $string=str_ireplace('OR ´1´=´1´',"",$string);
  $string=str_ireplace("is NULL; --","",$string);
  $string=str_ireplace('is NULL; --',"",$string);
  $string=str_ireplace('IFNULL; --',"",$string);
  $string=str_ireplace("IFNULL; --","",$string);
  $string=str_ireplace('LIKE "',"",$string);
  $string=str_ireplace("LIKE '","",$string);
  $string=str_ireplace("LIKE ´","",$string);
  $string=str_ireplace("OR 'a'='a","",$string);
  $string=str_ireplace('OR "a"="a',"",$string);
  $string=str_ireplace("OR ´a´=´a","",$string);
  $string=str_ireplace("OR ´a´=´a","",$string);
  $string=str_ireplace("--","",$string);
  $string=str_ireplace("^","",$string); 
  $string=str_ireplace("[","",$string);
  $string=str_ireplace("]","",$string);
  $string=str_ireplace("==","",$string); 
  return $string; 
}

function cortar_cadena($texto, $largo = 10, $puntos = "...") { 
  $palabras = explode(' ', $texto); 
  if (count($palabras) > $largo) { 
    return implode(' ', array_slice($palabras, 0, $largo)) ." ". $puntos; 
  } else {
    return $texto; 
  } 
} 

function POSTT($str){
  $srtData=isset($str)? limpiarCadena($str):"";
  return $srtData;
}

function passGenerator($length =10){
  $pass="";
  $longitudPass=$length;
  $cadena="ABCDEFGHIJKLMNOPQRSTUVWXYZ@*#abcdefghijklmnopqrstuvwxyz1234567890";
  $longitudCadena=strlen($cadena);

  for ($i=1; $i<=$longitudPass; $i++) { 
    $pos=rand(0,$longitudCadena-1);
    $pass=substr($cadena,$pos,10);
  }
  return $pass;
}

function token(){
  $r1=bin2hex(random_bytes(10));
  $r2=bin2hex(random_bytes(10));
  $r3=bin2hex(random_bytes(10));
  $r4=bin2hex(random_bytes(10));
  $token=$r1.'-'.$r2.'-'.$r3.'-'.$r4;
  return $token;
}

function formatMoney($cantidad){
  $cantidad=number_format($cantidad,2,SPD,SPM);
  return $cantidad;
}

function insertNumber($cantidad){
  $str=str_replace(',','',$cantidad);
  return $str;
}

function formatMoneyP($cantidad,$palces){
  $cantidad=number_format($cantidad,$palces,SPD,SPM);
  return $cantidad;
}

function formatStock($cantidad){
  $cantidad=number_format($cantidad,0);
  return $cantidad;
}

/** 
* Funcion para convertir Fecha a formato MYSQL
*
* Fecha en formato dd/mm/yyy
* retorna en formato yyyy/mm/dd
* --
* @author: Ricardo Albornoz
* @return string : Fecha en Formato MYSQL
*/
function formatDate($dateCadena){
  $dateRec=str_ireplace('/','-',$dateCadena);
  $fecha = $dateRec; //Recibe una string en formato dd-mm-yyyy 
	$toTimeFormat = strtotime($fecha); //Convierte el string a formato de fecha en php
  $fechaRetorno = date('Y-m-d',$toTimeFormat); //Lo comvierte a formato de fecha en MySQL
  return $fechaRetorno;
}

function formatDateRt($fechart){
  $fecha = new DateTime($fechart);
  $fecha_d_m_y = $fecha->format('d/m/Y');
  return $fecha_d_m_y;
}

function SubirImagen($imagen,$item,$ruta){
	$ext = explode(".", $imagen.["name"]);

	$imagen.['tmp_name']==$ruta.$item.'.'.end($ext)?
    unlink($ruta.$item.'.'.end($ext)):''; 

	if ($imagen.['type'] == "image/jpg" || $imagen.['type'] == "image/jpeg" || $imagen.['type'] == "image/png"){
		$imagen = $item.'.'.end($ext);
		move_uploaded_file($imagen.["tmp_name"], $ruta.$imagen);
	}
}

function FechaActual(){
  $mes=array("","Enero","Febrero","Marzo","Abril","Mayo",
  "Junio","Julio","Agosto","Septiempre","Octubre","Noviembre","Diciembre");
  return date('d').' de '.$mes[date('n')].' de '.date('Y');
}

function hashpw($password){
  return password_hash($password, PASSWORD_DEFAULT, ['cost' =>5]);
}


function verifypw($password, $hash) {
  return password_verify($password, $hash);
}

/** 
* Funcion para Capturar Errores en PDO

* Se Recibe el Codigo de Error y Retornamos
* la vartiable correspondiente
* Se retorna solo los Siguientes Errores:
*1451: Registros Relacionados
*1062: Valores Duplicados
*1054: Campo Desconocido/Invalido

* @author: Ricardo Albornoz
* @param mixed $error_get: Código de Error PDO:getCode()
* @param mixed $tipo: Tipo de Operacion Realizada:update/insert/delete
* @return string : relacion/duplicado/desconocido/
*/
function PDOError($error_get,$tipo){
  //CAPTURA EL MENSAJE
  switch ($error_get->getCode()) {
    case 23000:
      //SELECCION AL MENSAJE PARA VERIFICAR EN ERROR
      $serror= $error_get->getMessage();
      $array_error= explode(" ", $serror);

      // VERIFICA EL EL AREGLO (ARRAY getMessage()) EL CODIGO ENCONTRADO
      if (in_array("1451",$array_error)){
          return 'relacion';//Registros Relacionados
      } 
      else if (in_array("1062",$array_error)){
        return 'duplicado';//Valores Duplicados
      } 
      else if (in_array("1054",$array_error)){
        return 'desconocido';//Campo desconocido
      } 
      else {
        if ($tipo=='insert') {
          return "Error Insertando Registros!";
        } else if ($tipo=='update') {
          return "Error Editando Registros!";
        } else if ($tipo=='delete') {
          return "Error Eliminado Registros!";
        } else {
          return "Error Procesando el Registro!";
        }
      } 
    default:
    if ($tipo=='insert') {
      return "Error Insertando Registros!";
    } else if ($tipo=='update') {
      return "Error Editando Registros!";
    } else if ($tipo=='delete') {
      return "Error Eliminado Registros!";
    } else {
      return "Error Procesando el Registro!";
    }
  }
}

function GenerarVariables(){

  $valiables=array( 
    'idmovcaja',
    'idcaja',
    'idbanco',
    'idoperacion',
    'idusuario',
    'cod_movcaja',
    'desc_movcaja',
    'estatus',
    'tipo',
    'forma',
    'numerod',
    'numeroc',
    'origen',
    'montod',
    'montoh',
    'saldoinicial',
    'fechareg',
    'fechadb'
  );

  $valiables2=array(
    'idmovcaja',
    'idcaja',
    'idbanco',
    'idoperacion',
    'idusuario',
    'cod_movcaja',
    'desc_movcaja',
    'estatus',
    'tipo',
    'forma',
    'numerod',
    'numeroc',
    'origen',
    'montod',
    'montoh',
    'saldoinicial',
    'fechareg',
    'fechadb'
  );

  for ($i=0; $i<count($valiables);$i++) { 
    dep($valiables[$i]='$this->'.ucfirst(strtolower($valiables[$i])).'=$'.$valiables[$i].';');
  }

  for ($i=0; $i<count($valiables2);$i++) { 
    dep($valiables2[$i]='$this->'.ucfirst(strtolower($valiables2[$i])).';');
  }
}

//GenerarVariables();

