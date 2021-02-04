<?php
  class beneficiarioModel extends MySql{

    private $Idbeneficiario;
    private $Idimpuestoz;
    private $Cod_beneficiario;
    private $Desc_beneficiario;
    private $Rif;
    private $Direccion;
    private $Telefono; 
    private $Fechareg;
    private $Estatus;

    public function __construct(){
      parent::__construct();
    }

    public function SelectDt(){
      $sql="SELECT 
      idbeneficiario,
      idimpuestoz,
      cod_beneficiario,
      desc_beneficiario,
      rif,
      direccion,
      telefono,
      DATE_FORMAT(fechareg,'%d/%m/%Y') AS fechareg,
      estatus 
      FROM
      tbbeneficiario";
      $req=$this->SelectAll($sql);
      return $req;
    }

    public function ListDt(){
      $sql="SELECT 
      idbeneficiario,
      idimpuestoz,
      cod_beneficiario,
      desc_beneficiario,
      rif,
      direccion,
      telefono,
      DATE_FORMAT(fechareg,'%d/%m/%Y') AS fechareg,
      estatus 
      FROM
      tbbeneficiario
      WHERE estatus='1'
      ORDER BY cod_beneficiario ASC";
      $req=$this->SelectAll($sql);
      return $req;
    }

    public function ShowDt($id){
      $this->Idbeneficiario=$id;
      $sql="SELECT 
      idbeneficiario,
      idimpuestoz,
      cod_beneficiario,
      desc_beneficiario,
      rif,
      direccion,
      telefono,
      DATE_FORMAT(fechareg,'%d/%m/%Y') AS fechareg,
      estatus 
      FROM
      tbbeneficiario 
      WHERE idbeneficiario='$this->Idbeneficiario'";
      $req=$this->Select($sql);
      return $req;
    }

    public function EstatusDt($id,$st){
      $this->Idbeneficiario=$id;
      $this->Estatus=$st;

      $sql="UPDATE tbbeneficiario SET estatus=? WHERE idbeneficiario='$this->Idbeneficiario'";
      $arrData=array($this->Estatus);
      $request=$this->Update($sql,$arrData);
      return $request;
    }

    public function InsertDt($Idimpuestoz,$cod_beneficiario,$desc_beneficiario,$rif,$direccion,$telefono,$fechareg){
      $this->Idimpuestoz=$Idimpuestoz;
      $this->Cod_beneficiario=$cod_beneficiario;
      $this->Desc_beneficiario=$desc_beneficiario;
      $this->Rif=$rif;
      $this->Direccion=$direccion;
      $this->Telefono=$telefono; 
      $this->Fechareg=$fechareg;
      $this->Estatus='1';

      try{  
        $queryInsert="INSERT INTO tbbeneficiario(idimpuestoz,cod_beneficiario, desc_beneficiario,rif,direccion,
        telefono,fechareg,estatus) VALUES(?,?,?,?,?,?,?,?)";
        $arrData=array($this->Idimpuestoz,$this->Cod_beneficiario,$this->Desc_beneficiario,$this->Rif,$this->Direccion,
        $this->Telefono,$this->Fechareg,$this->Estatus);
        $this->Insert($queryInsert,$arrData);
        return true;
      } catch(PDOException $e){
        return PDOError($e,'insert');
      }
    }

    public function EditarDt($id,$idimpuestoz,$cod_beneficiario,$desc_beneficiario,$rif,$direccion,$telefono,$fechareg){
      $this->Idbeneficiario=$id;
      $this->Idimpuestoz=$idimpuestoz;
      $this->Cod_beneficiario=$cod_beneficiario;
      $this->Desc_beneficiario=$desc_beneficiario;
      $this->Rif=$rif;
      $this->Direccion=$direccion;
      $this->Telefono=$telefono; 
      $this->Fechareg=$fechareg;  
      try{
        $sql="UPDATE tbbeneficiario SET idimpuestoz=?,cod_beneficiario=?,desc_beneficiario=?,rif=?,direccion=?,
        telefono=?,fechareg=? WHERE idbeneficiario='$this->Idbeneficiario'";
        $arrData=array($this->Idimpuestoz,$this->Cod_beneficiario,$this->Desc_beneficiario,$this->Rif,$this->Direccion,
        $this->Telefono,$this->Fechareg);
        $this->Update($sql,$arrData);
        return true;
      } catch(PDOException $e){
        return PDOError($e,'update');
      }
    }

    public function EliminarDt($id){
      $returnData = "";
      $this->Idbeneficiario=$id;
      try {
        $sql="DELETE FROM tbbeneficiario WHERE idbeneficiario = '$this->Idbeneficiario'";
        $arrData=array($this->Idbeneficiario);
        $returnData =$this->Delete($sql,$arrData);
        return $returnData;
      } catch (PDOException $e) {
        return PDOError($e,'delete');
      }
    }

  }