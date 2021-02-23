<?php
  require_once 'Config/Master.php';
  require_once 'Helpers/Helpers.php';

  $url = !empty($_GET['url'])? $_GET['url']:'Login/Login';
  $arrUrl = explode('/', $url);
  $controller = $arrUrl[0];
  $method = $arrUrl[0];
  $params = "";

  if (!empty($arrUrl[1])) {
    if ($arrUrl[1]!="") {
      $method = $arrUrl[1];
    }
  }

  if (!empty($arrUrl[2])) {
    if ($arrUrl[2]!="") {
      for ($i=2; $i < count($arrUrl) ; $i++) {
        $params .=$arrUrl[$i].',';
      }
      $params = trim($params, ',');
    }
  }

  ini_set("error_log", "../Bianet/php-error.log");

  require_once 'Core/Autoload.php';
  require_once 'Core/Load.php';
