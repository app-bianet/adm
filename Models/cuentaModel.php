<?php
  class cuentaModel extends MySql{

    private $Idcuenta;
    private $Cod_cuenta;
    private $Desc_cuenta;
    private $Estatus;

    public function __construct(){
      parent::__construct();
    }

    public function SelectDt(){
      $sql="SELECT * FROM tbcuenta";
      $req=$this->SelectAll($sql);
      return $req;
    }

    public function ListDt(){
      $sql="SELECT * FROM tbcuenta WHERE estatus='1' ORDER BY cod_cuenta ASC";
      $req=$this->SelectAll($sql);
      return $req;
    }

    public function ShowDt($id){
      $this->Idcuenta=$id;
      $sql="SELECT * 
      FROM tbcuenta
      WHERE idcuenta='$this->Idcuenta'";
      $req=$this->Select($sql);
      return $req;
    }
   
    public function EstatusDt($id,$st){
      $this->Idcuenta=$id;
      $this->Estatus=$st;
      $sql="UPDATE tbcuenta SET estatus=? WHERE idcuenta='$this->Idcuenta'";
      $arrData=array($this->Estatus);
      $request=$this->Update($sql,$arrData);
      return $request;
    }

    public function InsertDt($cod_cuenta,$desc_cuenta){
      $this->Cod_cuenta=$cod_cuenta;
      $this->Desc_cuenta=$desc_cuenta;
      $this->Estatus='1';
      try{  
        $queryInsert="INSERT INTO tbcuenta(cod_cuenta, desc_cuenta,estatus) VALUES(?,?,?)";
        $arrData=array($this->Cod_cuenta,$this->Desc_cuenta,$this->Estatus);
        $this->Insert($queryInsert,$arrData);
        return true;
      } catch(PDOException $e){
        return PDOError($e,'insert');
      }
    }

    public function EditarDt($id, $cod_cuenta, $desc_cuenta){
      $this->Idcuenta=$id;
      $this->Cod_cuenta=$cod_cuenta;
      $this->Desc_cuenta=$desc_cuenta;
      try{  
        $sql="UPDATE tbcuenta SET cod_cuenta=?,desc_cuenta=? WHERE idcuenta='$this->Idcuenta'";
        $arrData=array($this->Cod_cuenta,$this->Desc_cuenta);
        $this->Update($sql,$arrData);
        return true;
      } catch(PDOException $e){
        return PDOError($e,'update');
      }
    }

    public function EliminarDt($id){
      $returnData = "";
      $this->Idcuenta=$id;
      try {
        $sql="DELETE FROM tbcuenta WHERE idcuenta = '$this->Idcuenta'";
        $arrData=array($this->Idcuenta);
        $returnData =$this->Delete($sql,$arrData);
        return $returnData;
      } catch (PDOException $e) {
        return PDOError($e,'delete');
      }   
    }
  }