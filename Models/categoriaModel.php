<?php
  class categoriaModel extends MySql{
    private $Idcategoria;
    private $Cod_categoria;
    private $Desc_categoria;
    private $Estatus;

    public function __construct(){
      parent::__construct();
    }

    public function SelectDt(){
      $sql="SELECT * FROM tbcategoria";
      $req=$this->SelectAll($sql);
      return $req;
    }

    public function ListDt(){
      $sql="SELECT * FROM tbcategoria WHERE estatus='1' ORDER BY cod_categoria ASC";
      $req=$this->SelectAll($sql);
      return $req;
    }

    public function ShowDt($id){
      $this->Idcategoria=$id;
      $sql="SELECT * 
      FROM tbcategoria
      WHERE idcategoria= $this->Idcategoria";
      $req=$this->Select($sql);
      return $req;
    }

    public function EstatusDt($id,$st){
      $this->Idcategoria=$id;
      $this->Estatus=$st;

      $sql="UPDATE tbcategoria SET estatus=? WHERE idcategoria='$this->Idcategoria'";
      $arrData=array($this->Estatus);
      $request=$this->Update($sql,$arrData);
      return $request;
    }

    public function InsertDt($cod_categoria,$desc_categoria){
      $this->Cod_categoria=$cod_categoria;
      $this->Desc_categoria=$desc_categoria;
      $this->Estatus='1';

      try{  
        $queryInsert="INSERT INTO tbcategoria(cod_categoria, desc_categoria,estatus) VALUES(?,?,?)";
        $arrData=array($this->Cod_categoria,$this->Desc_categoria,$this->Estatus);
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

    public function EditarDt($id, $cod_categoria, $desc_categoria){
      $this->Idcategoria=$id;
      $this->Cod_categoria=$cod_categoria;
      $this->Desc_categoria=$desc_categoria;
      try{  
        $sql="UPDATE tbcategoria SET cod_categoria=?,desc_categoria=? WHERE idcategoria='$this->Idcategoria'";
        $arrData=array($this->Cod_categoria,$this->Desc_categoria);
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
      $this->Idcategoria=$id;

      try {
        $sql="DELETE FROM tbcategoria WHERE idcategoria = '$this->Idcategoria'";
        $arrData=array($this->Idcategoria);
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