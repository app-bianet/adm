<?php
class Views{
  function getView($controller,$view,$data=""){
    $controller = get_class($controller);
    if ($controller == "") {
      $view = 'Views/'.$view.".php";
    } else {
      $view = "Views/".$view.".php";
    }
    require_once($view);   
  } 
} 