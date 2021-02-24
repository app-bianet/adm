<?php
  class cuentaModel extends MySql{

    private $Idcuenta;
    private $Idbanco;
    private $Cod_cuenta;
    private $Desc_cuenta;
    private $Tipo;
    private $Numcuenta;
    private $Agencia;
    private $Ejecutivo;
    private $Direccion;
    private $Telefono;
    private $Email;
    private $Saldod;
    private $Saldoh;
    private $Saldot;
    private $Mostrar;
    private $Fechareg;
    private $Estatus;

    public function __construct(){
      parent::__construct();
    }

    public function SelectDt(){
      try {
        $sql="SELECT
        c.idcuenta,
        c.idbanco,
        c.cod_cuenta,
        c.desc_cuenta,
        c.tipo,
        c.numcuenta,
        b.cod_banco,
        b.desc_banco,
        m.cod_moneda,
        m.desc_moneda,
        m.simbolo,
        c.agencia,
        c.ejecutivo,
        c.direccion,
        c.telefono,
        c.email,
        c.mostrar,
        c.saldod,
        c.saldoh,
        c.saldot,
        DATE_FORMAT(c.fechareg,'%d/%m/%Y') AS fechareg,
        c.estatus
        FROM tbcuenta c
        INNER JOIN tbbanco AS b ON (b.idbanco=c.idbanco)
        INNER JOIN tbmoneda AS m ON (m.idmoneda=b.idmoneda)";
        $req=$this->SelectAll($sql);
        return $req;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function ListDt(){;
      try {
        $sql="SELECT
        c.idcuenta,
        c.idbanco,
        c.cod_cuenta,
        c.desc_cuenta,
        c.tipo,
        c.numcuenta,
        b.cod_banco,
        b.desc_banco,
        m.cod_moneda,
        m.desc_moneda,
        m.simbolo,
        c.agencia,
        c.ejecutivo,
        c.direccion,
        c.telefono,
        c.email,
        c.mostrar,
        c.saldod,
        c.saldoh,
        c.saldot,
        DATE_FORMAT(c.fechareg,'%d/%m/%Y') AS fechareg,
        c.estatus
        FROM tbcuenta c
        INNER JOIN tbbanco AS b ON (b.idbanco=c.idbanco)
        INNER JOIN tbmoneda AS m ON (m.idmoneda=b.idmoneda)
        WHERE c.estatus='1'
        ORDER BY c.cod_cuenta ASC";
        $req=$this->SelectAll($sql);
        return $req;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function ShowDt($id){
      $this->Idcuenta=$id;
      try {
        $sql="SELECT
        c.idcuenta,
        c.idbanco,
        c.cod_cuenta,
        c.desc_cuenta,
        c.tipo,
        c.numcuenta,
        b.cod_banco,
        b.desc_banco,
        m.cod_moneda,
        m.desc_moneda,
        m.simbolo,
        c.agencia,
        c.ejecutivo,
        c.direccion,
        c.telefono,
        c.email,
        c.mostrar,
        c.saldod,
        c.saldoh,
        c.saldot,
        DATE_FORMAT(c.fechareg,'%d/%m/%Y') AS fechareg,
        c.estatus
        FROM tbcuenta c
        INNER JOIN tbbanco AS b ON (b.idbanco=c.idbanco)
        INNER JOIN tbmoneda AS m ON (m.idmoneda=b.idmoneda) 
        WHERE c.idcuenta='$this->Idcuenta'";
        $req=$this->Select($sql);
        return $req;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }
   
    public function EstatusDt($id,$st){
      $this->Idcuenta=$id;
      $this->Estatus=$st;
      try {
        $sql="UPDATE tbcuenta SET estatus=? WHERE idcuenta='$this->Idcuenta'";
        $arrData=array($this->Estatus);
        $request=$this->Update($sql,$arrData);
        return $request;
      } catch (PDOException $e){
        return PDOError($e,'');
      }
    }

    public function InsertDt($idbanco,$cod_cuenta,$desc_cuenta,$tipo,$numcuenta,$agencia,$ejecutivo,$direccion,
      $telefono,$email,$mostrar,$fechareg){
      $this->Idbanco=$idbanco;
      $this->Cod_cuenta=$cod_cuenta;
      $this->Desc_cuenta=$desc_cuenta;
      $this->Tipo=$tipo;
      $this->Numcuenta=$numcuenta;
      $this->Agencia=$agencia;
      $this->Ejecutivo=$ejecutivo;
      $this->Direccion=$direccion;
      $this->Telefono=$telefono;
      $this->Email=$email;
      $this->Mostrar=$mostrar;
      $this->Fechareg=$fechareg;
      $this->Saldod=0;
      $this->Saldoh=0;
      $this->Saldot=0;
      $this->Estatus='1';
      try{  
        $sql="INSERT INTO tbcuenta(idbanco,cod_cuenta,desc_cuenta,tipo,numcuenta,agencia,ejecutivo,direccion,
        telefono,email,mostrar,fechareg,saldod,saldoh,saldot,estatus) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $arrData=array($this->Idbanco,$this->Cod_cuenta,$this->Desc_cuenta,$this->Tipo,$this->Numcuenta,$this->Agencia,
        $this->Ejecutivo,$this->Direccion,$this->Telefono,$this->Email,$this->Mostrar,$this->Fechareg,$this->Saldod,
        $this->Saldoh,$this->Saldot,$this->Estatus);
        $request = $this->Insert($sql,$arrData);
        return $request;
      } catch(PDOException $e){
        return PDOError($e,'insert');
      }
    }

    public function EditarDt($id,$idbanco,$cod_cuenta,$desc_cuenta,$tipo,$numcuenta,$agencia,$ejecutivo,$direccion,
      $telefono,$email,$mostrar,$fechareg){
      $this->Idcuenta=$id;
      $this->Idbanco=$idbanco;
      $this->Cod_cuenta=$cod_cuenta;
      $this->Desc_cuenta=$desc_cuenta;
      $this->Tipo=$tipo;
      $this->Numcuenta=$numcuenta;
      $this->Agencia=$agencia;
      $this->Ejecutivo=$ejecutivo;
      $this->Direccion=$direccion;
      $this->Telefono=$telefono;
      $this->Email=$email;
      $this->Mostrar=$mostrar;
      $this->Fechareg=$fechareg;
      try{
        $sql="UPDATE tbcuenta SET idbanco =?,cod_cuenta =?,desc_cuenta =?,tipo =?,numcuenta =?,agencia =?,
        ejecutivo =?,direccion =?,telefono =?,email = ?,mostrar = ?,fechareg =? WHERE idcuenta='$this->Idcuenta'";
        $arrData=array($this->Idbanco,$this->Cod_cuenta,$this->Desc_cuenta,$this->Tipo,$this->Numcuenta,$this->Agencia,
        $this->Ejecutivo,$this->Direccion,$this->Telefono,$this->Email,$this->Mostrar,$this->Fechareg);
        $request = $this->Update($sql,$arrData);
        return $request;
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