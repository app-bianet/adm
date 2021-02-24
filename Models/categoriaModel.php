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
      try {
        $sql="SELECT idcategoria, cod_categoria, desc_categoria, estatus FROM tbcategoria";
        $req=$this->SelectAll($sql);
        return $req;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function ListDt(){
      try {
        $sql="SELECT idcategoria, cod_categoria, desc_categoria, estatus 
        FROM tbcategoria WHERE estatus='1' ORDER BY cod_categoria ASC";
        $req=$this->SelectAll($sql);
        return $req;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function ShowDt($id){
      $this->Idcategoria=$id;
      try {
        $sql="SELECT idcategoria, cod_categoria, desc_categoria, estatus 
        FROM tbcategoria WHERE idcategoria= $this->Idcategoria";
        $req=$this->Select($sql);
        return $req;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function EstatusDt($id,$st){
      $this->Idcategoria=$id;
      $this->Estatus=$st;
      try {
        $sql="UPDATE tbcategoria SET estatus=? WHERE idcategoria='$this->Idcategoria'";
        $arrData=array($this->Estatus);
        $request=$this->Update($sql,$arrData);
        return $request;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function InsertDt($cod_categoria,$desc_categoria){
      $this->Cod_categoria=$cod_categoria;
      $this->Desc_categoria=$desc_categoria;
      $this->Estatus='1';
      try{  
        $queryInsert="INSERT INTO tbcategoria(cod_categoria, desc_categoria,estatus) VALUES(?,?,?)";
        $arrData=array($this->Cod_categoria,$this->Desc_categoria,$this->Estatus);
        $request = $this->Insert($queryInsert,$arrData);
        return $request;
      } catch(PDOException $e){
        return PDOError($e,'insert');
      }
    }

    public function EditarDt($id, $cod_categoria, $desc_categoria){
      $this->Idcategoria=$id;
      $this->Cod_categoria=$cod_categoria;
      $this->Desc_categoria=$desc_categoria;
      try{  
        $sql="UPDATE tbcategoria SET cod_categoria=?,desc_categoria=? WHERE idcategoria='$this->Idcategoria'";
        $arrData=array($this->Cod_categoria,$this->Desc_categoria);
        $request = $this->Update($sql,$arrData);
        return $request;
      } catch(PDOException $e){
        return PDOError($e,'update');
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
        return PDOError($e,'delete');
      }
    }

  }