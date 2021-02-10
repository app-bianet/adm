<?php
  class ipagoModel extends MySql{

    private $Idipago;
    private $Cod_ipago;
    private $Desc_ipago;
    private $Comision;
    private $Recargo;
    private $Estatus;

    public function __construct(){
      parent::__construct();
    }

    public function SelectDt(){
      try{
        $sql="SELECT * FROM tbipago";
        $req=$this->SelectAll($sql);
        return $req;
      } catch (PDOException $e ) {
        return PDOError($e,'');
      }
    }

    public function ListDt(){
      try {
        $sql="SELECT * FROM tbipago WHERE estatus='1' ORDER BY cod_ipago ASC";
        $req=$this->SelectAll($sql);
        return $req;
      } catch (PDOException $e ) {
        return PDOError($e,'');
      }
    }

    public function ShowDt($id){
      $this->Idipago=$id;
      try {
        $sql="SELECT * 
        FROM tbipago
        WHERE idipago='$this->Idipago'";
        $req=$this->Select($sql);
        return $req;
      } catch (PDOException $e ) {
        return PDOError($e,'');
      }
    }
    
    public function EstatusDt($id,$st){
      $this->Idipago=$id;
      $this->Estatus=$st;
      try {
        $sql="UPDATE tbipago SET estatus=? WHERE idipago='$this->Idipago'";
        $arrData=array($this->Estatus);
        $request=$this->Update($sql,$arrData);
        return $request;
      } catch (PDOException $e ) {
        return PDOError($e,'');
      }
    }

    public function InsertDt($cod_ipago,$desc_ipago,$comision,$recargo){
      $this->Cod_ipago=$cod_ipago;
      $this->Desc_ipago=$desc_ipago;
      $this->Comision=$comision;
      $this->Recargo=$recargo;
      $this->Estatus='1';
      try{  
        $queryInsert="INSERT INTO tbipago(cod_ipago, desc_ipago,comision,recargo,estatus) VALUES(?,?,?,?,?)";
        $arrData=array($this->Cod_ipago,$this->Desc_ipago,$this->Comision,$this->Recargo,$this->Estatus);
        $this->Insert($queryInsert,$arrData);
        return true;
      } catch(PDOException $e){
        return PDOError($e,'insert');
      }
    }

    public function EditarDt($id, $cod_ipago,$desc_ipago,$comision,$recargo){
      $this->Idipago=$id;
      $this->Cod_ipago=$cod_ipago;
      $this->Desc_ipago=$desc_ipago;
      $this->Comision=$comision;
      $this->Recargo=$recargo;
      try{  
        $sql="UPDATE tbipago SET cod_ipago=?,desc_ipago=?,comision=?,recargo=? WHERE idipago='$this->Idipago'";
        $arrData=array($this->Cod_ipago,$this->Desc_ipago,$this->Comision,$this->Recargo);
        $this->Update($sql,$arrData);
        return true;
      } catch(PDOException $e){
        return PDOError($e,'update');
      }
    }

    public function EliminarDt($id){
      $returnData = "";
      $this->Idipago=$id;
      try {
        $sql="DELETE FROM tbipago WHERE idipago = '$this->Idipago'";
        $arrData=array($this->Idipago);
        $returnData =$this->Delete($sql,$arrData);
        return $returnData;
      } catch (PDOException $e) {
        return PDOError($e,'delete');
      }   
    }
  }