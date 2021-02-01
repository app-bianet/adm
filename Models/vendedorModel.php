<?php
  class vendedorModel extends MySql{

    private $Idvendedor;
    private $Cod_vendedor;
    private $Desc_vendedor;
    private $Rif;
    private $Direccion;
    private $Telefono; 
    private $Comisionv; 
    private $Comisionc;
    private $Esvendedor;
    private $Escobrador;
    private $Fechareg;
    private $Estatus;

    public function __construct(){
      parent::__construct();
    }

    public function SelectDt(){
      $sql="SELECT idvendedor, cod_vendedor,desc_vendedor,rif,direccion,telefono,comisionv,comisionc, 
      esvendedor,escobrador, DATE_FORMAT(fechareg,'%d/%m/%Y') AS fechareg,estatus FROM tbvendedor";
      $req=$this->SelectAll($sql);
      return $req;
    }

    public function ListDt(){
      $sql="SELECT idvendedor, cod_vendedor,desc_vendedor,rif,direccion,telefono,comisionv,comisionc, 
      esvendedor,escobrador, DATE_FORMAT(fechareg,'%d/%m/%Y') AS fechareg,estatus FROM tbvendedor 
      WHERE estatus='1' ORDER BY cod_vendedor ASC";
      $req=$this->SelectAll($sql);
      return $req;
    }

    public function ShowDt($id){
      $this->Idvendedor=$id;
      $sql="SELECT idvendedor, cod_vendedor,desc_vendedor,rif,direccion,telefono,comisionv,comisionc, 
      esvendedor,escobrador,fechareg,estatus FROM tbvendedor WHERE idvendedor='$this->Idvendedor'";
      $req=$this->Select($sql);
      return $req;
    }

    public function EstatusDt($id,$st){
      $this->Idvendedor=$id;
      $this->Estatus=$st;

      $sql="UPDATE tbvendedor SET estatus=? WHERE idvendedor='$this->Idvendedor'";
      $arrData=array($this->Estatus);
      $request=$this->Update($sql,$arrData);
      return $request;
    }

    public function InsertDt($cod_vendedor,$desc_vendedor,$rif,$direccion,$telefono,$comisionv, 
    $comisionc,$esvendedor,$escobrador,$fechareg){
      $this->Cod_vendedor=$cod_vendedor;
      $this->Desc_vendedor=$desc_vendedor;
      $this->Rif=$rif;
      $this->Direccion=$direccion;
      $this->Telefono=$telefono; 
      $this->Comisionv=$comisionv; 
      $this->Comisionc=$comisionc;
      $this->Esvendedor=$esvendedor;
      $this->Escobrador=$escobrador;
      $this->Fechareg=$fechareg;
      $this->Estatus='1';

      try{  
        $queryInsert="INSERT INTO tbvendedor(cod_vendedor, desc_vendedor,rif,direccion,telefono,comisionv, 
        comisionc,esvendedor,escobrador,fechareg,estatus) VALUES(?,?,?,?,?,?,?,?,?,?,?)";
        $arrData=array($this->Cod_vendedor,$this->Desc_vendedor,$this->Rif,$this->Direccion,$this->Telefono,
        $this->Comisionv,$this->Comisionc,$this->Esvendedor,$this->Escobrador,$this->Fechareg,$this->Estatus);
        $this->Insert($queryInsert,$arrData);
        return true;
      } catch(PDOException $e){
        return PDOError($e,'insert');
      }
    }

    public function EditarDt($id,$cod_vendedor,$desc_vendedor,$rif,$direccion,$telefono,$comisionv, 
    $comisionc,$esvendedor,$escobrador,$fechareg){
      $this->Idvendedor=$id;
      $this->Cod_vendedor=$cod_vendedor;
      $this->Desc_vendedor=$desc_vendedor;
      $this->Rif=$rif;
      $this->Direccion=$direccion;
      $this->Telefono=$telefono; 
      $this->Comisionv=$comisionv; 
      $this->Comisionc=$comisionc;
      $this->Esvendedor=$esvendedor;
      $this->Escobrador=$escobrador;
      $this->Fechareg=$fechareg;  
      try{
        $sql="UPDATE tbvendedor SET cod_vendedor=?,desc_vendedor=?,rif=?,direccion=?,telefono=?,comisionv=?,
        comisionc=?,esvendedor=?,escobrador=?,fechareg=? WHERE idvendedor='$this->Idvendedor'";
        $arrData=array($this->Cod_vendedor,$this->Desc_vendedor,$this->Rif,$this->Direccion,$this->Telefono,
        $this->Comisionv,$this->Comisionc,$this->Esvendedor,$this->Escobrador,$this->Fechareg);
        $this->Update($sql,$arrData);
        return true;
      } catch(PDOException $e){
        return PDOError($e,'update');
      }
    }

    public function EliminarDt($id){
      $returnData = "";
      $this->Idvendedor=$id;

      try {
        $sql="DELETE FROM tbvendedor WHERE idvendedor = '$this->Idvendedor'";
        $arrData=array($this->Idvendedor);
        $returnData =$this->Delete($sql,$arrData);
        return $returnData;
      } catch (PDOException $e) {
        return PDOError($e,'delete');
      }
    }

  }