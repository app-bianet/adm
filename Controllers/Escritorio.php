<?php

class Escritorio extends Controllers{

  public function __construct(){
    session_start();
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