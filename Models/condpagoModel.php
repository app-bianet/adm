<?php
  class condpagoModel extends MySql{
    private $Idcondpago;
    private $Cod_condpago;
    private $Desc_condpago;
    private $Dias;
    private $Estatus;

    public function __construct(){
      parent::__construct();
    }

    public function SelectDt(){
      try {
        $sql="SELECT idcondpago, cod_condpago, desc_condpago, dias, estatus FROM tbcondpago";
        $req=$this->SelectAll($sql);
        return $req;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function ListDt(){
      try {
        $sql="SELECT idcondpago, cod_condpago, desc_condpago, dias, estatus 
        FROM tbcondpago WHERE estatus='1' ORDER BY dias ASC";
        $req=$this->SelectAll($sql);
        return $req;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function ShowDt($id){
      $this->Idcondpago=$id;
      try {
        $sql="SELECT idcondpago, cod_condpago, desc_condpago, dias, estatus 
        FROM tbcondpago WHERE idcondpago= $this->Idcondpago";
        $req=$this->Select($sql);
        return $req;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function EstatusDt($id,$st){
      $this->Idcondpago=$id;
      $this->Estatus=$st;
      try {
        $sql="UPDATE tbcondpago SET estatus=? WHERE idcondpago='$this->Idcondpago'";
        $arrData=array($this->Estatus);
        $request = $this->Update($sql,$arrData);
        return $request;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function InsertDt($cod_condpago,$desc_condpago,$dias){
      $this->Cod_condpago=$cod_condpago;
      $this->Desc_condpago=$desc_condpago;
      $this->Dias=$dias;
      $this->Estatus='1';
      try{  
        $queryInsert="INSERT INTO tbcondpago(cod_condpago, desc_condpago,dias,estatus) VALUES(?,?,?,?)";
        $arrData=array($this->Cod_condpago,$this->Desc_condpago,$this->Dias,$this->Estatus);
        $request = $this->Insert($queryInsert,$arrData);
        return $request;
      } catch(PDOException $e){
        return PDOError($e,'insert');
      }
    }

    public function EditarDt($id, $cod_condpago, $desc_condpago,$dias){
      $this->Idcondpago=$id;
      $this->Cod_condpago=$cod_condpago;
      $this->Desc_condpago=$desc_condpago;
      $this->Dias=$dias;
      try{  
        $sql="UPDATE tbcondpago SET cod_condpago=?,desc_condpago=?,dias=? WHERE idcondpago='$this->Idcondpago'";
        $arrData=array($this->Cod_condpago,$this->Desc_condpago,$this->Dias);
        $request = $this->Update($sql,$arrData);
        return $request;
      } catch(PDOException $e){
        return PDOError($e,'update');
      }
    }

    public function EliminarDt($id){
      $returnData = "";
      $this->Idcondpago=$id;
      try {
        $sql="DELETE FROM tbcondpago WHERE idcondpago = '$this->Idcondpago'";
        $arrData=array($this->Idcondpago);
        $returnData =$this->Delete($sql,$arrData);
        return $returnData;
      } catch (PDOException $e) {
        return PDOError($e,'delete');
      }
    }
  }