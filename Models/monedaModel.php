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
      $sql="SELECT * FROM tbmoneda";
      $req=$this->SelectAll($sql);
      return $req;
    }

    public function ListDt(){
      $sql="SELECT * FROM tbmoneda WHERE estatus='1'  ORDER BY cod_moneda ASC";
      $req=$this->SelectAll($sql);
      return $req;
    }

    public function ListDtBase(){
      $sql="SELECT * 
      FROM tbmoneda
      WHERE base='1'";
      $req=$this->Select($sql);
      return $req;
    }

    public function ShowDt($id){
      $this->Idmoneda=$id;
      $sql="SELECT * 
      FROM tbmoneda
      WHERE idmoneda= $this->Idmoneda";
      $req=$this->Select($sql);
      return $req;
    }

    public function InsertDt($cod_moneda,$desc_moneda,$simbolo,$factor,$base){
      $this->Cod_moneda=$cod_moneda;
      $this->Desc_moneda=$desc_moneda;
      $this->Simbolo=$simbolo;
      $this->Factor=$factor;
      $this->Base=$base;
      $this->Estatus='1';
      //Verificamos si Existe Moneeda Base
      try{  
          $queryInsert = "INSERT INTO tbmoneda(cod_moneda,desc_moneda,simbolo,factor,base,estatus) VALUES(?,?,?,REPLACE(?,',',''),?,?)";
          $arrData = array($this->Cod_moneda, $this->Desc_moneda, $this->Simbolo,$this->Factor, $this->Base, $this->Estatus);
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
        $this->Update($sql, $arrData);
        return true;
      } catch(PDOException $e){
        if($e->getCode()=='23000'){
          return 'duplicado';
        } else {
          return 'error_update';
        }
      }
    }

    public function EstatusDt($id,$st){
      $this->Idmoneda=$id;
      $this->Estatus=$st;

      $sql="UPDATE tbmoneda SET estatus=? WHERE idmoneda='$this->Idmoneda'";
      $arrData=array($this->Estatus);
      $request=$this->Update($sql,$arrData);
      return $request;
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
        if($e->getCode()=='23000'){
          return 'duplicado';
        } else {
          return 'error_delete';
        }
      }
    }

  }