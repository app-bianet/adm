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
      $sql="SELECT * FROM tbzona";
      $req=$this->SelectAll($sql);
      return $req;
    }

    public function ListDt(){
      $sql="SELECT * FROM tbzona WHERE estatus='1' ORDER BY cod_zona ASC";
      $req=$this->SelectAll($sql);
      return $req;
    }

    public function ShowDt($id){
      $this->Idzona=$id;
      $sql="SELECT * 
      FROM tbzona
      WHERE idzona='$this->Idzona'";
      $req=$this->Select($sql);
      return $req;
    }
   
    public function EstatusDt($id,$st){
      $this->Idzona=$id;
      $this->Estatus=$st;
      $sql="UPDATE tbzona SET estatus=? WHERE idzona='$this->Idzona'";
      $arrData=array($this->Estatus);
      $request=$this->Update($sql,$arrData);
      return $request;
    }

    public function InsertDt($cod_zona,$desc_zona){
      $this->Cod_zona=$cod_zona;
      $this->Desc_zona=$desc_zona;
      $this->Estatus='1';
      try{  
        $queryInsert="INSERT INTO tbzona(cod_zona, desc_zona,estatus) VALUES(?,?,?)";
        $arrData=array($this->Cod_zona,$this->Desc_zona,$this->Estatus);
        $this->Insert($queryInsert,$arrData);
        return true;
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
        $this->Update($sql,$arrData);
        return true;
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