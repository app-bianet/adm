<?php
class Error404 extends Controllers{

  public function __construct(){
    parent::__construct();
  }

  public function NotFound(){
    $this->views->getView($this,'ErrPages/error404');
  }
}

$notfound= new Error404();
$notfound->NotFound();

