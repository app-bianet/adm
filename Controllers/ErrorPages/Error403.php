<?php
class Error403 extends Controllers{

  public function __construct(){
    parent::__construct();
  }

  public function NoAcceso(){
    $this->views->getView($this,'ErrPages/error403');
  }
}

$forbidden= new Error403();
$forbidden->NoAcceso();



