<?php
  class movbancoModel extends MySql{

    private $Idmovbanco;
    private $Cod_movbanco;
    private $Desc_movbanco;
    private $Estatus;

    public function __construct(){
      parent::__construct();
    }

    public function SelectDt(){
      try {
        $sql="SELECT idmovbanco, cod_movbanco, desc_movbanco, estatus FROM tbmovbanco";
        $req=$this->SelectAll($sql);
        return $req;
      } catch(PDOException $e){
        return PDOError($e,'');
      }
    }

    public function ListDt(){
      try {
        $sql="SELECT idmovbanco, cod_movbanco, desc_movbanco, estatus FROM tbmovbanco WHERE estatus='1' ORDER BY cod_movbanco ASC";
        $req=$this->SelectAll($sql);
        return $req;
      } catch(PDOException $e){
        return PDOError($e,'');
      }
    }

    public function ShowDt($id){
      try {
        $this->Idmovbanco=$id;
        $sql="SELECT idmovbanco, cod_movbanco, desc_movbanco, estatus  
        FROM tbmovbanco
        WHERE idmovbanco='$this->Idmovbanco'";
        $req=$this->Select($sql);
        return $req;
      } catch(PDOException $e){
        return PDOError($e,'');
      }
    }
   
    public function EstatusDt($id,$st){
      try{
        $this->Idmovbanco=$id;
        $this->Estatus=$st;
        $sql="UPDATE tbmovbanco SET estatus=? WHERE idmovbanco='$this->Idmovbanco'";
        $arrData=array($this->Estatus);
        $request=$this->Update($sql,$arrData);
        return $request;
      } catch(PDOException $e){
        return PDOError($e,'');
      }
    }

    public function InsertDt($cod_movbanco,$desc_movbanco){
      $this->Cod_movbanco=$cod_movbanco;
      $this->Desc_movbanco=$desc_movbanco;
      $this->Estatus='1';
      try{  
        $queryInsert="INSERT INTO tbmovbanco(cod_movbanco, desc_movbanco,estatus) VALUES(?,?,?)";
        $arrData=array($this->Cod_movbanco,$this->Desc_movbanco,$this->Estatus);
        $request=$this->Insert($queryInsert,$arrData);
        return $request;
      } catch(PDOException $e){
        return PDOError($e,'insert');
      }
    }

    public function EditarDt($id, $cod_movbanco, $desc_movbanco){
      $this->Idmovbanco=$id;
      $this->Cod_movbanco=$cod_movbanco;
      $this->Desc_movbanco=$desc_movbanco;
      try{  
        $sql="UPDATE tbmovbanco SET cod_movbanco=?,desc_movbanco=? WHERE idmovbanco='$this->Idmovbanco'";
        $arrData=array($this->Cod_movbanco,$this->Desc_movbanco);
        $request=$this->Update($sql,$arrData);
        return $request;
      } catch(PDOException $e){
        return PDOError($e,'update');                                                                                                                                                                                                                        
      }
    }

    public function EliminarDt($id){
      $returnData = "";
      $this->Idmovbanco=$id;
      try {
        $sql="DELETE FROM tbmovbanco WHERE idmovbanco = '$this->Idmovbanco'";
        $arrData=array($this->Idmovbanco);
        $returnData =$this->Delete($sql,$arrData);
        return $returnData;
      } catch (PDOException $e) {
        return PDOError($e,'delete');
      }   
    }
  }