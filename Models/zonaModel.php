<?php
  class zonaModel extends MySql{

    private $Idzona;
    private $Cod_zona;
    private $Desc_zona;
    private $Estatus;

    public function __construct(){
      parent::__construct();
    }

    public function SelectDt(){
      try {
        $sql="SELECT idzona, cod_zona, desc_zona, estatus FROM tbzona";
        $req=$this->SelectAll($sql);
        return $req;
      } catch(PDOException $e){
        return PDOError($e,'');
      }
    }

    public function ListDt(){
      try {
        $sql="SELECT idzona, cod_zona, desc_zona, estatus FROM tbzona WHERE estatus='1' ORDER BY cod_zona ASC";
        $req=$this->SelectAll($sql);
        return $req;
      } catch(PDOException $e){
        return PDOError($e,'');
      }
    }

    public function ShowDt($id){
      try {
        $this->Idzona=$id;
        $sql="SELECT idzona, cod_zona, desc_zona, estatus  
        FROM tbzona
        WHERE idzona='$this->Idzona'";
        $req=$this->Select($sql);
        return $req;
      } catch(PDOException $e){
        return PDOError($e,'');
      }
    }
   
    public function EstatusDt($id,$st){
      try{
        $this->Idzona=$id;
        $this->Estatus=$st;
        $sql="UPDATE tbzona SET estatus=? WHERE idzona='$this->Idzona'";
        $arrData=array($this->Estatus);
        $request=$this->Update($sql,$arrData);
        return $request;
      } catch(PDOException $e){
        return PDOError($e,'');
      }
    }

    public function InsertDt($cod_zona,$desc_zona){
      $this->Cod_zona=$cod_zona;
      $this->Desc_zona=$desc_zona;
      $this->Estatus='1';
      try{  
        $queryInsert="INSERT INTO tbzona(cod_zona, desc_zona,estatus) VALUES(?,?,?)";
        $arrData=array($this->Cod_zona,$this->Desc_zona,$this->Estatus);
        $request=$this->Insert($queryInsert,$arrData);
        return $request;
      } catch(PDOException $e){
        return PDOError($e,'insert');
      }
    }

    public function EditarDt($id, $cod_zona, $desc_zona){
      $this->Idzona=$id;
      $this->Cod_zona=$cod_zona;
      $this->Desc_zona=$desc_zona;
      try{  
        $sql="UPDATE tbzona SET cod_zona=?,desc_zona=? WHERE idzona='$this->Idzona'";
        $arrData=array($this->Cod_zona,$this->Desc_zona);
        $request=$this->Update($sql,$arrData);
        return $request;
      } catch(PDOException $e){
        return PDOError($e,'update');                                                                                                                                                                                                                        
      }
    }

    public function EliminarDt($id){
      $returnData = "";
      $this->Idzona=$id;
      try {
        $sql="DELETE FROM tbzona WHERE idzona = '$this->Idzona'";
        $arrData=array($this->Idzona);
        $returnData =$this->Delete($sql,$arrData);
        return $returnData;
      } catch (PDOException $e) {
        return PDOError($e,'delete');
      }   
    }
  }