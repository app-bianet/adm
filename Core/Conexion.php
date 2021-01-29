<?php
 class Conexion{
 
  private $conexion;

  public function __construct(){
    $conectionString="mysql:host=".APP_HOST.";dbname=".APP_DATABASE.";.APP_CHARSET.";
    try {
      $this->conexion= new PDO($conectionString,APP_USER,APP_PASSWORD);
      $this->conexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    } catch (PDOException $e) {
      echo dep($e->getMessage());
    }
  }

  public function Con(){   
    return $this->conexion;
  }



}