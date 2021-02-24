<?php
  class monedaModel extends MySql{

    private $Idmoneda;
    private $Cod_moneda;
    private $Desc_moneda;
    private $Simbolo;
    private $Factor;
    private $Base;
    private $Estatus;

    public function __construct(){
      parent::__construct();
    }

    public function SelectDt(){
      try {
        $sql="SELECT idmoneda,cod_moneda,desc_moneda,simbolo,factor,base,estatus FROM tbmoneda";
        $req=$this->SelectAll($sql);
        return $req;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function ListDt(){
      try {
        $sql="SELECT idmoneda,cod_moneda,desc_moneda,simbolo,factor,base,estatus 
        FROM tbmoneda WHERE estatus='1' ORDER BY cod_moneda ASC";
        $req=$this->SelectAll($sql);
        return $req;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function ListDtBase(){
      try {
        $sql="SELECT idmoneda,cod_moneda,desc_moneda,simbolo,factor,base,estatus 
        FROM tbmoneda WHERE base='1'";
        $req=$this->Select($sql);
        return $req;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function ShowDt($id){
      $this->Idmoneda=$id;
      try {
        $sql="SELECT idmoneda,cod_moneda,desc_moneda,simbolo,factor,base,estatus 
        FROM tbmoneda
        WHERE idmoneda= $this->Idmoneda";
        $req=$this->Select($sql);
        return $req;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function InsertDt($cod_moneda,$desc_moneda,$simbolo,$factor,$base){
      $this->Cod_moneda=$cod_moneda;
      $this->Desc_moneda=$desc_moneda;
      $this->Simbolo=$simbolo;
      $this->Factor=$factor;
      $this->Base=$base;
      $this->Estatus='1';
      try{  
        $queryInsert = "INSERT INTO tbmoneda(cod_moneda,desc_moneda,simbolo,factor,base,estatus) VALUES(?,?,?,REPLACE(?,',',''),?,?)";
        $arrData = array($this->Cod_moneda, $this->Desc_moneda, $this->Simbolo,$this->Factor, $this->Base, $this->Estatus);
        $request=$this->Insert($queryInsert,$arrData);
        return $request;
      } catch(PDOException $e){
        return PDOError($e,'insert');
      }
    }

    public function EditarDt($id,$cod_moneda,$desc_moneda,$simbolo,$factor,$base){
      $this->Idmoneda=$id;
      $this->Cod_moneda=$cod_moneda;
      $this->Desc_moneda=$desc_moneda;
      $this->Simbolo=$simbolo;
      $this->Factor=$factor;
      $this->Base=$base;
      try{  
        $sql = "UPDATE tbmoneda 
        SET cod_moneda=?,desc_moneda=?,simbolo=?,factor=REPLACE(?,',',''),base=? WHERE idmoneda='$this->Idmoneda'";
        $arrData = array($this->Cod_moneda, $this->Desc_moneda, $this->Simbolo,$this->Factor, $this->Base);
        $request=$this->Update($sql, $arrData);
        return $request;
      } catch(PDOException $e){
        return PDOError($e,'update');
      }
    }

    public function EstatusDt($id,$st){
      $this->Idmoneda=$id;
      $this->Estatus=$st;
      try {
        $sql="UPDATE tbmoneda SET estatus=? WHERE idmoneda='$this->Idmoneda'";
        $arrData=array($this->Estatus);
        $request=$this->Update($sql,$arrData);
        return $request;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function EliminarDt($id){
      $returnData = "";
      $this->Idmoneda=$id;
      try {
        $sql="DELETE FROM tbmoneda WHERE idmoneda = '$this->Idmoneda'";
        $arrData=array($this->Idmoneda);
        $returnData =$this->Delete($sql,$arrData);
        return $returnData;
      } catch (PDOException $e) {
        return PDOError($e,'delete');
      }
    }

  }