<?php

class Escritorio extends Controllers{

  public function __construct(){
    parent::__construct();
  }

  public function escritorio(){
    ob_start();
    session_start();
    if (!isset($_SESSION["sidusuario"])){
      header("Location:".base_URL()."login");
    } else {
      if ($_SESSION['escritorio']==1){
        $data['page_tag']="Escritorio";
        $data['page_title']=".:: Escritorio ::.";
        $data['page_name']="escritorio";
        $data['func']="functions_escritorio.js";
        $this->views->getView($this,"escritorio",$data);
      } else {
        header("Location:".base_URL()."error403");
      }
    }
    ob_end_flush();
  }

  
}