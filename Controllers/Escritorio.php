<?php
class Escritorio extends Controllers{

  public function __construct(){
    session_start();
    ob_start();
    if (!isset($_SESSION['sidusuario'])){
      header("Location:".base_URL()."login");
      session_unset();
      session_destroy();
    } else{
      if($_SESSION['escritorio']!=1)  {
        header("Location:".base_URL()."error403");
      } 
    }
    ob_end_flush();     
    parent::__construct();
  }

  public function escritorio(){
    $data['page_tag']="Escritorio";
    $data['page_title']=".:: Escritorio ::.";
    $data['page_name']="escritorio";
    $data['func']="functions_escritorio.js";
    $this->views->getView($this,"escritorio",$data);
  }

  
}