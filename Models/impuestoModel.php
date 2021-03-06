<?php
  class impuestoModel extends MySql{
    private $Idimpuesto;
    private $Cod_impuesto;
    private $Desc_impuesto;
    private $Simbolo;
    private $Tasa;
    private $Fechareg;
    private $Estatus;

    public function __construct(){
      parent::__construct();
    }

    public function SelectDt(){
      try {
        $sql="SELECT idimpuesto, cod_impuesto, desc_impuesto, simbolo, tasa, DATE_FORMAT(fechareg,'%d/%m/%Y') AS fechareg, estatus 
        FROM tbimpuesto";
        $req=$this->SelectAll($sql);
        return $req;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function ListDt(){
      try {
        $sql="SELECT idimpuesto, cod_impuesto, desc_impuesto, simbolo, tasa, DATE_FORMAT(fechareg,'%d/%m/%Y') AS fechareg, estatus 
        FROM tbimpuesto WHERE estatus='1' ORDER BY cod_impuesto ASC";
        $req=$this->SelectAll($sql);
        return $req;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function ShowDt($id){
      $this->Idimpuesto=$id;
      try {
        $sql="SELECT idimpuesto, cod_impuesto, desc_impuesto, simbolo, tasa, DATE_FORMAT(fechareg,'%d/%m/%Y') AS fechareg, estatus
        FROM tbimpuesto WHERE idimpuesto='$this->Idimpuesto'";
        $req=$this->Select($sql);
        return $req;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function EstatusDt($id,$st){
      $this->Idimpuesto=$id;
      $this->Estatus=$st;
      try {   
        $sql="UPDATE tbimpuesto SET estatus=? WHERE idimpuesto='$this->Idimpuesto'";
        $arrData=array($this->Estatus);
        $request=$this->Update($sql,$arrData);
        return $request;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function InsertDt($cod_impuesto,$desc_impuesto,$simbolo,$tasa,$fechareg){
      $this->Cod_impuesto=$cod_impuesto;
      $this->Desc_impuesto=$desc_impuesto;
      $this->Simbolo=$simbolo;
      $this->Tasa=$tasa;
      $this->Fechareg=$fechareg;
      $this->Estatus='1';
      try{  
        $queryInsert="INSERT INTO tbimpuesto(cod_impuesto, desc_impuesto,simbolo,REPLACE(?,',',''),fechareg,estatus) 
        VALUES(?,?,?,?,?)";
        $arrData=array($this->Cod_impuesto, $this->Desc_impuesto, $this->Simbolo, $this->Tasa,$this->Fechareg, $this->Estatus);
        $request=$this->Insert($queryInsert,$arrData);
        return $request;
      } catch(PDOException $e){
        return PDOError($e,'insert');
      }
    }

    public function EditarDt($id,$cod_impuesto,$desc_impuesto,$simbolo,$tasa,$fechareg){
      $this->Idimpuesto=$id;
      $this->Cod_impuesto=$cod_impuesto;
      $this->Desc_impuesto=$desc_impuesto;
      $this->Simbolo=$simbolo;
      $this->Fechareg=$fechareg;
      $this->Tasa=$tasa;
      try{  
        $sql="UPDATE tbimpuesto 
        SET cod_impuesto=?,desc_impuesto=?,simbolo=?,tasa=REPLACE(?,',',''),fechareg=? WHERE idimpuesto='$this->Idimpuesto'";
        $arrData=array($this->Cod_impuesto,$this->Desc_impuesto, $this->Simbolo, $this->Tasa, $this->Fechareg);
        $request=$this->Update($sql,$arrData);
        return $request;
      } catch(PDOException $e){
        return PDOError($e,'update');
      }
    }

    public function EliminarDt($id){
      $returnData = "";
      $this->Idimpuesto=$id;
      try {
        $sql="DELETE FROM tbimpuesto WHERE idimpuesto = '$this->Idimpuesto'";
        $arrData=array($this->Idimpuesto);
        $returnData =$this->Delete($sql,$arrData);
        return $returnData;
      } catch (PDOException $e) {
        return PDOError($e,'delete');
      }
    }

  }