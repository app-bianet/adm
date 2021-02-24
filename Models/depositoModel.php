<?php
  class depositoModel extends MySql{

    private $Iddeposito;
    private $Cod_deposito;
    private $Desc_deposito;
    private $Responsable;
    private $Direccion;
    private $Solocompra;
    private $Soloventa;
    Private $Fechareg;
    private $Estatus;

    public function __construct(){
      parent::__construct();
    }

    public function SelectDt(){
      try {
        $sql="SELECT iddeposito,cod_deposito,desc_deposito,responsable,direccion,
        solocompra,soloventa,DATE_FORMAT(fechareg,'%d/%m/%Y'),estatus FROM tbdeposito";
        $req=$this->SelectAll($sql);
        return $req;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function ListDt(){
      try {
        $sql="SELECT iddeposito,cod_deposito,desc_deposito,responsable,direccion,
        solocompra,soloventa,DATE_FORMAT(fechareg,'%d/%m/%Y'),estatus FROM tbdeposito 
        WHERE estatus='1' ORDER BY cod_deposito ASC";
        $req=$this->SelectAll($sql);
        return $req;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function ShowDt($id){
      $this->Iddeposito=$id;
      try {
        $sql="SELECT iddeposito,cod_deposito,desc_deposito,responsable,direccion,solocompra,
        soloventa,fechareg,estatus FROM tbdeposito WHERE iddeposito='$this->Iddeposito'";
        $req=$this->Select($sql);
        return $req;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function StockList($id){
      $this->Idarticulo=$id;
      try {
        $sql="SELECT 
        s.iddeposito,
        d.cod_deposito,
        d.desc_deposito,
        IFNULL(s.cantidad,0) AS stock
        FROM tbstock s
        INNER JOIN tbdeposito d ON d.iddeposito=s.iddeposito
        WHERE s.idarticulo='$this->Idarticulo'";
        $req=$this->SelectAll($sql);
        return $req;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }
    

    public function EstatusDt($id,$st){
      $this->Iddeposito=$id;
      $this->Estatus=$st;
      try {
        $sql="UPDATE tbdeposito SET estatus=? WHERE iddeposito='$this->Iddeposito'";
        $arrData=array($this->Estatus);
        $request=$this->Update($sql,$arrData);
        return $request;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function InsertDt($cod_deposito,$desc_deposito,$responsable,$direccion,$solocompra,$soloventa,$fechareg){
      $this->Cod_deposito=$cod_deposito;
      $this->Desc_deposito=$desc_deposito;
      $this->Responsable=$responsable;
      $this->Direccion=$direccion;
      $this->Solocompra=$solocompra;
      $this->Soloventa=$soloventa;
      $this->Fechareg=$fechareg;
      $this->Estatus='1';
      try{  
        $queryInsert="INSERT INTO tbdeposito(cod_deposito, desc_deposito,responsable,direccion,solocompra,soloventa,fechareg,estatus)
         VALUES(?,?,?,?,?,?,?,?)";
        $arrData=array($this->Cod_deposito,$this->Desc_deposito,$this->Responsable,$this->Direccion,$this->Solocompra,
        $this->Soloventa,$this->Fechareg,$this->Estatus);
        $request = $this->Insert($queryInsert,$arrData);
        return $request;
      } catch(PDOException $e){
        return PDOError($e,'insert');
      }
    }

    public function EditarDt($id,$cod_deposito,$desc_deposito,$responsable,$direccion,$solocompra,$soloventa,$fechareg){
      $this->Iddeposito=$id;
      $this->Cod_deposito=$cod_deposito;
      $this->Desc_deposito=$desc_deposito;
      $this->Responsable=$responsable;
      $this->Direccion=$direccion;
      $this->Solocompra=$solocompra;
      $this->Soloventa=$soloventa;
      $this->Fechareg=$fechareg;
      try{  
        $sql="UPDATE tbdeposito SET 
        cod_deposito=?,desc_deposito=?,responsable=?,direccion=?,solocompra=?,soloventa=?,fechareg=? WHERE iddeposito='$this->Iddeposito'";
        $arrData=array($this->Cod_deposito,$this->Desc_deposito,$this->Responsable,$this->Direccion,$this->Solocompra,
        $this->Soloventa,$this->Fechareg);
        $request = $this->Update($sql,$arrData);
        return $request;
      } catch(PDOException $e){
        return PDOError($e,'update');
      }
    }

    public function EliminarDt($id){
      $returnData = "";
      $this->Iddeposito=$id;
      try {
        $sql="DELETE FROM tbdeposito WHERE iddeposito = '$this->Iddeposito'";
        $arrData=array($this->Iddeposito);
        $returnData =$this->Delete($sql,$arrData);
        return $returnData;
      } catch (PDOException $e) {
        return PDOError($e,'delete');
      }
    }

  }