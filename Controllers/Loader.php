<?php
class Loader extends Controllers{

  public function __construct(){
    parent::__construct();
  }

  public function loader(){
    $this->views->getView($this,"loader");
  }
}
