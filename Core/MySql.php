<?php
 class MySql extends Conexion{
    private $conexion;
    private $stringQuery;
    private $arrValues;

  function __construct(){
    parent::__construct();
    // Línea a agregar

    $this->conexion = new Conexion();
    $this->conexion = $this->conexion->Con();  
   // $this->UMConnector = new model();
    //$this->UMConnector = $this->model->connector()
  }

  public function SelectAll(string $query){
    $this->stringQuery = $query;
    $result = $this->conexion->prepare($this->stringQuery);
    $result->execute();
    $data = $result->fetchall(PDO::FETCH_ASSOC);
    return $data;
  }

  public function Select(string $query){
    $this->stringQuery = $query;
    $result = $this->conexion->prepare($this->stringQuery);
    $result->execute();
    $data = $result->fetch(PDO::FETCH_ASSOC);
    return $data;
  }

  public function Insert(string $query, array $arrValue){
    $this->stringQuery=$query;
    $this->arrValues=$arrValue;
    $insert=$this->conexion->prepare($this->stringQuery);
    $rsptaInsert=$insert->execute($this->arrValues);
    if($rsptaInsert){
      $lastInsert=$this->conexion->lastInsertId();
    }else {
      $lastInsert=0;
    }
    return $lastInsert;
  }

  public function Update(string $query,array $arrValue){
    $this->stringQuery=$query;
    $this->arrValues=$arrValue;
    $update=$this->conexion->prepare($this->stringQuery);
    $rsptaUpdate=$update->execute($this->arrValues);
    return $rsptaUpdate;
  }

  public function Delete(string $query){
    $this->stringQuery=$query;
    $result=$this->conexion->prepare($this->stringQuery);
    $result->execute();

    if($result->rowCount() > 0){
      return  $result -> rowCount();
    } else {
      return ($result->errorCode()); 
    }
  }

}