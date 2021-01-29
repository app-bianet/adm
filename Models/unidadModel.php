<?php
  class unidadModel extends MySql{

    private $Idunidad;
    private $Cod_unidad;
    private $Desc_unidad;
    private $Estatus;

    public function __construct(){
      parent::__construct();
    }

    public function SelectDt(){
      $sql="SELECT idunidad, cod_unidad, desc_unidad, estatus FROM tbunidad";
      $req=$this->SelectAll($sql);
      return $req;
    }

    public function ListDt(){
      $sql="SELECT idunidad, cod_unidad, desc_unidad, estatus 
      FROM tbunidad WHERE estatus='1' ORDER BY cod_unidad ASC";
      $req=$this->SelectAll($sql);
      return $req;
    }

    public function ShowDt($id){
      $this->Idunidad=$id;
      $sql="SELECT idunidad, cod_unidad, desc_unidad, estatus
      FROM tbunidad
      WHERE idunidad='$this->Idunidad'";
      $req=$this->Select($sql);
      return $req;
    }

    public function EstatusDt($id,$st){
      $this->Idunidad=$id;
      $this->Estatus=$st;

      $sql="UPDATE tbunidad SET estatus=? WHERE idunidad='$this->Idunidad'";
      $arrData=array($this->Estatus);
      $request=$this->Update($sql,$arrData);
      return $request;
    }

    public function InsertDt($cod_unidad,$desc_unidad){
      $this->Cod_unidad=$cod_unidad;
      $this->Desc_unidad=$desc_unidad;
      $this->Estatus='1';

      try{  
        $queryInsert="INSERT INTO tbunidad(cod_unidad, desc_unidad,estatus) VALUES(?,?,?)";
        $arrData=array($this->Cod_unidad,$this->Desc_unidad,$this->Estatus);
        $this->Insert($queryInsert,$arrData);
        return true;
      } catch(PDOException $e){
        if($e->getCode()=='23000'){
          return 'duplicado';
        } else {
          return 'error_insert';
        }
      }
    }

    public function EditarDt($id, $cod_unidad, $desc_unidad){
      $this->Idunidad=$id;
      $this->Cod_unidad=$cod_unidad;
      $this->Desc_unidad=$desc_unidad;
      try{  
        $sql="UPDATE tbunidad SET cod_unidad=?,desc_unidad=? WHERE idunidad='$this->Idunidad'";
        $arrData=array($this->Cod_unidad,$this->Desc_unidad);
        $this->Update($sql,$arrData);
        return true;
      } catch(PDOException $e){
        if($e->getCode()=='23000'){
          return 'duplicado';
        } else {
          return 'error_update';
        }
      }
    }

    public function EliminarDt($id){
      $returnData = "";
      $this->Idunidad=$id;

      try {
        $sql="DELETE FROM tbunidad WHERE idunidad = '$this->Idunidad'";
        $arrData=array($this->Idunidad);
        $returnData =$this->Delete($sql,$arrData);
        return $returnData;
      } catch (PDOException $e) {
        if($e->getCode()=='23000'){
          return 'duplicado';
        } else {
          return 'error_delete';
        }
      }
    }

  }